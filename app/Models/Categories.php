<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function post()
    {
        return $this->belongsToMany(Posts::class, 'posts_categories',
            'category_id', 'post_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($category) { // before delete() method call this
             $category->post()->detach();
        });
    }
}
