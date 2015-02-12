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
	function __construct()
	{
		$fields = new Settings\Fields;
		$settings = new Settings( $fields );
		$db = null;

		do_action( "marketcheck/register-market", $fields, $settings, $db );

		// new Settings\Envato();
		// new Settings\Mojo();
		// new Markets\Envato;
	}
}



add_action( 'marketcheck/register-market', function( $fields, $settings, $db ){
	new Markets\Envato\Settings();
}, 10, 3 );


new MarketCheck;