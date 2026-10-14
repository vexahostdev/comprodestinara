<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Direct static file server for /storage/... (bypasses symlink and framework cache)
if (isset($_SERVER['REQUEST_URI']) && str_starts_with($_SERVER['REQUEST_URI'], '/storage/')) {
    $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $subPath = ltrim(preg_replace('#^/storage/#', '', $uriPath), '/');
    if ($subPath) {
        $candidates = [
            __DIR__.'/storage/'.$subPath,
            __DIR__.'/../repositories/meraki-jadisatucompro/storage/app/public/'.$subPath,
            __DIR__.'/../repositories/meraki-jadisatucompro/public/storage/'.$subPath,
            '/home/jadj3934/repositories/meraki-jadisatucompro/storage/app/public/'.$subPath,
            '/home/jadj3934/repositories/meraki-jadisatucompro/public/storage/'.$subPath,
            '/home/jadj3934/public_html/storage/'.$subPath,
        ];
        foreach ($candidates as $filePath) {
            if (file_exists($filePath) && is_file($filePath)) {
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $mimes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    'svg' => 'image/svg+xml',
                    'ico' => 'image/x-icon',
                    'pdf' => 'application/pdf',
                ];
                $contentType = $mimes[$ext] ?? (@mime_content_type($filePath) ?: 'application/octet-stream');
                header('Content-Type: '.$contentType);
                header('Content-Length: '.filesize($filePath));
                header('Cache-Control: public, max-age=31536000');
                readfile($filePath);
                exit;
            }
        }
    }
}

// Auto-detect lokasi folder aplikasi Laravel (baik di local, cPanel public_html, atau subfolder)
$possiblePaths = [
    __DIR__.'/../repositories/meraki-jadisatucompro',
    __DIR__.'/../repositories/jadisatu',
    __DIR__.'/../jadisatu',
    __DIR__.'/..',
];

$appPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path.'/vendor/autoload.php')) {
        $appPath = realpath($path);
        break;
    }
}

if (! $appPath) {
    http_response_code(500);
    exit('<div style="font-family:system-ui,sans-serif;padding:30px;max-width:700px;margin:50px auto;border:2px solid #ef4444;border-radius:10px;background:#fef2f2;color:#991b1b;line-height:1.6;">
        <h2 style="margin-top:0;color:#b91c1c;">⚠️ Folder Vendor Belum Ada di Server</h2>
        <p>Laravel membutuhkan folder <code>vendor/</code> untuk berjalan.</p>
        <p><strong>Cara Memperbaiki (1 Menit):</strong></p>
        <ol style="padding-left:20px;">
            <li>Buka <b>cPanel File Manager</b> &rarr; masuk ke folder repo Anda: <code>/home/jadj3934/repositories/meraki-jadisatucompro/</code></li>
            <li>Klik tombol <b>Upload</b> &rarr; upload file <code>vendor.zip</code> dari laptop Anda.</li>
            <li>Setelah terupload, klik kanan <code>vendor.zip</code> &rarr; pilih <b>Extract</b>.</li>
            <li>Refresh halaman ini.</li>
        </ol>
    </div>');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $appPath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $appPath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
