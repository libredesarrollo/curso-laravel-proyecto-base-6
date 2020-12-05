<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'image'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function getImageUrl(){
        return URL::asset('images/'.$this->image);
        //return Storage::url($this->image);
    }
}
