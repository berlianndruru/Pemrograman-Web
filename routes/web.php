<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPasswordController;
use App\Mail\TestMail;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


#route register
Route::get('register',function(){
    return view('login.register');
})->name('register');

Route::post('register',[LoginController::class,'prosesRegister'])->name('register.proses');
Route::get('register/verify',[LoginController::class, 'registerVerify'])->name('register.verify');

#Route Login
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/verify',[LoginController::class, 'verify'])->name('login.verify');

#Route Reset Password
Route::group(['prefix'=>'forgot-password'], function () {
    Route::get('/',[ResetPasswordController::class,'index'])->name('fp');
    Route::post('/reset',[ResetPasswordController::class,'reset'])->name('fp.reset');
    Route::get('/new-password',[ResetPasswordController::class,'newPasswordForm'])->name('fp.new.form');
    Route::post('/new-password',[ResetPasswordController::class,'newPasswordProses'])->name('fp.new.proses');
});
Route::get('logout',[LoginController::class,'logout'])->name('logout');

#route yang harus login
Route::group(['middleware'=>'pwl.auth'], function(){
    Route::get('/', function () {
        
        return view('layout.main');
    });
   #CRUD books
   Route::get('/books', [BookController::class, 'index'])->name('books.index');
   Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
   Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
   #delete
   Route::get('/books/{bookId}/delete-confirm', [BookController::class, 'confirmDelete'])->name('books.del.confirm');
   #books/confirm-delete
   Route::post('/books/delete', [BookController::class, 'delete'])->name('books.delete');
   #update-book
   Route::get('/books/{bookId}/update', [BookController::class, 'edit'])->name('books.edit');
   Route::post('/books/update-confirm', [BookController::class, 'update'])->name('books.update');
   Route::get('/books/{bookId}/delete-confirm', [BookController::class, 'confirmDelete'])->name('books.del.confirm');
   Route::get('/books/print', [BookController::class,'print'])->name('books.print');
   Route::get('/books/print/{bookId}', [BookController::class,'printDetail'])->name('books.print.detail');
   Route::get('/books/export/excel', [BookController::class,'excel'])->name('books.export.excel');
});




Route::get('/publishers',[BookController::class,'indexpublishers'])->name('publishers.indexpublishers');
Route::get('/publishers/createpublishers', [BookController::class, 'createpublishers'])->name('publishers.createpublishers');
Route::post('/publishers/storepublishers', [BookController::class, 'storepublishers'])->name('publishers.storepublishers');
Route::get('publishers/{publisherId}/delete-confirmpublishers',[BookController::class, 'confirmDeletepublishers'])->name('publishers.del.confirmpublishers');
Route::post('publishers/deletepublishers', [BookController::class, 'deletepublishers'])->name('publishers.deletepublishers');
Route::get('publishers/{publisherId}/editpublishers',[BookController::class, 'editpublishers'])->name('publishers.editpublishers');
Route::post('publishers/updatepublishers', [BookController::class, 'updatepublishers'])->name('publishers.updatepublishers');

#crud authors
Route::get('/authors',[BookController::class,'indexauthors'])->name('authors.indexauthors');
Route::get('/authors/createauthors', [BookController::class, 'createauthors'])->name('authors.createauthors');
Route::post('/authors/storeauthors', [BookController::class, 'storeauthors'])->name('authors.storeauthors');
Route::get('authors/{authorId}/delete-confirmauthors',[BookController::class, 'confirmDeleteauthors'])->name('authors.del.confirmauthors');
Route::post('authors/deleteauthors', [BookController::class, 'deleteauthors'])->name('authors.deleteauthors');
Route::get('authors/{authorId}/editauthors',[BookController::class, 'editauthors'])->name('authors.editauthors');
Route::post('authors/updateauthors', [BookController::class, 'updateauthors'])->name('authors.updateauthors');



Route::get('/mail/test',function(){
    Mail::to('xodabi7530@in2reach.com')->send(new TestMail());
});












Route::get('/coba', [CobaController::class, 'index']);
Route::get('/coba/lagi', [CobaController::class, 'testing']);
Route::get('/coba/view', [CobaController::class, 'cobaview']);
Route::get('/coba/model', [CobaController::class, 'cobaModel']);
Route::get('/coba/mvc', [CobaController::class, 'cobaMVC']);


Route::get('/test', function () {
    echo "Hello world";
});

Route::get('/test/{nama}/{umur}', function ($nama, $umur) {
    echo "Hello World " . $nama . ' ' . $umur;
});

Route::get('produk/baru', function () {
    echo "Ini adalah halaman produk";
});


Route::get('/coba-model', function () {
    $books = Book::with('publisher')->get();
    foreach ($books as $book) {
        echo $book->code . ' - ' . $book->publisher->id . '<br>';
    }
    dd();
});

Route::get('/coba-pub', function () {
    $publishers = Publisher::with('books')->get();
    foreach ($publishers as $p) {
        echo $p->name . ' (';
        foreach ($p->books as $b) {
            echo $b->title . ', ';
        }
        echo ')<br>';
    }
});
