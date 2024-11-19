<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galeri extends Model
{
    protected $table = 'galeris';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'image',
        'title_image',
    ];

    public function typegaleri(): BelongsTo
    {
        return $this->belongsTo(Typegaleri::class, 'type_galeri_id', 'id');
    }
}
