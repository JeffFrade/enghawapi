<?php

namespace App\Core\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            $hosts = [
                env('ES_HOST')
            ];

            return ClientBuilder::create()
                ->setHosts($hosts)
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $client = app(Client::class);
        $index = ['index' => env('ES_INDEX')];

        if (!$client->indices()->exists($index)) {
            $client->indices()->create($index);
        }
    }
}
