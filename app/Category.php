<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'name', 'description'
    ];

    // Атрибуты, для которых запрещено массовое назначение.
    protected $guarded = ['votes'];

    protected $dates = [
        'deleted_at',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
