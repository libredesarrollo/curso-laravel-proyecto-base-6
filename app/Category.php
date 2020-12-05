<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'url_clean'];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

   /* protected $maps = [
        'title' => 'coolName1'
    ];*/

    protected $appends = ['coolName1'];

    public function getCoolName1Attribute()
    {
        return $this->attributes['title'];
    }

    protected $hidden = ['title'];
}
