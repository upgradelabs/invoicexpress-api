<?php

namespace rpsimao\InvoiceXpressAPI;

use Illuminate\Support\Facades\Facade;

class InvoiceXpressAPIFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
    	return 'InvoiceXpressAPIClients';
    }
}