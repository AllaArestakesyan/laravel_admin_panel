<?php

namespace App\Providers;

use App\Contracts\AdminServiceInterface;
use App\Contracts\AuthServiceInterface;
use App\Contracts\CountryServiceInterface;
use App\Contracts\JobServiceInterface;
use App\Contracts\SkillServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\CountryService;
use App\Services\JobService;
use App\Services\SkillService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(SkillServiceInterface::class, SkillService::class);
        $this->app->bind(JobServiceInterface::class, JobService::class);
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
