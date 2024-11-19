<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organisasi extends Model
{
    protected $table = 'organisasis';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
