<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *
 *  @OA\Property(property="title", type="string", readOnly="true", description="Book title", example="Clean Code"),
 *  @OA\Property(property="author", type="string", readOnly="true", description="Book title", example="Robert Cecil Martin"),
 *  @OA\Property(property="publication_year", type="integer", readOnly="true", description="Book title", example=2008),
 *  @OA\Property(property="genre", type="string", readOnly="true", description="Genre of book", example="Computers"),
 *
 *  @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 *  @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 *  @OA\Property(property="deleted_at", type="string", format="date-time", description="Soft delete timestamp", readOnly="true"),
 * )
 */
class Book extends Model
{
    use SoftDeletes;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /** @var array */
    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'genre'
    ];
}
