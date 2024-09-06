<?php

namespace App\Providers;

use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryEloquent;
use App\Repositories\EventUserRepository;
use App\Repositories\EventUserRepositoryEloquent;
use App\Repositories\ForbiddenWordRepository;
use App\Repositories\ForbiddenWordRepositoryEloquent;
use App\Repositories\MessageRepository;
use App\Repositories\MessageRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(EventRepository::class, EventRepositoryEloquent::class);
        $this->app->bind(MessageRepository::class, MessageRepositoryEloquent::class);
        $this->app->bind(EventUserRepository::class, EventUserRepositoryEloquent::class);
        $this->app->bind(ForbiddenWordRepository::class, ForbiddenWordRepositoryEloquent::class);
    }
}
