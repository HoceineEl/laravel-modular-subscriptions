<?php

namespace HoceineEl\LaravelModularSubscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class ModuleUsage extends Model
{
    protected $fillable = ['subscription_id', 'module_id', 'usage', 'pricing', 'calculated_at', 'metadata'];

    protected $casts = [
        'calculated_at' => 'datetime',
        'usage' => 'integer',
        'pricing' => 'float',
        'metadata' => 'array',
    ];

    public function subscription(): BelongsTo
    {
        $subscriptionModel = config('modular-subscriptions.models.subscription');
        return $this->belongsTo($subscriptionModel);
    }

    public function module(): BelongsTo
    {
        $moduleModel = config('modular-subscriptions.models.module');
        return $this->belongsTo($moduleModel);
    }
}
