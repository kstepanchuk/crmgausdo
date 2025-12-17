<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestTemplateItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_template_id',
        'item_name',
        'quantity',
        'unit_price',
        'position',
        'tech_specs',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(RequestTemplate::class, 'request_template_id');
    }
}
