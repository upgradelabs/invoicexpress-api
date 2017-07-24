<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceXpressClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_xpress_clients', function (Blueprint $table) {
            $table->increments('id');
	        $table->bigInteger( 'client_id')->unique()->unsigned();
	        $table->string( 'name')->nullable();
	        $table->string( 'code')->nullable();
	        $table->string( 'email')->nullable();
	        $table->string( 'language')->nullable();
	        $table->string( 'address')->nullable();
	        $table->string( 'city')->nullable();
	        $table->string( 'postal_code')->nullable();
	        $table->string( 'fiscal_id')->nullable();
	        $table->string( 'website')->nullable();
	        $table->string( 'country')->nullable();
	        $table->string( 'phone')->nullable();
	        $table->string( 'fax')->nullable();
	        $table->string( 'preferred_name')->nullable();
	        $table->string( 'preferred_email')->nullable();
	        $table->string( 'preferred_phone')->nullable();
	        $table->string( 'preferred_mobile')->nullable();
	        $table->longText( 'observations')->nullable();
	        $table->string( 'send_options')->nullable();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_xpress_clients');
    }
}
