<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $user_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUserId($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType   = 'string';

    protected $guarded = [
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Uv',
        'updated_at' => 'datetime:Uv',
        'deleted_at' => 'datetime:Uv',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function visitCounter()
    {
        return visits($this);
    }
    public function visits()
    {
        return visits($this)->relation();
    }
}
