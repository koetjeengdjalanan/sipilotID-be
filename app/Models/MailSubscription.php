<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailSubscription extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType   = 'string';
    protected $guarded   = [
        'created_at',
    ];
}
