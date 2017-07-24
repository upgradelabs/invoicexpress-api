<?php

namespace rpsimao\InvoiceXpressAPI;

use Illuminate\Support\ServiceProvider;
use rpsimao\InvoiceXpressAPI\Models\InvoiceXpressapiClients;
use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;
use \Config as Config;

class InvoiceXpressAPIServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
         $this->publishes([
            __DIR__.'/../config/invoicexpress.php' => $this->app->configPath().'/invoicexpress.php',
        ], 'ivxapi-config');

        if (! class_exists('CreateInvoiceXpressClientsTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_invoice_xpressapi_clients_table.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_create_invoice_xpressapi_clients_table.php",
            ], 'ivxapi-migrations');
        }


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    $this->mergeConfigFrom(
		    __DIR__.'/../config/invoicexpress.php',
		    'invoicexpress'
	    );

	    $this->app->singleton( InvoiceXpressAPI::class, function (){
		    return new InvoiceXpressAPI();
	    });
	    $this->app->alias(InvoiceXpressAPI::class, 'InvoiceXpressAPI');

	    $this->app->singleton( InvoiceXpressapiClients::class, function (){
		    return new InvoiceXpressapiClients();
	    });

	    $this->app->alias(InvoiceXpressapiClients::class, 'InvoiceXpressapiClients');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['InvoiceXpressAPI', 'InvoiceXpressapiClients'];
    }

}
