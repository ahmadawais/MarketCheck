<?php

namespace MarketCheck\Markets;

abstract class QueryMarket {
	protected $settings;
	protected $purchaseKey;
	protected $db;

	function __construct( $settings )
	{
		$this->settings = $settings;
	}


	public function setPurchaseKey( $purchaseKey )
	{
		$this->purchaseKey = $purchaseKey;
	}



	protected function retreiveApi()
	{
		$apiUrl   = $this->getApiURL();
		$response = wp_remote_get( $apiUrl );

		if ( is_wp_error( $response ) ) {
			return null;
		}

		$body = wp_remote_retrieve_body( $response );

		if( is_wp_error( $body ) ){
			return null;
		}

		return json_decode( $body, true );
	}


	public function addPurchase()
	{
		$parsedPurchase = $this->parsePurchase( $this->retreiveApi() );

		if( !!$parsedPurchase && $this->isUniqueLicense() ){

		}

		echo '<pre style="font-size:18px">'; print_r( $parsedPurchase ); echo '</pre>'; die();
		die();
	}


	protected function isUniqueLicense()
	{

	}


	public function db()
	{
		if( !$this->db ){
		  global $wpdb;
		  $this->db = $wpdb;
		}

		return $this->db;
	}


	/**
	 * Get normalized API URL for each market
	 *
	 * @method getApiURL
	 *
	 * @return string    API URL
	 */
	abstract public function getApiURL();


	/**
	 * Normalize purchases response
	 *
	 * @method parsePurchase
	 *
	 * @param  array        $response the response from the server
	 *
	 * @return mixed         array of normalized items or null if fails
	 */
	abstract public function parsePurchase( $response );



	 // abstract public function addPurchase();
}