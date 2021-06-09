<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'author_id'];

    public function library(){
        return $this->belongsToMany(Library::class, 'books_rooms', 'book_id', 'room_id');
    }

    public function author(){
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    

}
