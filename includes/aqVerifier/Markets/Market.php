<?php

namespace aqVerifier\Markets;

abstract class Market {
	function __construct( $available_markets = array() ) {

		$this->available_markets = $available_markets;
		add_action( 'register_form', array( $this, 'dropdown' ) );

		add_action( 'register_form', array( $this, 'fields' ) );
		add_filter( 'registration_errors', array( $this, 'errors' ), 10, 3 );
		add_action( 'user_register', array( $this, 'register' ) );

		$option_slug   = get_option( 'aq_verifier_slug' );
		$this->options = get_option( $option_slug );
	}


	public function dropdown(){
		$marketplace = ( ! empty( $_POST['marketplace'] ) ) ? trim( $_POST['marketplace'] ) : '';

		$style = isset($this->options['custom_style']) ? $this->options['custom_style'] : '';
		?>

		<style type="text/css" media="screen">
			<?php echo $style ?>

			#marketplacesApis.no-market {display:none;}
		</style>
		<script type="text/javascript">
			function maybeHideMarketplaceAPI( select ) {
				var fields = document.getElementById( 'marketplacesApis' );
				fields.className = '';
				if( select.value == '' ){
					fields.className += ' no-market'
				} else {
					fields.className += select.value;
				}
			}
		</script>
		<p>
			<label for="marketplace"><?php _e( 'Select Marketplace', 'a10e_av' ) ?></label><br />
			<select class="input" name="marketplace" onchange="maybeHideMarketplaceAPI( this );">
				<option value="">-----------</option>
				<?php foreach ( $this->available_markets as $marketKey => $marketName ) {
					printf( '<option value="%s" %s>%s</option>',
						$marketKey,
						'',
						$marketName
					);
				}
				?>
				<option value="envato">Envato</option>
			</select>
		</p>
		<?php
	}


	public function fields(){
		$marketplace_user = ( ! empty( $_POST['marketplace_user'] ) ) ? trim( $_POST['marketplace_user'] ) : '';
		$marketplace_key = ( ! empty( $_POST['marketplace_key'] ) ) ? trim( $_POST['marketplace_key'] ) : '';
		?>

		<div id="marketplacesApis">
			<p>
				<label for="marketplace_user"><?php _e( 'Marketplace Username', 'a10e_av' ) ?><br />
				<input type="text" name="marketplace_user" id="marketplace_user" class="input" value="<?php echo esc_attr( wp_unslash( $marketplace_user ) ); ?>" size="25" /></label>
			</p>

			<p>
				<label for="marketplace_key"><?php _e( 'Marketplace Key', 'a10e_av' ) ?><br />
				<input type="text" name="marketplace_key" id="marketplace_key" class="input" value="<?php echo esc_attr( wp_unslash( $marketplace_key ) ); ?>" size="25" /></label>
			</p>
		</div>
		<?php
	}


	public function errors( $errors, $sanitized_user_login, $user_email ){
		$marketplace      = !empty( $_POST['marketplace'] );
		$marketplace_user = !empty( $_POST['marketplace_user'] ) ? trim( $_POST['marketplace_user'] ) : '';
		$marketplace_key  = !empty( $_POST['marketplace_key'] ) ? trim( $_POST['marketplace_key'] ) : '';

		if ( $marketplace && empty( $marketplace_user ) ) {
			$errors->add( 'marketplace_user_error', __( '<strong>ERROR</strong>: You must include a Marketplace Username.', 'a10e_av' ) );
		}

		if ( $marketplace && empty( $marketplace_key ) ) {
			$errors->add( 'marketplace_key_error', __( '<strong>ERROR</strong>: You must include a Marketplace API Key.', 'a10e_av' ) );
		}

		return $errors;
	}

	 abstract public function register( $user_id );
}