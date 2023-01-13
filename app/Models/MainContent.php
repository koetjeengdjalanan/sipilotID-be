<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainContent extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Non fillable Data Column List
     * @var array<int, string>
     */
    protected $guarded = [
        'created_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
