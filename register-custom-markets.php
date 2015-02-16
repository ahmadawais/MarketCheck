<?php

add_action( 'marketcheck/register-market', function( $fields, $settings, $registerForm ){
	new \MarketCheck\Markets\Envato\Settings();
	$envato = new \MarketCheck\Markets\Envato\QueryMarket( $settings );
	$registerForm->addMarket( "Envato", $envato );

	new \MarketCheck\Markets\Mojo\Settings();
	$mojo = new \MarketCheck\Markets\Mojo\QueryMarket( $settings );
	$registerForm->addMarket( "Mojo Markets", $mojo );
}, 10, 3 );
