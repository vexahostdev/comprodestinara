<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LegalDocumentController extends Controller
{
    /**
     * Peta dokumen resmi Destinara.
     */
    protected array $documents = [
        'tos' => [
            'title_id' => 'Syarat & Ketentuan Layanan',
            'title_en' => 'Terms of Service',
            'filename' => 'Destinara-ToS-v1.0-Final.pdf',
            'version' => '1.0 (Final)',
            'updated' => 'September 2026',
        ],
        'privacy' => [
            'title_id' => 'Kebijakan Privasi',
            'title_en' => 'Privacy Policy',
            'filename' => 'Destinara-KebijakanPrivasi-v1.0.pdf',
            'version' => '1.0',
            'updated' => 'September 2026',
        ],
    ];

    /**
     * Halaman Syarat & Ketentuan (Terms of Service).
     */
    public function terms()
    {
        $doc = $this->documents['tos'];

        return view('legal.terms', [
            'doc' => $doc,
            'streamUrl' => route('legal.stream', 'tos'),
            'downloadUrl' => route('legal.download', 'tos'),
        ]);
    }

    /**
     * Halaman Kebijakan Privasi.
     */
    public function privacy()
    {
        $doc = $this->documents['privacy'];

        return view('legal.privacy', [
            'doc' => $doc,
            'streamUrl' => route('legal.stream', 'privacy'),
            'downloadUrl' => route('legal.download', 'privacy'),
        ]);
    }

    public function privacyId()
    {
        return $this->privacy();
    }

    public function privacyEn()
    {
        app()->setLocale('en');
        session(['locale' => 'en']);

        return $this->privacy();
    }

    /**
     * Stream file PDF ke browser dengan header Content-Disposition: inline (tidak auto-download).
     */
    public function stream(string $type): BinaryFileResponse
    {
        $type = $this->normalizeType($type);
        $path = $this->resolveFilePath($type);
        $doc = $this->documents[$type];

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$doc['filename'].'"',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Download file PDF secara langsung.
     */
    public function download(string $type): BinaryFileResponse
    {
        $type = $this->normalizeType($type);
        $path = $this->resolveFilePath($type);
        $doc = $this->documents[$type];

        return response()->download($path, $doc['filename'], [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Normalisasi tipe dokumen (support legacy route types).
     */
    protected function normalizeType(string $type): string
    {
        if ($type === 'privacy-id' || $type === 'privacy-en') {
            return 'privacy';
        }

        return $type;
    }

    /**
     * Mencari path file fisik dokumen.
     */
    protected function resolveFilePath(string $type): string
    {
        $type = $this->normalizeType($type);

        if (! array_key_exists($type, $this->documents)) {
            abort(404, 'Dokumen resmi tidak ditemukan.');
        }

        $filename = $this->documents[$type]['filename'];

        // Cek public/documents terlebih dahulu, lalu fallback ke document/ di root
        $candidates = [
            public_path('documents/'.$filename),
            base_path('document/'.$filename),
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        abort(404, 'Berkas fisik PDF dokumen belum diunggah ke server.');
    }
}
