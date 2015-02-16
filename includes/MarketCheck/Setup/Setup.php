<?php

namespace MarketCheck\Setup;

class Setup {
	function __construct( $dbName ) {
		$this->dbName = $dbName;
	}


	public function install()
	{
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . $this->dbName;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE {$table_name} (
			id int(4) NOT NULL AUTO_INCREMENT,
			order_id varchar(250) NOT NULL,
			item_id varchar(250) NOT NULL,
			user_id int(4) NOT NULL,
			product_name varchar(250) NOT NULL,
			market_name varchar(250) NOT NULL,
			purchased_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			UNIQUE KEY id (id)
		) {$charset_collate};";

		dbDelta( $sql );
	}
}