<?php

namespace MarketCheck\Markets;

abstract class QueryMarket {
	protected $settings;
	protected $purchaseKey;
	protected $db;

	function __construct( $settings, $db )
	{
		$this->settings = $settings;
		$this->db = $db;
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


	public function getProduct()
	{
	  return $this->parsePurchase( $this->retreiveApi() );
	}


	public function isValidPurchase()
	{
		$parsedPurchase = $this->parsePurchase( $this->retreiveApi() );
		$errors = new \WP_Error;

		if( !$parsedPurchase ){
			$errors->add( 'invalid_purchase_key', __( '<strong>Error</strong>: Invalid Purchase Key.', 'marketcheck' ) );
			return $errors;
		}

		if( $this->isUniqueLicense() ){
			return true;
		} else {
			$errors->add( 'purchase_key_already_used', __( '<strong>Error</strong>: License is already used by another user.', 'marketcheck') );
			return $errors;
		}
	}


	protected function isUniqueLicense()
	{
		$wpdb   = $this->db->wpdb();
		$dbName = $this->db->getDbName();
		$count  = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$dbName} WHERE order_id = %s", $this->purchaseKey ) );

		return $count == 0;
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


	/**
	 * Get a help text to be displayed on the register form field
	 *
	 * @method getHelp
	 *
	 * @return string  the help text
	 */
	abstract public function getHelp();


	/**
	 * Get market name
	 *
	 * @method getMarketName
	 *
	 * @return string
	 */
	abstract public function getMarketName();
}