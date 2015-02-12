<?php
/*
Plugin Name: MarketCheck
Description: An extensible plugin to check if an user has bought an item from various marketplaces
Version: 0.0.1
Author: Ionuț Staicu
Author URI: http://ionutstaicu.com/
License: GPL
*/

/*
	Based on Aqua Verifier, by SyamilMJ:
	https://github.com/syamilmj/Aqua-Verifier
*/

namespace MarketCheck;

if ( !defined( 'ABSPATH' ) ) exit;

load_plugin_textdomain( 'a10e_av', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

require_once( 'vendor/autoload.php' );

class MarketCheck {
	protected $settings;
	protected $options;
	protected $fields;

	function __construct()
	{
		$this->fields = new Settings\Fields;
		$this->settings = new Settings( $this->fields );
		$this->options = $this->settings->getSettings();

		// new Settings\Envato();
		// new Settings\Mojo();
		// new Markets\Envato;
	}
}

new MarketCheck;