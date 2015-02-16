<?php

namespace MarketCheck\Markets;

add_action( 'marketcheck/register-market', function( $fields, $settings, $registerForm, $db ){
	new Envato\Settings();
	$registerForm->addMarket( new Envato\QueryMarket( $settings, $db ) );

	new Mojo\Settings();
	$registerForm->addMarket( new Mojo\QueryMarket( $settings, $db ) );
}, 10, 4 );
