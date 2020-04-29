<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        'title', 'content', 'category_id', 'published'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    

   // How to avoid error in {{ $post->user->name }} if user is deleted?

    // You can assign a default model in belongsTo relationship, to avoid fatal errors when calling it like {{ $post->user->name }} if $post->user doesn't exist.

    /**
    * Get the author of the post.
    */
    public function user()
    {
       return $this->belongsTo(User::class)->withDefault();
    }
    // public function user()
    // {
    //    return $this->belongsTo(User::class);
    // }

    public function category()
    {
       return $this->belongsTo(Category::class);
    }

    public function tags()
    {
       return $this->belongsToMany(Tag::class,  'post_tag');
    }

//     You can use RAW DB queries in various places, including havingRaw() function after groupBy() .

// Product::groupBy('category_id')->havingRaw('COUNT(*) > 1')->get();
}
