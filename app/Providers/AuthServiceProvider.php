<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate; // Baris ini mungkin ada atau tidak, biarkan saja.
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Consultation' => 'App\Policies\ConsultationPolicy',
        'App\Models\HelpArticle' => 'App\Policies\HelpArticlePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
