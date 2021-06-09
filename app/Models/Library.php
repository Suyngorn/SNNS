<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table ='libraries';
    protected $primaryKey = 'id';
    protected $fillable=['room'];


    public function book(){
        return ($this)->belongsToMany(Book::class, 'books_rooms','room_id','book_id');
    }
}
