<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * App\Models\Post
 *
 * @author Martin Sambulare <martin@rakhasa.com>
 * App\Models\Post
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $user_id
 * @property string|null $category_id
 * @property string $excerpt
 * @property string|null $body
 * @property string|null $published_date
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 * @mixin \Eloquent
 */
class Post extends Model implements Searchable
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType   = 'string';
    protected $guarded   = [
        'created_at',
    ];

    protected $casts = [
        'published_date' => 'datetime:Uv',
        'updated_at'     => 'datetime:Uv',
        'deleted_at'     => 'datetime:Uv',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    public function visitCounter()
    {
        return visits($this);
    }
    public function visits()
    {
        return visits($this)->relation();
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('post.show', $this->slug);
        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
    public function scopePublishedBefore(Builder $query, $date): Builder
    {
        return $query->where('published_date', '<=', Carbon::parse($date));
    }
    public function scopeIsDraft(Builder $query, $value): Builder
    {
        $res = ($value == 1)
        ? $query->whereNull('published_date')
        : $query;
        return $res;
    }
}
