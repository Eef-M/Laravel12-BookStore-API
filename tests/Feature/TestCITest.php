<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestCITest extends TestCase
{
    public function test_api_test_ci_endpoint_returns_status_200()
    {
        $response = $this->getJson('/api/test-ci');

        $response->assertStatus(200)
            ->assertJson(['message' => 'CI is working']);
    }
}
