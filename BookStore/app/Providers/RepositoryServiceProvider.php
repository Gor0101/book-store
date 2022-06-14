<?php

namespace App\Providers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\GenreRepositoryContract;
use App\Contracts\PaymentRepositoryContract;
use App\Contracts\RoleRepositoryContract;
use App\Contracts\RoleUserRepositoryContract;
use App\Repositories\BookRepository;
use App\Repositories\GenreRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Contracts\UserRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(
            UserRepositoryContract::class,
            UserRepository::class
        );

        $this->app->singleton(
            RoleRepositoryContract::class,
            RoleRepository::class
        );

        $this->app->singleton(
            RoleUserRepositoryContract::class,
            RoleUserRepository::class
        );

        $this->app->singleton(
            GenreRepositoryContract::class,
            GenreRepository::class
        );

        $this->app->singleton(
            BookRepositoryContract::class,
            BookRepository::class
        );

        $this->app->singleton(
            PaymentRepositoryContract::class,
            PaymentRepository::class
        );
    }
}
