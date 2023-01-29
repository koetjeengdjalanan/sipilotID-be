<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MainContent
 *
 * @property string $id
 * @property string $section
 * @property string $content
 * @property string $image
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @method static \Database\Factories\MainContentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent newQuery()
 * @method static \Illuminate\Database\Query\Builder|MainContent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainContent whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|MainContent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MainContent withoutTrashed()
 * @mixin \Eloquent
 */
class MainContent extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType   = 'string';

    /**
     * Non fillable Data Column List
     * @var array<int, string>
     */
    protected $guarded = [
        'created_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
