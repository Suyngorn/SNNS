<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'body', 'thumbnail', 'trainer_id'];

    public function category(){
        return $this->belongsToMany(Categories::class, 'posts_categories', 'post_id', 'category_id');
    }

    public function trainer(){
        return $this->belongsTo(Categories::class, 'trainer_id', 'id');
    }

    public function setThumbnailAttribute($value)
    {
        $attribute_name = "thumbnail";
        // or use your own disk, defined in config/filesystems.php
        $disk = 'upload'; 
        // destination path relative to the disk above
        $destination_path = "uploads/images"; 

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (\Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it 
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = \Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($post) { // before delete() method call this
             $post->category()->detach();
        });
    }
}
