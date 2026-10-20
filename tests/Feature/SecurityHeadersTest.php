<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Audit v11 K-11: compro memasang header keamanan yang sama dengan core system.
 */
class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_send_security_headers(): void
    {
        $response = $this->get(route('legal.terms'));

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
