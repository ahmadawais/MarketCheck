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

		do_action( 'market_check/settings-fields',
			$this->opts['namespace'], $this->fields, $this->getSettings() );

		$this->fields->addSection( 'General Settings', 'general_settings', $this->opts['namespace'] );

		$this->fields->addCheckbox( array(
			"id"         => 'disable_username',
			"title"      => __( 'Disable Username input', 'marketcheck' ),
			"section_id" => 'general_settings',
			"namespace"  => $this->opts['namespace'],
			"settings"   => $this->getSettings(),
			"desc"       => __( 'Disable the username field and use only the purchase code', 'marketcheck' )
		) );


		$this->fields->addCheckbox( array(
			"id"         => 'enable_credits',
			"title"      => __( 'Display "Powered By"', 'marketcheck' ),
			"section_id" => 'general_settings',
			"namespace"  => $this->opts['namespace'],
			"settings"   => $this->getSettings(),
			"desc"       => __( 'Display small credit line to help others find the plugin', 'marketcheck' )
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
			<h2><?php _e( 'MarketCheck Settings', 'marketcheck' ); ?></h2>

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
