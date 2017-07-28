<?php
namespace rpsimao\InvoiceXpressAPI\Models;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
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
		$pages = (int) $xml->api_values->total_pages;
		$clients = [];

		for ($i = 1; $i <= $pages; $i++) {
			$client->setQuery([
				'api_key' => config('invoicexpress.api_key'),
				'page'    => $i,
			]);

			$insert ?
				$clients = $this->insertClients($client->talkToAPI())
				:
				$clients[] = $this->agregateClients( $client->talkToAPI());
		}
		return $clients;
	}

	/**
	 * Join all clients in an array
	 * @param  string $xml
	 *
	 * @return array
	 */
	private function agregateClients( string $xml): array
	{
		$clients = [];
		$xml  = simplexml_load_string( $xml );

		foreach ( $xml->api_values->client as $client ) {
			$clients[] = $client;
		}
		return $clients;

	}

	/**
	 * @param string $data
	 * @return Response
	 */
	public function insertClients(string $data): Response {

		try {
			$xml = simplexml_load_string( $data );

			foreach ( $xml->api_values->client as $client ) {
				$sql = $this->updateOrCreate( [ 'client_id' => $client->id ], [
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
					'created_at'       => ( new \DateTime() )->format( 'Y-m-d H:i:s' ),
					'updated_at'       => ( new \DateTime() )->format( 'Y-m-d H:i:s' ),
				] )->save();
			}

			return $sql ?
				response( 'Clients inserted' )
				:
				response( 'Insert Error', 500 );
		}
		catch ( \Exception $e)
		{
			response( $e->getMessage(), $e->getCode() );
		}
	}
}
