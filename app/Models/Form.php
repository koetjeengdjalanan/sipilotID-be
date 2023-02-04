<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Form
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $user_id
 * @property string $description
 * @property string $excerpt
 * @property string|null $publish_date
 * @property string $expire
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormQuestion[] $answer
 * @property-read int|null $answer_count
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormQuestion[] $questions
 * @property-read int|null $questions_count
 * @method static \Database\Factories\FormFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUserId($value)
 * @mixin \Eloquent
 */
class Form extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType   = 'string';

    protected $casts = [
        'expire'       => 'datetime:Uv',
        'publish_date' => 'datetime:Uv',
        'updated_at'   => 'datetime:Uv',
        'deleted_at'   => 'datetime:Uv',
    ];
    protected $guarded = [
        'created_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function questions()
    {
        return $this->hasMany(FormQuestion::class)->orderBy('order');
    }
    public function answer()
    {
        return $this->hasManyThrough(FormQuestion::class, Submission::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
