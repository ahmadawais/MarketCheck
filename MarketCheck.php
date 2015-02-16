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

define( 'MARKETCHECK_DB_VERSION', '0.0.1' );

define( 'MARKETCHECK_BASEFILE', __FILE__ );
define( 'MARKETCHECK_PATH', plugin_dir_url( __FILE__ ) );
define( 'MARKETCHECK_URL', plugin_dir_path( __FILE__ ) );
define( 'MARKETCHECK_DBNAME', 'marketcheck' );


class MarketCheck {
	function __construct()
	{
		$fields   = new Settings\Fields;
		$settings = new Settings( $fields );
		$setup    = new Setup\Setup( MARKETCHECK_DBNAME );
		$registerForm = new Register();

		$currentDB = get_option( 'marketcheck_version' );

		$setup->install();
		if( $currentDB != MARKETCHECK_DB_VERSION ){
			register_activation_hook( __FILE__, array( $setup, 'install' ) );
			update_option( "marketcheck_version", MARKETCHECK_DB_VERSION );
		}

		do_action( "marketcheck/register-market", $fields, $settings->getSettings(), $registerForm );
	}
}

if( file_exists( dirname( __FILE__ ) . '/register-custom-markets.php' ) ) {
  include( dirname( __FILE__ ) . '/register-custom-markets.php' );
}

new MarketCheck;