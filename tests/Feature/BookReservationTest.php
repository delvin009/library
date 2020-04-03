<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */ 
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'Bichu'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    } 
    
    /** @test */
    public function a_title_is_required()
    {      

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Bichu'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required()
    {
        
        $response = $this->post('/books', [
            'title' => 'cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

     /** @test */ 
    public function a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'cool title',
            'author' => 'Bichu',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id,[
            'title' => 'new title',
            'author' => 'new author',
        ]);
 
        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);
    }
}
