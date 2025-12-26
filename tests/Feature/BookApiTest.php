<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_get_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data'])
            ->assertJsonCount(3, 'data');
    }

    public function test_public_user_can_view_single_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => $book->title,
            ]);
    }

    public function test_get_single_book_returns_404_if_not_found()
    {
        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_add_book()
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Hacker Book',
            'author' => 'Hacker',
            'price' => 50000,
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_add_book()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/books', [
            'title' => 'Belajar Laravel',
            'author' => 'Programmer Zaman Now',
            'price' => 100000,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Belajar Laravel']);

        $this->assertDatabaseHas('books', [
            'title' => 'Belajar Laravel',
        ]);
    }

    public function test_authenticated_user_can_update_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->putJson("/api/books/{$book->id}", [
            'title' => 'Judul Baru Diubah',
            'author' => $book->author,
            'price' => $book->price,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Judul Baru Diubah']);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Judul Baru Diubah',
        ]);
    }

    public function test_authenticated_user_can_delete_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}
