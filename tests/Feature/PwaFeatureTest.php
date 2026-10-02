<?php

namespace Tests\Feature;

use Tests\TestCase;

class PwaFeatureTest extends TestCase
{
    public function test_root_redirects_to_kitab_panel(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/kitab');
    }

    public function test_manifest_is_served_with_correct_json_content_type(): void
    {
        $response = $this->get('/manifest.webmanifest');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/manifest+json');
        $response->assertJson([
            'name' => 'HisabKitab',
            'short_name' => 'HisabKitab',
            'display' => 'standalone',
            'start_url' => '/kitab',
        ]);
    }

    public function test_service_worker_is_served_with_javascript_content_type(): void
    {
        $response = $this->get('/sw.js');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/javascript');
    }

    public function test_login_page_includes_pwa_manifest_link_and_meta(): void
    {
        $response = $this->get('/kitab/login');
        $response->assertOk();
        $response->assertSee('rel="manifest"', false);
        $response->assertSee('/manifest.webmanifest', false);
        $response->assertSee('name="theme-color"', false);
    }
}
