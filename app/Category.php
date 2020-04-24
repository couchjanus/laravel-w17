<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description'
    ];

    // Атрибуты, для которых запрещено массовое назначение.
    protected $guarded = ['votes'];

    protected $dates = [
        'deleted_at',
    ];
}
