<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
