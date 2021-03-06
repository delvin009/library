<?php

namespace Tests\Feature;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */ 
    public function a_book_can_be_added_to_the_library()
    {

        $response = $this->post('/books', $this->data());

        $book = Book::first();
        // $response->assertOk();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
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
        
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

     /** @test */ 
    public function a_book_can_be_updated()
    {

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'new title',
            'author_id' => 'new author',
        ]);
 
        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {

        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'cool title',
            'author_id' => 'Bichu',
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());      
        
    }

    public function data()
    {
        return [
            'title' => 'cool book title',
            'author_id' => 'Bichu'
        ];
    }
}
