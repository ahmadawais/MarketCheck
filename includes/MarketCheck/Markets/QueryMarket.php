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


	public function isValidPurchase()
	{
		$parsedPurchase = $this->parsePurchase( $this->retreiveApi() );
		$errors = new \WP_Error;

		if( !$parsedPurchase ){
			$errors->add( 'invalid-purchase-key', __( '<strong>Error</strong>: Invalid Purchase Key.', 'a10e_av' ) );
			return $errors;
		}

		if( $this->isUniqueLicense() ){
			return true;
		} else {
			$errors->add( 'invalid-purchase-key', __( '<strong>Error</strong>: License is already used by another user.', 'a10e_av') );
			return $errors;
		}
	}


	protected function isUniqueLicense()
	{
		$wpdb   = $this->db();
		$dbName = $this->getDbName();
		$count  = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$dbName} WHERE order_id = %s", $this->purchaseKey ) );

		return $count == 0;
	}


	public function addUser( $userID )
	{
		$product = $this->parsePurchase( $this->retreiveApi() );

		$wpdb = $this->db();

		$wpdb->insert(
			$this->getDbName(),
			array(
				'order_id'     => $product['order_id'],
				'item_id'      => $product['id'],
				'user_id'      => $userID,
				'purchased_at' => date('Y-m-d H:i:s', strtotime( $product['purchased_at'] ) ),
				'product_name' => $product['name']
			),
			array(
				'%s',
				'%s',
				'%d',
				'%s',
				'%s'
			)
		);

		wp_update_user( array (
			'ID'   => $userID,
			'role' => 'participant'
		) ) ;

		$items = array( $product['id'] );

		// add a hook to allow adding extra user meta (or whatever)
		do_action( 'market_check/registered-user', $userID, $product );

		update_user_meta( $userID, 'marketcheck_purchased_items', $items );
	}


	public function db()
	{
		if( !$this->db ){
		  global $wpdb;
		  $this->db = $wpdb;
		}

		return $this->db;
	}


	protected function getDbName()
	{
		return $this->db()->prefix . MARKETCHECK_DBNAME;
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
}