<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Comment;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Post extends Model implements Searchable
{
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        'title', 'content', 'user_id', 'status', 'cover_path'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function tags()
    {
       return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function getDescriptionAttribute()
    {
        return substr($this->content, 0, 70) . "...";
    }
    public function getStitleAttribute()
    {
        return substr($this->title, 0, 30);
    }
    public function getCoverAttribute()
    {
        $parts = explode("/", $this->cover_path);

        return end($parts);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->with('creator');
    }

    public function comment($data, Model $creator): Comment
    {
        return (new Comment())->createComment($this, $data, $creator);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('blog.show', $this->slug);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

}
