<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CobaController extends Controller
{

    public function cobaMVC(){
        #1.ambil semua data buku
        $books = Book::all();
        #2.Return view dengan mengirimkan data books
        return view('list_books',[
            'books' => $books
        ]);
    }
    public function index()
    {
        echo "Ini adalah function index di CobaController";
    }

    public function testing()
    {
        echo "ini adalah fungsi testing di coba controller";
    }

    public function cobaView()
    {
        $nama = "Jokowi";
        $umur = 21;
        return view('coba_view',[
            'nama' => $nama,
            'umur' => $umur
        ]);
    }

    public function cobaModel(){
        #get all data
        Book::all();
        #get By Primary Key
        Book::find();

        $books= Book::create([
            'code' => 'B005',
            'title' => 'Javscript 101'
        ]);
        dd($books);
    }
}
