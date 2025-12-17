<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProcurementRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'is_archived',
        'camp_id',
        'user_id',
        'requested_by',
        'notes',
    ];

    protected $casts = [
        'status' => RequestStatus::class,
        'is_archived' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(RequestItem::class)->orderBy('position');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(RequestTemplate::class, 'request_template_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    public function total(): Attribute
    {
        return Attribute::get(fn () => $this->items->sum('line_total'));
    }
}
