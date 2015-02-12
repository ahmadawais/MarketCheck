<?php

namespace aqVerifier\Settings;

interface MarketSettings {
	public function add_fields( $slug, $fields, $options );

	public function get_section_id( $slug );
}