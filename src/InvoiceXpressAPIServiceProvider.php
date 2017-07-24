<?php

namespace rpsimao\InvoiceXpressAPI;

use Illuminate\Support\ServiceProvider;
use rpsimao\InvoiceXpressAPI\Models\InvoiceXpressAPIClients;
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
            __DIR__.'/../config/invoicexpress-api.php' => $this->app->configPath().'/invoicexpress-api.php  ',
        ], 'ivxapi-config');

        if (! class_exists('CreateInvoiceXpressClientsTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/create_invoice_xpress_clients_table.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_create_invoice_xpress_clients_table.php",
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

	    $this->app->singleton( InvoiceXpressAPIClients::class, function (){
		    return new InvoiceXpressAPIClients();
	    });

	    $this->app->alias(InvoiceXpressAPIClients::class, 'InvoiceXpressAPIClients');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['InvoiceXpressAPI', 'InvoiceXpressAPIClients'];
    }

}
