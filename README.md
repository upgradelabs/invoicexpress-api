[![license](https://img.shields.io/github/license/rpsimao/invoicexpress-api.svg)]()
[![Packagist release](https://img.shields.io/packagist/v/rpsimao/invoicexpress-api.svg)]()
[![GitHub release](https://img.shields.io/github/release/rpsimao/invoicexpress-api.svg)]()

# Laravel InvoiceXpress API

Laravel package to interact with InvoiceXpress API

**Tested with Laravel 5.4.***

## Table of Contents
- [1 - Installation](#1---installation)
  * [1.1 - Publish configuration](#11---publish-configuration)
  * [1.2 - Migrations](#12---migrations)
- [2 - Configuration](#2---configuration)
- [3 - Usage](#3---usage)
  * [3.1 - Eloquent Model](#31---eloquent-model)
  * [3.1.1 - One-to-One relationship with Laravel::Auth()](#311---one-to-one-relationship-with-laravel--auth--)
  * [3.2 - Interact with the API](#32---interact-with-the-api)
- [4 - Tests](#4---tests)



## 1 - Installation

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

### 1.1 - Publish configuration

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

The first argument MUST be an array, and the **number of the itens to replace, must match the items to be replaced in the endpoint**. If not an exception is raised, and a fatal error is thrown.



### 1.2 - Migrations

```bash
$ php artisan vendor:publish --tag=ivxapi-migrations
$ php artisan migrate
```

## 2 - Configuration

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

>If you do not want to put your API key in the .env file, or prefer to get it on every request, you can call the `getAPIKey()` method. This way you can change the API key in your account frequently and not need to update the app.
>
>
>In the config file `invoicexpress`, there are 2 empty fields `['username', 'password']` so you can put the username/password there, if you want.

```php
$client = new InvoiceXpressAPI();
$api_key = $client->getAPIKey('my-username', 'my-password');
....
//later in the query
....
$client->setQuery(['api_key' => $api_key]);
....

```

## 3 - Usage


>
> **Check the documentation for the params of the actions.**
>
> See: [ https://invoicexpress.com/api/overview ]()
>




**There are 2 Classes for working with the API:**

### 3.1 - Eloquent Model

It has one custom function, for retrieve all your customers and put them into the DB.

You can make a cron job for retrieving them periodically.



```php

//Accepts a flag (true or false[default])
InvoiceXpressClients::getAllClientsFromAPI(true);


```
If you pass the `true` flag, the function inserts the clients into the database. `False` or none, returns an array with all your clients.

If the client already exists, it updates the values.

### 3.1.1 - One-to-One relationship with Laravel::Auth()

If you wish to have a relationship between the InvoiceXpress and your app Users, do the following:

```bash
$ php artisan vendor:publish --tag=ivxapi-migrateauth
$ php artisan migrate
```

In your Users Model, add the following method:

```php
class User extends Model
{
.......

//Get the InvoiceXpress Client record associated with the user.

public function invoicexpress()
{
	return $this->hasOne('InvoiceXpressClients');
}


```

You now have a one-to-one relationship. Now you only have to insert the user_id in the InvoiceXpress table.


### 3.2 - Interact with the API
```php

use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;

//Making a GET REQUEST

$client = new InvoiceXpressAPI();
$client->setMethod('GET');
$client->setUrl(config('invoicexpress.my_url'));
$client->setEndpoint(config('invoicexpress.endpoints.clients.list_all'));
$client->setQuery(['api_key' => config('invoicexpress.api_key')]);
$client->talkToAPI();

//2 Choices for return JSON or XML

$data = $client->toJSON();
// or
$data = $client->toXML();

.....



// Another GET Request to generate a PDF for an invoice

$client = new InvoiceXpressAPI();
$client->setMethod('get');
$client->setUrl(config('invoicexpress.my_url'));
$client->setEndpoint(
    endpoint_replace(['12759480'], config('invoicexpress.endpoints.invoices.generate_pdf'))
);
$client->setQuery([
        'api_key' => config('invoicexpress.api_key'),
        'invoice-id' => '12759480',
        'second_copy' => true
    ]);
$client->talkToAPI();

//2 Choices for return JSON or XML

$data = $client->toJSON();
// or
$data = $client->toXML();


//Making a POST REQUEST
// Creating a new Client

client = new InvoiceXpressAPI();
$client->setMethod('post');
$client->setUrl(config('invoicexpress.my_url'));
$client->setEndpoint( config('invoicexpress.endpoints.clients.create'));
$client->setQuery([
        'api_key' => config('invoicexpress.api_key'),
        'client' => [
        	'name' => 'My name',
        	'code' => 'My Client Code',
        	'email' => 'client@email.com'
        	//.... insert more values ....
        ]
    ]);
$client->talkToAPI();
$response = $client->toJSON();
// or
$response = $client->toXML();

//Do whatever you need with the response

//Making a PUT REQUEST

$client = new InvoiceXpressAPI();
$client->setMethod('put');
$client->setUrl(config('invoicexpress.my_url'));
$client->setEndpoint(endpoint_replace(['123456789'], config('invoicexpress.endpoints.clients.update')));
$client->setQuery([
	'api_key' => config('invoicexpress.api_key'),
	'client-id' => '123456789',
	'client' => [
		'name' => 'My awesome Client',
		'code' => '123',
		'phone' =>  999888777
		//.... insert more values ....
		]
	]);
$client->talkToAPI();

$response = $client->toJSON();
// or
$response = $client->toXML();

//Do whatever you need with the response


```

## 4 - Tests

Currently there are 3 tests available.

1. A GET Request
1. A PUT Request
1. GETAPI


For them to work, you have to fill with you own credentials:

```php
.....
class GetTest extends TestCase {

// Use your own credentials to run the tests

	protected $url       = '';
	protected $api_key   = '';
	protected $username  = '';
	protected $password  = '';

.......


```

In the PUT request, fill the apropriated fields:

```php
.....
$endpoint = 'clients/{client-id}.xml';

$client = new InvoiceXpressAPI();
.....
$client->setQuery([
	'api_key' => $this->api_key,
	'client-id' => '{client-id}',
		'client' => [
			'name'  => '{client-name}',
			'code'  => '{client-code}',
			'phone' => '{client-phone}'
			//add more fields if needed
		]
	]);
	
```

Then you can run the tests:

```bash
$ cd your-laravel-project-folder
$ vendor/bin/phpunit vendor/rpsimao/invoicexpress-api
```

If all goes well, you should receive:

```bash
OK (3 tests, 3 assertions)
```
