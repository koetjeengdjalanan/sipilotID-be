<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
