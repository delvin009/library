<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    /** @test */ 
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'Bichu'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }    
}
