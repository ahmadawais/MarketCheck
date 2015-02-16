<?php

add_action( 'marketcheck/register-market', function( $fields, $settings, $registerForm ){
	new \MarketCheck\Markets\Envato\Settings();
	$envato = new \MarketCheck\Markets\Envato\QueryMarket( $settings );
	$registerForm->addMarket( "Envato", $envato );
}, 10, 3 );
