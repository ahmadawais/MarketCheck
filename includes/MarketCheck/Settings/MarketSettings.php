<?php

namespace MarketCheck\Settings;

abstract class MarketSettings {
	function __construct()
	{
		add_action( 'market_check/settings-fields', array( $this, 'addFields' ), 10, 3 );
	}

	abstract public function addFields( $namespace, $fields, $settings );
}