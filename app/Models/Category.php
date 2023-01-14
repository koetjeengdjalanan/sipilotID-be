<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUlids;

    public $incrementing = false;
    protected $keyType   = 'string';

    protected $guarded = [
        'created_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
