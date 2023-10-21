<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'title','id_publisher'];

    public function publisher(){
        return $this->belongsTo(Publisher::class,'id_publisher'); //belongsTo untuk one to many 
    }

    public function authors(){
        return $this->belongsToMany(Author::class,'book_authors','id_book','id_author');
    }
}
