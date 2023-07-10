<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    /** @var int */
    protected $perPage = 10;

    /** @var array */
    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'genre'
    ];
}
