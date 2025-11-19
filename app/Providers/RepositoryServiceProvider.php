<?php

namespace App\Providers;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
		$this->app->bind(
			CustomerRepositoryInterface::class,
			CustomerRepository::class
		);

        $this->app->bind(
			TicketRepositoryInterface::class,
	        TicketRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
