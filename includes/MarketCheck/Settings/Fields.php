<?php

namespace MarketCheck\Settings;

class Fields {
	function __construct() {}


	public function addTextInput( $args )
	{
		$this->addField( 'input', $args );
	}


	public function addCheckbox( $args )
	{
		$this->addField( 'checkbox', $args );
	}

	public function addTextarea( $args )
	{
		$this->addField( 'textarea', $args );
	}


	public function addSection( $title, $id, $namespace )
	{
		add_settings_section( $id, $title, '__return_false', $namespace );
	}


	/**
	 * Normalize field values
	 *
	 * @method parseArgs
	 *
	 * @param  array     $args
	 *
	 * @return array     normalized array
	 */
	protected function parseArgs( $args )
	{

		$id = $args['id'];

		$args['type']  = !empty( $args['type'] ) ? $args['type'] : 'input';

		$args['value'] = !empty( $args['settings'][$id] ) ? $args['settings'][$id] : false;

		if( !empty( $args['default'] ) && is_null( $args['value'] ) ){
			$args['value'] = $args['default'];
		}

		return $args;
	}


	/**
	 * Display the description markup only when there is a description to show
	 *
	 * @method getDescription
	 *
	 * @param  array          $args
	 *
	 * @return string
	 */
	protected function getDescription( $args )
	{
		if( !empty( $args['desc'] ) ){
			return sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
	}


	public function input( $args )
	{
		$args = $this->parseArgs( $args );

		$field = sprintf( '<input id="%1$s" name="%2$s[%1$s]" type="%3$s" value="%4$s" class="widefat" >',
			$args['id'],
			$args['namespace'],
			$args['type'],
			esc_attr( $args['value'] )
		);

		$field .= $this->getDescription( $args );

		echo $field;
	}


	public function textarea( $args )
	{
		$args = $this->parseArgs( $args );
		$field = sprintf( '<textarea id="%1$s" name="%2$s[%1$s]" class="large-text code">%3$s</textarea>',
			$args['id'],
			$args['namespace'],
			$args['value']
		);

		$field .= $this->getDescription( $args );

		echo $field;
	}


	public function checkbox( $args )
	{
		$args = $this->parseArgs( $args );
		$field = sprintf( '<label for="%1$s"><input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1" %3$s> %4$s</label>',
			$args['id'],
			$args['namespace'],
			checked( $args['value'], 1, false ),
			$args['desc']
		);

		echo $field;
	}


	protected function addField( $fieldType, $args ){
		// sample array:
		// array(
		// 	"id"         => 'marketplace_username',
		// 	"title"      => 'Envato Market Username',
		// 	"section_id" => '',
		// 	"namespace"       => $namespace,
		// 	"settings"   => $settings,
		// 	"desc"       => __('Case sensitive', 'a10e_av'),
		// );
		//
		add_settings_field(
			$args['id'],
			$args['title'],
			array( $this, $fieldType ),
			$args['namespace'],
			$args['section_id'],
			array(
				'id' 	=> $args['id'],
				'namespace' => $args['namespace'],
				'desc' 	=> !empty( $args['desc'] ) ? $args['desc'] : null,
				'settings' => $args['settings'],
				'default' => isset( $args['default'] ) ? $args['default'] : null
			)
		);
	}
}