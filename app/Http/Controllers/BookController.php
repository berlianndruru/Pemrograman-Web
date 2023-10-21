<?php

namespace App\Http\Controllers;

use App\Export\ExportBooks;
use App\Models\BookAuthor;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PHPUnit\Exception as PHPUnitException;
use Maatwebsite\Excel\Facades\Excel;


class BookController extends BaseController
{
    #fungsi untuk menampilkan semua data buku
    public function index()
    {

        $books = Book::query()->with('publisher','authors')->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query ->where('title', 'LIKE', $searchTerm)
            ->orWhere('code', 'LIKE', $searchTerm)
            ->orWhereHas('publisher',function($query) use($searchTerm) {
                $query->where('name','like',$searchTerm);
            
        })
        ->orWhereHas('authors',function($query) use($searchTerm){
            $query->where('name','like',$searchTerm);
        });
    })->paginate(10);

        return view('books/index', [
            'books' => $books
        ]);
    }

    public function print(){
        $books = Book::all();
        $filename ="books_".date('Y-m-d-H-i-s')."pdf";
        $pdf = Pdf::loadView('books/print',['books'=>$books]);
        $pdf->setPaper('A4','potrait');
        return $pdf->stream($filename);
    }

    public function printDetail($bookId)
    {
        $book = Book::findOrFail($bookId);
        $filename = "book_" . $book->code . "_" . date('Y-m-d-H-i-s') . ".pdf";
        $pdf = Pdf::loadView('books/printDetail',['book'=>$book]);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($filename);

    }
   

    #function untuk menampilkan form tambah baru
    public function create()
    {
        // $this->adminAndSuperAdminOnly();
        $publishers = Publisher::all();
        $authors = Author::all();
        return view('books/form', [
            'publishers' => $publishers,
            'authors' => $authors
            
        ]);
    }

    #fungsi untuk memproses buku kedalam database
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {


            $validated = $request->validate([
                'code' => 'required|max:4|unique:books,code',
                'title' => 'required|max:100',
                'id_publisher' => 'required'
            ]);

            $code = $request->code;
            $title = $request->title;
            $idPublisher = $request->id_publisher;
            

            $book = BOOK::create([
                'code' => $code,
                'title' => $title,
                'id_publisher' => $idPublisher,

            ]);

            foreach ($request->author as $authorId) {
                BookAuthor::create([
                    'id_book' => $book->id,
                    'id_author' => $authorId
                ]);
            }
            
            DB::commit();
            return redirect(route('books.index'))->with('success', 'Buku berhasil ditambah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('books.create'))->with('error', 'Buku gagal ditambah');
        }
    }


    public function confirmDelete($bookId)
    {
        
        #ambil data buku by Id
        $book = Book::findOrFail($bookId);
        return view('books/delete-confirm', [
            'book' => $book
        ]);
    }

    public function delete(Request $request)
    {
        $bookId = $request->id;
        $book = Book::findOrFail($bookId);
        $book->delete();
        return redirect(route('books.index'))->with('success', 'Buku berhasil dihapus');
    }

    public function edit($bookId)
    {
        #ambil data buku by Id
        $book = Book::findOrFail($bookId);
        $publishers = Publisher::all();
        return view('books/form-update', [
            'book' => $book,
            'publishers' => $publishers
        ]);
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|max:4',
            'title' => 'required|max:100'
        ]);
        $bookId = $request->id;
        $book = Book::findOrFail($bookId);
        $book->update([
            'title' => $request->title
        ]);
        return redirect(route('books.index'))->with('sukses', 'data buku sukses di update');;
    }
    
    public function indexpublishers()
    {
        $publishers = Publisher::query()->with('books')->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', $searchTerm);
        })->paginate(10);

        return view('publishers/indexpublishers', [
            'publishers' => $publishers
        ]);
    }
    public function createpublishers()
    {

        $publishers = Publisher::all();
        return view('publishers/formpublishers', [
            'publishers' => $publishers
        ]);
    }

    #fungsi untuk memproses buku kedalam database
    public function storepublishers(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100'
        ]);
        $name = $request->name;
        Publisher::create([
            'name' => $name
        ]);
        return redirect(route('publishers.indexpublishers'))->with('sukses', 'Publisher berhasil ditambah');
    }
    public function editpublishers($publisherId)
    {
        #ambil data buku by Id
        $publisher = Publisher::findOrFail($publisherId);
        return view('publishers/updatepublishers', [
            'publisher' => $publisher
        ]);
    }

    public function updatepublishers(Request $request)
    {
        $publisherId = $request->id;
        $publisher = Publisher::findOrFail($publisherId);
        $publisher->update([
            'name' => $request->name
        ]);
        return redirect(route('publishers.indexpublishers'))->with('sukses', 'Nama Publisher sukses di update');
    }
    public function confirmDeletepublishers($publisherId)
    {
        #ambil data buku by Id
        $publisher = Publisher::findOrFail($publisherId);
        return view('publishers/deletepublishers', [
            'publisher' => $publisher
        ]);
    }

    public function deletepublishers(Request $request)
    {
        $publisherId = $request->id;
        $publisher = Publisher::findOrFail($publisherId);
        $publisher->delete();
        return redirect(route('publishers.indexpublishers'))->with('sukses', 'Nama Publisher sukses di hapus');;
    }
    public function indexauthors()
    {
        $authors = Author::query()->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'LIKE', $searchTerm);
        })->paginate(10);

        return view('authors/indexauthors', [
            'authors' => $authors
        ]);
    }
    public function createauthors()
    {

        $authors = Author::all();
        return view('authors/formauthors', [
            'authors' => $authors
        ]);
    }

    #fungsi untuk memproses buku kedalam database
    public function storeauthors(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100'
        ]);
        $name = $request->name;
        Author::create([
            'name' => $name
        ]);
        return redirect(route('authors.indexauthors'))->with('sukses', 'Authors berhasil ditambah');
    }
    public function editauthors($authorId)
    {
        #ambil data buku by Id
        $author = Author::findOrFail($authorId);
        return view('authors/updateauthors', [
            'authors' => $author
        ]);
    }

    public function updateauthors(Request $request)
    {
        $authorId = $request->id;
        $author = Author::findOrFail($authorId);
        $author->update([
            'name' => $request->name
        ]);
        return redirect(route('authors.indexauthors'))->with('sukses', 'Nama Author sukses di update');
    }
    public function confirmDeleteauthors($authorId)
    {
        #ambil data buku by Id
        $author = Author::findOrFail($authorId);
        return view('authors/deleteauthors', [
            'author' => $author
        ]);
    }

    public function deleteauthors(Request $request)
    {
        $authorId = $request->id;
        $author = Author::findOrFail($authorId);
        $author->delete();
        return redirect(route('authors.indexauthors'))->with('sukses', 'Nama Author sukses di hapus');;
    }

    public function excel()
    {
    
        return Excel::download(new ExportBooks,'books.xlsx');
    }
}
