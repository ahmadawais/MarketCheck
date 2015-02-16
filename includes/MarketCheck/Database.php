<?php

namespace MarketCheck;

class Database {
	protected $wpdb = null;
	protected $dbName;

	function __construct( $dbName )
	{
		$this->dbName = $dbName;
	}


	public function wpdb()
	{
		if( !$this->wpdb ){
		  global $wpdb;
		  $this->wpdb = $wpdb;
		}

		return $this->wpdb;
	}


	public function getDbName()
	{
		return $this->wpdb()->prefix . $this->dbName;
	}
}