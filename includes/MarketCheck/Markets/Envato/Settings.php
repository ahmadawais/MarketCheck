<?php

namespace MarketCheck\Markets\Envato;

class Settings extends \MarketCheck\Settings\MarketSettings {
	public function addFields( $namespace, $fields, $settings )
	{
		$fields->addSection( 'Envato Market', 'envato_settings', $namespace );

		$fields->addTextInput( array(
			"id"         => 'envato_user',
			"title"      => __( 'Envato API Owner', 'marketcheck' ),
			"section_id" => 'envato_settings',
			"namespace"  => $namespace,
			"settings"   => $settings,
			"desc"       => __( 'Your Envato Username. <strong>WARNING!</strong> Your name is case sensitive!', 'marketcheck' )
		) );

		$fields->addTextInput( array(
			"id"         => 'envato_api_key',
			"title"      => __( 'Envato API Key', 'marketcheck' ),
			"section_id" => 'envato_settings',
			"namespace"  => $namespace,
			"settings"   => $settings,
			"desc"       => __( 'You can find this in your Envato user account under <strong>API Keys</strong> menu entry.', 'marketcheck' )
		) );
	}
}