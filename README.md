# Laravel InvoiceXpress API



Laravel package to interact with InvoiceXpress API

**Everyone is allowed to help getting this package bigger and better!**

## 1) Install

Via Composer

``` bash
$ composer require rpsimao/invoicexpress-api
```

In your config/app.php, register Providers and the Facade

``` php
'providers' => [
....

rpsimao\InvoiceXpressAPI\InvoiceXpressAPIServiceProvider::class,

.....

'aliases' => [

.....

'InvoiceXpressClients' =>  rpsimao\InvoiceXpressAPI\InvoiceXpressAPIFacade::class,

.....


```

### Publish configuration

```bash
$ php artisan vendor:publish --tag=ivxapi-config
```

In the configuration file, all the API endpoints are accessible, so for example you need to generate an invoice PDF:

```php
config(invoicexpress.enpoints.invoice.generate_pdf);

```

All endpoints are generic like: `'api/pdf/{invoice-id}.xml'`, so there is a helper function for replacing the generic endpoint with the real value:

```php

endpoint_replace(['the-real-value'], config(invoicexpress.enpoints.invoice.generate_pdf));


```

The first argument MUST be an array (throw an error if not), and the **number of the itens to replace, must match the items to be replaced in the endpoint**. If not an exception is raised, and a fatal error is thrown.



### Migrations

```bash
$ php artisan vendor:publish --tag=ivxapi-migrations
$ php artisan migrate
```

## 2) Configuration

Add to your .env file your API Key and Account name

```

INVOICEXPRESS_API_KEY=
INVOICEXPRESS_ACCOUNT_NAME=


```

These will be read by the config file:

```php
....

'api_key'      => env('INVOICEXPRESS_API_KEY'),
'account_name' => env('INVOICEXPRESS_ACCOUNT_NAME'),

....

```

## 3) Usage

There are 2 Classes for working with the API

### 1 - Eloquent Model:

It has one custom function for retrieve all your customers and put them into the DB.

You can make a cron job for retrieving them periodically.



```php

//Accepts a flag (true or false[default])
InvoiceXpressClients::getAllClientsFromAPI(true);


```
If you pass the `true` flag the function insert the clients into the database. `False` or none, it returns an array with all your clients.

If the client already exists, it checks if there are values to be updated, if not, it ignores.


### 2 - Interact with the API:
```php

use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;

//Making a GET REQUEST

$client = new InvoiceXpressAPI();
$client->setMethod('GET');
$client->setUrl(config('invoicexpress.my_url'));
$client->setEndpoint(config('invoicexpress.endpoints.clients.list_all'));


$client->setQuery(['api_key' => config('invoicexpress.api_key')]);
$data = $client->talkToAPI();

$xml = simplexml_load_string($data);

.....
//do whatever you need to do


```

