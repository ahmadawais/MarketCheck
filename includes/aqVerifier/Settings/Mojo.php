<?php

namespace aqVerifier\Settings;

class Mojo implements MarketSettings {
	function __construct() {
		add_action( 'aq-verifier/settings-fields', array( $this, 'add_fields' ), 10, 3 );
	}

	public function get_section_id( $slug ){
		return $slug . 'mojo';
	}


	public function add_fields( $slug, $fields, $settings ){
		$fields->add_section( 'Mojo Market', $this->get_section_id( $slug ), $slug );

		$fields->add_text_input( array(
			"id"         => 'mojo_user',
			"title"      => 'Mojo Market Username',
			"section_id" => $this->get_section_id( $slug ),
			"slug"       => $slug,
			"settings"   => $settings,
			"desc"       => __('Case sensitive', 'a10e_av'),
		) );


		$fields->add_text_input( array(
			"id"         => 'mojo_key',
			"title"      => 'Mojo API Key',
			"section_id" => $this->get_section_id( $slug ),
			"slug"       => $slug,
			"settings"   => $settings,
			"desc"       => __( 'More info about ', 'a10e' ) . '<a href="http://www.mojomarketplace.com/api/v1/documentation" target="_blank">Mojo API</a>'
		) );
	}
}