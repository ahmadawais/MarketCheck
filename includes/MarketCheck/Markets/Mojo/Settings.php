<?php

namespace MarketCheck\Markets\Mojo;

class Settings extends \MarketCheck\Settings\MarketSettings {
	public function addFields( $namespace, $fields, $settings )
	{
		$fields->addSection( 'Mojo Market', 'mojo_settings', $namespace );

		$fields->addTextInput( array(
			"id"         => 'mojo_user',
			"title"      => __( 'Mojo API Owner', 'marketcheck' ),
			"section_id" => 'mojo_settings',
			"namespace"  => $namespace,
			"settings"   => $settings,
			"desc"       => __( 'Your Mojo Username. <strong>WARNING!</strong> Your name is case sensitive!', 'marketcheck' )
		) );

		$fields->addTextInput( array(
			"id"         => 'mojo_api_key',
			"title"      => __( 'Mojo API Key', 'marketcheck' ),
			"section_id" => 'mojo_settings',
			"namespace"  => $namespace,
			"settings"   => $settings,
			"desc"       => __( 'You can find this in your Mojo user account under <strong>API Keys</strong> menu entry.', 'marketcheck' )
		) );
	}
}