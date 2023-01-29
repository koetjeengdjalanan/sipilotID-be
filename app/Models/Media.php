<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Media
 *
 * @property string $id
 * @property string $path
 * @property string $mediable_type
 * @property string $mediable_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $mediable
 * @method static \Database\Factories\MediaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Query\Builder|Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Media withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Media withoutTrashed()
 * @mixin \Eloquent
 */
class Media extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [
        'created_at',
    ];

    public function mediable()
    {
        return $this->morphTo(__FUNCTION__, 'mediable_type', 'mediable_id');
    }
}
