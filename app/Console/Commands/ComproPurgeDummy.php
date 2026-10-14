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
    protected $signature = 'compro:purge-dummy 
                            {--dry-run : Menampilkan daftar record yang akan dihapus tanpa menghapusnya}
                            {--force : Jalankan pembersihan tanpa konfirmasi interaktif}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan record dummy seeder lama (artikel, testimoni lama/JADISATU, stats fiktif, admin lama) dari database Compro';

    /**
     * Explicit lists of dummy records to purge.
     */
    protected array $explicitStorySlugs = [
        'zat-pewarna-alami-sikka',
        'musim-tanam-tetua-adat-sasak',
        'arsitektur-kayu-tanpa-paku',
    ];

    protected array $explicitTestimonialNames = [
        'M. Taufik Hidayat',
        'Dr. Ratih Kumalasari, M.Hum.',
        'Drs. Ignatius Suryanto',
        'Wonosadi Elder',
        'Ki Joko Sudarmo',
    ];

    protected array $explicitStatsLabels = [
        'Tapak Riset Terkurasi',
        'Pelajar & Peneliti Terfasilitasi',
        'Kemitraan Berbasis Etika FPIC',
        'Modul Pembelajaran Lapangan Aktif',
    ];

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
        $isDryRun = (bool) $this->option('dry-run');

        if ($isDryRun) {
            $this->info('=== [DRY RUN] PEMERIKSAAN RECORD DUMMY COMPRO ===');
        } else {
            $this->info('Memulai pembersihan data dummy di Destinara Compro...');
        }

        $candidates = [
            'testimonials' => $this->findTestimonialCandidates(),
            'stories' => $this->findStoryCandidates(),
            'stats' => $this->findStatCandidates(),
            'users' => $this->findUserCandidates(),
        ];

        $totalCandidates = 0;
        foreach ($candidates as $table => $rows) {
            $totalCandidates += count($rows);
        }

        if ($isDryRun) {
            $rows = [];
            foreach ($candidates as $table => $items) {
                foreach ($items as $item) {
                    $rows[] = [
                        $table,
                        $item->id ?? '-',
                        $item->identifier ?? '-',
                        $item->details ?? '-',
                    ];
                }
            }

            if (! empty($rows)) {
                $this->table(['Tabel', 'ID', 'Identifier', 'Keterangan'], $rows);
            }

            $this->info("[DRY RUN SELESAI] Ditemukan {$totalCandidates} record dummy seeder lama. Tidak ada record yang dihapus.");

            return Command::SUCCESS;
        }

        if ($totalCandidates === 0) {
            $this->info('Tidak ditemukan record dummy seeder lama untuk dibersihkan.');

            return Command::SUCCESS;
        }

        if (! $this->option('force')) {
            if ($this->input->isInteractive() && ! app()->environment('testing')) {
                if (! $this->confirm("Ditemukan {$totalCandidates} record dummy. Apakah Anda yakin ingin menghapusnya secara permanen?")) {
                    $this->warn('Pembersihan dibatalkan oleh pengguna.');

                    return Command::SUCCESS;
                }
            }
        }

        // Perform actual deletion
        $totalPurged = 0;

        foreach ($candidates as $table => $items) {
            $count = count($items);
            if ($count > 0 && Schema::hasTable($table)) {
                $ids = array_map(fn ($i) => $i->id, $items);
                DB::table($table)->whereIn('id', $ids)->delete();
            }

            $this->line("• {$table}: {$count} record dihapus.");
            $totalPurged += $count;
        }

        $this->info("Pembersihan selesai! Total {$totalPurged} record dummy dihapus.");

        return Command::SUCCESS;
    }

    protected function findTestimonialCandidates(): array
    {
        if (! Schema::hasTable('testimonials')) {
            return [];
        }

        $columns = Schema::getColumnListing('testimonials');
        $hasRole = in_array('role', $columns, true);
        $hasCompany = in_array('company', $columns, true);
        $hasInstitution = in_array('institution', $columns, true);

        $query = DB::table('testimonials')->where(function ($q) use ($hasRole, $hasCompany, $hasInstitution) {
            $q->whereIn('name', $this->explicitTestimonialNames);

            foreach ($this->forbiddenKeywords as $keyword) {
                $q->orWhere('name', 'LIKE', "%{$keyword}%");
                $q->orWhere('quote', 'LIKE', "%{$keyword}%");

                if ($hasRole) {
                    $q->orWhere('role', 'LIKE', "%{$keyword}%");
                }
                if ($hasCompany) {
                    $q->orWhere('company', 'LIKE', "%{$keyword}%");
                }
                if ($hasInstitution) {
                    $q->orWhere('institution', 'LIKE', "%{$keyword}%");
                }
            }
        });

        return $query->get()->map(function ($row) use ($hasCompany, $hasInstitution) {
            $company = $hasCompany ? ($row->company ?? '') : ($hasInstitution ? ($row->institution ?? '') : '');

            return (object) [
                'id' => $row->id,
                'identifier' => $row->name,
                'details' => $company ?: substr($row->quote ?? '', 0, 40),
            ];
        })->all();
    }

    protected function findStoryCandidates(): array
    {
        if (! Schema::hasTable('stories')) {
            return [];
        }

        $query = DB::table('stories')->where(function ($q) {
            $q->whereIn('slug', $this->explicitStorySlugs);

            foreach ($this->forbiddenKeywords as $keyword) {
                $q->orWhere('title', 'LIKE', "%{$keyword}%");
                $q->orWhere('slug', 'LIKE', "%{$keyword}%");
            }
        });

        return $query->get()->map(function ($row) {
            return (object) [
                'id' => $row->id,
                'identifier' => $row->slug,
                'details' => $row->title,
            ];
        })->all();
    }

    protected function findStatCandidates(): array
    {
        if (! Schema::hasTable('stats')) {
            return [];
        }

        $query = DB::table('stats')->where(function ($q) {
            $q->whereIn('label', $this->explicitStatsLabels);

            foreach ($this->forbiddenKeywords as $keyword) {
                $q->orWhere('label', 'LIKE', "%{$keyword}%");
                $q->orWhere('value', 'LIKE', "%{$keyword}%");
            }
        });

        return $query->get()->map(function ($row) {
            return (object) [
                'id' => $row->id,
                'identifier' => $row->value,
                'details' => $row->label,
            ];
        })->all();
    }

    protected function findUserCandidates(): array
    {
        if (! Schema::hasTable('users')) {
            return [];
        }

        $adminEmail = config('admin.email');
        $hasIsAdmin = Schema::hasColumn('users', 'is_admin');

        $query = DB::table('users')->where(function ($q) {
            $q->where('email', 'admin@destinara.id');

            foreach ($this->forbiddenKeywords as $keyword) {
                $q->orWhere('email', 'LIKE', "%{$keyword}%");
                $q->orWhere('name', 'LIKE', "%{$keyword}%");
            }
        });

        if (! empty($adminEmail)) {
            $query->where('email', '!=', $adminEmail);
        }

        $candidates = $query->get();

        if ($hasIsAdmin) {
            $totalAdmins = DB::table('users')->where('is_admin', true)->count();
            $remainingAdmins = $totalAdmins;
            $filtered = [];

            foreach ($candidates as $user) {
                if ($user->is_admin) {
                    if ($remainingAdmins <= 1) {
                        continue;
                    }
                    $remainingAdmins--;
                }
                $filtered[] = $user;
            }

            $candidates = collect($filtered);
        }

        return $candidates->map(function ($row) {
            return (object) [
                'id' => $row->id,
                'identifier' => $row->email,
                'details' => $row->name,
            ];
        })->all();
    }
}
