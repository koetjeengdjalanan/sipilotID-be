<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MailSubscription
 *
 * @property string $id
 * @property string $mail
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MailSubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription newQuery()
 * @method static \Illuminate\Database\Query\Builder|MailSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|MailSubscription withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MailSubscription withoutTrashed()
 * @mixin \Eloquent
 */
class MailSubscription extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType   = 'string';
    protected $guarded   = [
        'created_at',
    ];
}
