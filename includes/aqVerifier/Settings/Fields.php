<?php

namespace aqVerifier\Settings;

class Fields {
	function __construct() {}

	/**
	 * Wrapper to easily create a settings field
	 *
	 * @method add_text_input
	 *
	 * @param  array         $args
	 */
	public function add_text_input( $args ){
		// sample array:
		// array(
		// 	"id"         => 'marketplace_username',
		// 	"title"      => 'Envato Market Username',
		// 	"section_id" => $this->get_section_id( $slug ),
		// 	"slug"       => $slug,
		// 	"settings"   => $settings,
		// 	"desc"       => __('Case sensitive', 'a10e_av'),
		// );

		add_settings_field(
			$args['id'],
			$args['title'],
			array( $this, 'input' ),
			$args['slug'],
			$args['section_id'],
			array(
				'id' 	=> $args['id'],
				'slug' => $args['slug'],
				'desc' 	=> !empty( $args['desc'] ) ? $args['desc'] : null,
				"settings" => $args['settings']
			)
		);
	}


	public function add_section( $title, $id, $slug ){
		add_settings_section( $id, $title, '__return_false', $slug );
	}


	/**
	 * Normalize field values
	 *
	 * @method parse_args
	 *
	 * @param  array     $args
	 *
	 * @return array     normalized array
	 */
	protected function parse_args( $args ){
		$id = $args['id'];

		$args['type']    = !empty( $args['type'] ) ? $args['type'] : 'text';
		$args['value']   = $args['settings'][$id];

		if( !empty( $args['default'] ) && is_null( $args['value'] ) ){
			$args['value'] = $args['default'];
		}

		return $args;
	}


	/**
	 * Display the description markup only when there is a description to show
	 *
	 * @method get_description
	 *
	 * @param  array          $args
	 *
	 * @return string
	 */
	protected function get_description( $args ){
		if( !empty( $args['desc'] ) ){
			return sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
	}


	function input( $args ) {
		$args = $this->parse_args( $args );

		$field = sprintf( '<input id="%1$s" name="%2$s[%1$s]" type="%3$s" value="%4$s" class="widefat" >',
			$args['id'],
			$args['slug'],
			$args['type'],
			esc_attr( $args['value'] )
		);

		$field .= $this->get_description( $args );

		echo $field;
	}


	function textarea( $args ) {
		$args = $this->parse_args( $args );
		$field = sprintf( '<textarea id="%1$s" name="%2$s[%1$s]" class="large-text code">%3$s</textarea>',
			$args['id'],
			$args['slug'],
			$args['value']
		);

		$field .= $this->get_description( $args );

		echo $field;
	}


	function checkbox( $args ) {
		$args = $this->parse_args( $args );
		$field = sprintf( '<label for="%1$s"><input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1" %3$s> %4$s</label>',
			$args['id'],
			$args['slug'],
			checked( $args['value'], 1, false ),
			$args['desc']
		);

		echo $field;
	}
}