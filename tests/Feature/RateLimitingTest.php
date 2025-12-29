<?php

namespace Tests\Feature;

use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    public function test_api_requests_are_throttled()
    {
        // 1. Tembak 60 kali (Batas maksimal) -> Harusnya masih sukses (200 OK)
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/books');
            $response->assertStatus(200);
        }

        // 2. Tembakan ke-61 -> Harusnya DITOLAK (429 Too Many Requests)
        $response = $this->getJson('/api/books');

        // Assert status 429
        $response->assertStatus(429);
    }
}
