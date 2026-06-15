<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'responsible_id',
        'opened_at',
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(Responsible::class, 'responsible_id');
    }
}