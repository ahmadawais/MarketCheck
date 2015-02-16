<?php

namespace MarketCheck;

class UserManagement {
	function __construct( $db ) {
		$this->db = $db;
		add_action( 'delete_user', array( $this, 'deleteUser' ) );
	}

	public function addUser( $userID, $product )
	{
		$wpdb = $this->db->wpdb();

		$wpdb->insert(
			$this->db->getDbName(),
			array(
				'order_id'     => $product['order_id'],
				'item_id'      => $product['id'],
				'user_id'      => $userID,
				'purchased_at' => date('Y-m-d H:i:s', strtotime( $product['purchased_at'] ) ),
				'product_name' => $product['name'],
				'market_name'  => $product['market_name']
			),
			array(
				'%s',
				'%s',
				'%d',
				'%s',
				'%s'
			)
		);


		if( function_exists( 'bbp_set_user_role' ) ){
			bbp_set_user_role( $userID, 'participant' );
		}

		$items = array( $product['id'] );

		// add a hook to allow adding extra user meta (or whatever)
		do_action( 'marketcheck/registered_user', $userID, $product, $wpdb->insert_id  );

		update_user_meta( $userID, 'marketcheck_purchased_items', $items );
	}


	public function deleteUser( $userID )
	{
		$this->db->wpdb()->delete( $this->db->getDbName(), array( 'user_id' => $userID ), array( '%d' ) );
	}
}