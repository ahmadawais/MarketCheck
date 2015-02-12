<?php

namespace MarketCheck;

class Settings {
	private $options;
	private $opts = array(
		'namespace'    => 'marketcheck',
		'access_level' => 'manage_options'
	);

	function __construct( $fields )
	{
		$this->fields = $fields;
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function getSettings()
	{
		if( !isset( $this->options ) ){
			$this->options = get_option( $this->opts['namespace'] );
		}

		return $this->options;
	}


	public function add_admin_menu()
	{
		add_options_page(
			'MarketCheck',
			'MarketCheck',
			$this->opts['access_level'],
			$this->opts['namespace'],
			array( $this, 'form' )
		);
	}


	public function register_settings()
	{
		register_setting( $this->opts['namespace'], $this->opts['namespace'] );

		$this->fields->addSection( 'General Settings', 'general_settings', $this->opts['namespace'] );

    do_action( 'market_check/settings-fields',
    	$this->opts['namespace'], $this->fields, $this->getSettings() );


		$this->fields->addTextarea( array(
			"id"         => 'custom_style',
			"title"      => __( 'Custom Styling', 'a10e_av' ),
			"section_id" => 'general_settings',
			"namespace"  => $this->opts['namespace'],
			"settings"   => $this->getSettings(),
			"desc"       => __( 'Custom CSS to be used on Register form', 'a10e_av' ),
	    'default'    => "#login {width: 500px} .success {background-color: #F0FFF8; border: 1px solid #CEEFE1;}",
		) );


		$this->fields->addCheckbox( array(
			"id"         => 'disable_username',
			"title"      => __( 'Disable Username input', 'a10e_av' ),
			"section_id" => 'general_settings',
			"namespace"  => $this->opts['namespace'],
			"settings"   => $this->getSettings(),
			"desc"       => __( 'Disable the username field and use only the purchase code', 'a10e_av' )
		) );


		$this->fields->addCheckbox( array(
			"id"         => 'enable_credits',
			"title"      => __( 'Display "Powered By"', 'a10e_av' ),
			"section_id" => 'general_settings',
			"namespace"  => $this->opts['namespace'],
			"settings"   => $this->getSettings(),
			"desc"       => __( 'Display small credit line to help others find the plugin', 'a10e_av' )
		) );
	}

	/**
	 * Main Settings panel
	 *
	 * @since 	1.0
	 */
	function form() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2><?php _e( 'MarketCheck Settings', 'a10e_av' ); ?></h2>

			<form action="options.php" method="post">
			<?php
				settings_fields( $this->opts['namespace'] );
				do_settings_sections( $this->opts['namespace'] );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}
}
