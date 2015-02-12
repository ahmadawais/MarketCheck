<?php

namespace aqVerifier\Settings;

class Envato implements MarketSettings {
	function __construct() {
		add_action( 'aq-verifier/settings-fields', array( $this, 'add_fields' ), 10, 3 );
	}

	public function get_section_id( $slug ){
		return $slug . 'envato';
	}


	public function add_fields( $slug, $fields, $settings ){
		$fields->add_section( 'Envato Market', $this->get_section_id( $slug ), $slug );

		$fields->add_text_input( array(
			"id"         => 'marketplace_username',
			"title"      => 'Envato Market Username',
			"section_id" => $this->get_section_id( $slug ),
			"slug"       => $slug,
			"settings"   => $settings,
			"desc"       => __('Case sensitive', 'a10e_av'),
		) );


		$fields->add_text_input( array(
			"id"         => 'api_key',
			"title"      => 'Envato API Key',
			"section_id" => $this->get_section_id( $slug ),
			"slug"       => $slug,
			"settings"   => $settings,
			"desc"       => __( 'More info about ', 'a10e' ) . '<a href="http://themeforest.net/help/api" target="_blank">Envato API</a>'
		) );
	}
}