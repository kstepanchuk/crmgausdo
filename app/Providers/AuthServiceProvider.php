<?php

namespace App\Providers;

use App\Models\ProcurementRequest;
use App\Policies\ProcurementRequestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ProcurementRequest::class => ProcurementRequestPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
