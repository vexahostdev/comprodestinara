<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ComproPurgeDummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compro:purge-dummy {--force : Jalankan pembersihan tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan record dummy (Wonosadi, Penglipuran, Suryadi, JADISATU, admin123) dari database Compro';

    /**
     * Kata kunci dummy terlarang sesuai SPEC §19.2.
     *
     * @var array<string>
     */
    protected array $forbiddenKeywords = [
        'Wonosadi',
        'Penglipuran',
        'Suryadi',
        'JADISATU',
        'admin123',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai pembersihan data dummy di Destinara Compro...');

        $totalPurged = 0;

        // 1. Testimonials
        if (Schema::hasTable('testimonials')) {
            $purged = $this->purgeTable('testimonials', ['name', 'role', 'institution', 'quote']);
            $this->line("• testimonials: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        // 2. Stories
        if (Schema::hasTable('stories')) {
            $purged = $this->purgeTable('stories', ['title', 'slug', 'excerpt', 'content', 'author_name']);
            $this->line("• stories: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        // 3. Stats
        if (Schema::hasTable('stats')) {
            $purged = $this->purgeTable('stats', ['label', 'value']);
            $this->line("• stats: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        // 4. Users (kecuali admin valid yang tidak memakai kata terlarang)
        if (Schema::hasTable('users')) {
            $purged = $this->purgeTable('users', ['email', 'name']);
            $this->line("• users: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        // 5. Destinations (jika tabel masih ada)
        if (Schema::hasTable('destinations')) {
            $purged = $this->purgeTable('destinations', ['name', 'slug', 'lead', 'description']);
            $this->line("• destinations: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        // 6. Site Settings
        if (Schema::hasTable('site_settings')) {
            $purged = $this->purgeTable('site_settings', ['key', 'value']);
            $this->line("• site_settings: {$purged} record dihapus.");
            $totalPurged += $purged;
        }

        $this->info("Pembersihan selesai! Total {$totalPurged} record dummy dihapus.");

        return Command::SUCCESS;
    }

    /**
     * Purge rows in a table where any given column matches any forbidden keyword.
     *
     * @param  array<string>  $columns
     */
    protected function purgeTable(string $table, array $columns): int
    {
        $existingColumns = Schema::getColumnListing($table);
        $validColumns = array_intersect($columns, $existingColumns);

        if (empty($validColumns)) {
            return 0;
        }

        $query = DB::table($table);

        $query->where(function ($q) use ($validColumns) {
            foreach ($this->forbiddenKeywords as $keyword) {
                foreach ($validColumns as $col) {
                    $q->orWhere($col, 'LIKE', "%{$keyword}%");
                }
            }
        });

        $count = $query->count();
        if ($count > 0) {
            $query->delete();
        }

        return $count;
    }
}
