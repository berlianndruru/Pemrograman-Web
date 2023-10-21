<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        foreach($books as $book){
            for($i=1; $i <= fake()->numberBetween(1,5); $i++) {
                DB::table('book_authors')->insert([
                    'id_book' => $book->id,
                    'id_author' => fake()->numberBetween(1, 100)
                ]);
            }
        }
    }
}