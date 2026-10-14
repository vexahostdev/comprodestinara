<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ComproPlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_is_closed(): void
    {
        $this->get('/register')->assertStatus(404);
        $this->post('/register', [
            'name' => 'Intruder',
            'email' => 'intruder@test.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ])->assertStatus(404);
    }

    public function test_non_admin_cannot_access_admin_portal(): void
    {
        $regularUser = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($regularUser)
            ->get('/admin')
            ->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_portal(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200);
    }

    public function test_storage_route_blocks_directory_traversal(): void
    {
        $res1 = $this->get('/storage/../../../../etc/passwd');
        $this->assertTrue(in_array($res1->getStatusCode(), [403, 404]));

        $res2 = $this->get('/storage/..%2F..%2F..%2F.env');
        $this->assertTrue(in_array($res2->getStatusCode(), [403, 404]));
    }

    public function test_admin_clear_cache_requires_post_and_admin_auth(): void
    {
        // Guest cannot access
        $this->post('/admin/clear-cache')->assertRedirect('/login');

        $admin = User::factory()->create(['is_admin' => true]);

        // GET method not allowed
        $this->actingAs($admin)->get('/admin/clear-cache')->assertStatus(405);

        // POST method succeeds and redirects back with alert
        $response = $this->actingAs($admin)->post('/admin/clear-cache');
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_compro_purge_dummy_command_removes_forbidden_records(): void
    {
        // Insert dummy testimonial
        Testimonial::create([
            'name' => 'Wonosadi Elder',
            'role' => 'Pemangku Hutan',
            'institution' => 'Wonosadi',
            'quote' => 'Dummy testimonial with Wonosadi text',
            'is_active' => true,
            'order' => 99,
        ]);

        // Insert clean testimonial
        Testimonial::create([
            'name' => 'Prof. Budi Santoso',
            'role' => 'Peneliti Lapangan',
            'institution' => 'UGM',
            'quote' => 'Testimoni nyata tanpa kata terlarang.',
            'is_active' => true,
            'order' => 1,
        ]);

        $this->artisan('compro:purge-dummy')
            ->expectsOutputToContain('testimonials: 1 record dihapus.')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('testimonials', ['name' => 'Wonosadi Elder']);
        $this->assertDatabaseHas('testimonials', ['name' => 'Prof. Budi Santoso']);
    }

    public function test_compro_purge_dummy_purges_ki_joko_sudarmo_and_role_keywords(): void
    {
        // 1. Explicit testimonial name: Ki Joko Sudarmo (even without forbidden text in quote)
        Testimonial::create([
            'name' => 'Ki Joko Sudarmo',
            'role' => 'Tetua Desa',
            'institution' => 'Komunitas Lokal',
            'quote' => 'Menjaga kelestarian alam dan kearifan masa lalu.',
            'is_active' => true,
            'order' => 10,
        ]);

        // 2. Testimonial with forbidden keyword in role column
        Testimonial::create([
            'name' => 'Slamet Raharjo',
            'role' => 'Pemandu Tapak Wonosadi',
            'institution' => 'Kelompok Sadar Wisata',
            'quote' => 'Ekowisata berbasis riset.',
            'is_active' => true,
            'order' => 11,
        ]);

        $this->artisan('compro:purge-dummy')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('testimonials', ['name' => 'Ki Joko Sudarmo']);
        $this->assertDatabaseMissing('testimonials', ['name' => 'Slamet Raharjo']);
    }

    public function test_compro_purge_dummy_skips_config_admin_email_and_preserves_sole_admin(): void
    {
        config(['admin.email' => 'active_admin@destinara.id']);

        // 1. User with email matching config('admin.email') even if it has a forbidden keyword in name
        $primaryAdmin = User::factory()->create([
            'name' => 'Wonosadi Guardian Admin',
            'email' => 'active_admin@destinara.id',
            'is_admin' => true,
        ]);

        // 2. Another dummy non-admin matching keyword
        $dummyUser = User::factory()->create([
            'name' => 'Penglipuran Fake User',
            'email' => 'dummy_penglipuran@destinara.id',
            'is_admin' => false,
        ]);

        $this->artisan('compro:purge-dummy')
            ->assertExitCode(0);

        // Primary admin matching config('admin.email') is preserved!
        $this->assertDatabaseHas('users', ['id' => $primaryAdmin->id]);
        // Dummy non-admin is purged
        $this->assertDatabaseMissing('users', ['id' => $dummyUser->id]);

        // 3. Test sole admin protection:
        // Even if config('admin.email') is different, the ONLY remaining admin must NEVER be deleted
        config(['admin.email' => 'other_system@destinara.id']);
        $primaryAdmin->update(['email' => 'admin123@destinara.id']); // matches forbidden keyword admin123

        // Verify it is the only admin
        $this->assertEquals(1, User::where('is_admin', true)->count());

        $this->artisan('compro:purge-dummy')
            ->assertExitCode(0);

        // Sole admin is still preserved!
        $this->assertDatabaseHas('users', ['id' => $primaryAdmin->id]);
    }

    public function test_public_destinations_fetch_from_core_system_api(): void
    {
        Http::fake([
            '*/api/v1/public/destinations*' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Desa Wisata Nglanggeran',
                        'slug' => 'desa-wisata-nglanggeran',
                        'category' => 'ekologi',
                        'badge' => 'Gunung Api Purba',
                        'location' => 'Gunungkidul',
                        'lead' => 'Laboratorium geologi dan ekowisata mandiri.',
                        'thumbnail_url' => 'https://via.placeholder.com/600',
                        'packages_count' => 3,
                        'min_price' => 150000,
                        'booking_url' => 'https://layanan.destinara.my.id/buyer/booking/create?destinasi=desa-wisata-nglanggeran',
                    ],
                ],
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 9,
                    'total' => 1,
                ],
            ], 200),
            '*/api/v1/public/categories' => Http::response([
                'success' => true,
                'data' => [
                    ['value' => 'ekologi', 'label' => 'Ekologi & Lanskap', 'count' => 1],
                ],
            ], 200),
        ]);

        $response = $this->get('/destinasi');

        $response->assertStatus(200);
        $response->assertSee('Desa Wisata Nglanggeran');
    }

    public function test_public_destination_detail_fetches_from_core_system_api(): void
    {
        Http::fake([
            '*/api/v1/public/destinations/desa-wisata-nglanggeran' => Http::response([
                'success' => true,
                'data' => [
                    'id' => 1,
                    'name' => 'Desa Wisata Nglanggeran',
                    'slug' => 'desa-wisata-nglanggeran',
                    'category' => 'ekologi',
                    'badge' => 'Gunung Api Purba',
                    'location' => 'Gunungkidul',
                    'lead' => 'Laboratorium geologi dan ekowisata mandiri.',
                    'description' => 'Deskripsi lengkap tapak geologi purba.',
                    'research_focus' => 'Geowisata dan tata kelola berbasis masyarakat.',
                    'capacity' => 40,
                    'cover_image_url' => 'https://via.placeholder.com/1200',
                    'gallery_urls' => [],
                    'facilities' => ['Toilet', 'Pendopo'],
                    'packages' => [
                        [
                            'id' => 1,
                            'name' => 'Paket Studi Geologi',
                            'price' => 250000,
                            'price_formatted' => 'Rp 250.000',
                            'duration_days' => 1,
                        ],
                    ],
                    'booking_url' => 'https://layanan.destinara.my.id/buyer/booking/create?destinasi=desa-wisata-nglanggeran',
                ],
            ], 200),
            '*/api/v1/public/destinations*' => Http::response([
                'success' => true,
                'data' => [],
            ], 200),
        ]);

        $response = $this->get('/destinasi/desa-wisata-nglanggeran');

        $response->assertStatus(200);
        $response->assertSee('Desa Wisata Nglanggeran');
        $response->assertSee('Paket Studi Geologi');
    }

    public function test_destination_detail_returns_404_when_api_returns_404(): void
    {
        Http::fake([
            '*/api/v1/public/destinations/non-existent-tapak' => Http::response([
                'success' => false,
                'message' => 'Destinasi tidak ditemukan',
            ], 404),
        ]);

        $response = $this->get('/destinasi/non-existent-tapak');

        $response->assertStatus(404);
    }
}
