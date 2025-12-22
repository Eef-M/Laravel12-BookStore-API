<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookApiTest extends TestCase
{
    public function test_api_books_endpoint_returns_status_200()
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJson(['message' => 'List of books']);
    }
}
