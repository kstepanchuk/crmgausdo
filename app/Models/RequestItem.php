<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'procurement_request_id',
        'item_name',
        'quantity',
        'unit_price',
        'line_total',
        'tech_specs',
        'position',
    ];

    protected $casts = [
        'quantity' => 'float',
        'unit_price' => 'float',
        'line_total' => 'float',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $item) {
            $item->line_total = ($item->quantity ?? 0) * ($item->unit_price ?? 0);
        });
    }

    public function procurementRequest(): BelongsTo
    {
        return $this->belongsTo(ProcurementRequest::class);
    }
}
