<?php
namespace rpsimao\InvoiceXpressAPI\Models;

use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\StreamInterface;
use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;


/**
 * Class InvoiceXpressapiClients
 * @package rpsimao
 * @property $created_at
 * @property $id
 * @property $updated_at
 */

class InvoiceXpressapiClients extends Model
{
    protected $fillable = [
    	'client_id', 'name', 'code', 'email', 'language', 'address', 'city', 'postal_code', 'fiscal_id', 'website', 'country', 'phone',
	    'fax', 'preferred_name', 'preferred_email', 'preferred_phone', 'preferred_mobile', 'observations', 'send_options'
    ];

	protected $guarded = ['client_id'];

	/**
	 * Retrieve all Clients form API
	 *
	 * @param bool $insert //flag for inserting into DB
	 * @return mixed
	 */
    public function getAllClientsFromAPI($insert = false){

    	$client = new InvoiceXpressAPI();
    	$client->setMethod('GET');
    	$client->setUrl(config('invoicexpress.my_url'));
    	$client->setEndpoint(config('invoicexpress.endpoints.clients.list_all'));


    	$client->setQuery(['api_key' => config('invoicexpress.api_key')]);
        $data = $client->talkToAPI();

	    $xml = simplexml_load_string($data);
	    $pages = (int) $xml->total_pages;
	    $clients = [];

	   for ($i = 1; $i <= $pages; $i++) {
           $client->setQuery([
               'api_key' => config('invoicexpress.api_key'),
               'page'    => $i,
           ]);

           if($insert)
           {
            	$this->insertClients($client->talkToAPI());
           } else {
				$clients[] = $this->agregateClients( $client->talkToAPI());
           }
	   }
	    return $clients;

    }

	/**
	 * Join all clients in an array
	 * @param  StreamInterface $xml
	 *
	 * @return array
	 */
    private function agregateClients( StreamInterface $xml) :array
    {
    	$clients = [];
	    $xml  = simplexml_load_string(  $xml );

	    foreach ( $xml->client as $key => $client ) {
	    	$clients[$key] = $client;
	    }
	    return $clients;

    }

	/**
	 * @param StreamInterface $xml
	 * @return string
	 */
    public function insertClients(StreamInterface $xml) :string {

    	$xml  = simplexml_load_string( $xml );
    	foreach ( $xml->client as $client ) {
			$sql = $this->updateOrCreate(['client_id' => $client->id], [
				'client_id'        => $client->id,
				'name'             => $client->name,
				'code'             => $client->code,
				'email'            => $client->email,
				'language'         => $client->language,
				'address'          => $client->address,
				'city'             => $client->city,
				'postal_code'      => $client->postal_code,
				'fiscal_id'        => $client->fiscal_id,
				'website'          => $client->website,
				'country'          => $client->country,
				'phone'            => $client->phone,
				'fax'              => $client->fax,
				'preferred_name'   => $client->preferred_contact->name,
				'preferred_email'  => $client->preferred_contact->email,
				'preferred_phone'  => $client->preferred_contact->phone,
				'preferred_mobile' => $client->preferred_contact->mobile,
				'observations'     => $client->observations,
				'send_options'     => $client->send_options,
				'created_at'       => (new \DateTime())->format('Y-m-d H:i:s'),
				'updated_at'       => (new \DateTime())->format('Y-m-d H:i:s'),
			])->save();

		    if ($sql){
			    $resp =  response('Clients inserted')->header('Content-Type', 'text/plain');
		    } else {
			    $resp =  response('Insert Error', 500)->header('Content-Type', 'text/plain');
		    }
    	}
    	return $resp;
    }
}
