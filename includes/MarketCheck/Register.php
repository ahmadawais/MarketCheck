<?php

namespace MarketCheck;

class Register {
	protected $markets = array();

	function __construct()
	{
		add_action( 'login_form_register', array( $this, 'checkPurchaseForm' ) );
		add_action( 'register_form', array( $this, 'registerForm' ) );
		add_filter( 'registration_errors', array( $this, 'errors' ), 10, 3 );
		add_action( 'user_register', array( $this, 'register' ) );
	}


	public function addMarket( $name, Markets\QueryMarket $market )
	{
		$this->markets[ $name ] = $market;
	}


	public function checkPurchaseForm()
	{
		$errors = new \WP_Error;
		$title  = __( 'Check Purchase Key', 'a10e_av' );

		$purchaseKey    = $this->getPurchaseKey();
		$selectedMarket = $this->getSelectedMarket();
		$isSubmited     = $this->getPostVar( 'marketcheck-submitted' );

		if( $isSubmited ){
			if( !$selectedMarket ){
				$errors->add( 'invalid-market', __( '<strong>Error</strong>: Invalid Market Selected.', 'a10e_av' ) );
			}

			if( !$purchaseKey ){
				$errors->add( 'empty-purchase', __( '<strong>Error</strong>: Empty Purchase Code.', 'a10e_av' ) );
			}
		}

	 	if( $isSubmited && $selectedMarket && $purchaseKey ) {
			$this->markets[ $selectedMarket ]->setPurchaseKey( $purchaseKey );
			$isValidPurchase = $this->markets[ $selectedMarket ]->isValidPurchase();
			if( is_wp_error( $isValidPurchase ) ){
				// $errors = $isValidPurchase;
			} else {
				return;
			}
		}


		if( $isSubmited && true ){
			// return;
		}

		login_header( $title, '<p class="message register">' . $title, $errors );
		$this->showPreRegisterForm();
		login_footer('purchase-key');
		die();
	}


	public function registerForm()
	{
		$this->showMarketSelector();
		?>
		<input type="hidden" name="market-purchase-key" value="<?php echo $this->getPurchaseKey(); ?>" />
		<?php
	}


	public function errors( $errors, $userLogin, $userEmail )
	{
		if( !$this->getPurchaseKey() ){
			$errors->add( 'invalid_purchase_key', __( '<strong>ERROR</strong>: Invalid Purchase Key.', 'a10e_av' ) );
		}

		return $errors;
	}


	public function register( $userID )
	{

	}


	protected function showPreRegisterForm()
	{
		?>

		<style type="text/css" media="screen">
			#login {
				width:600px;
				max-width:95%;
			}
		</style>

		<form name="registerform" id="registerform" method="post">
			<p>
				<label for="purchase-key"><?php _e( 'Purchase Key', 'a10e_av' ) ?><br />
				<input type="text" name="purchase-key" id="purchase-key" class="input" value="" size="20" tabindex="10" /></label>
				<input type="hidden" name="marketcheck-submitted" value="1" /></label>
			</p>

			<?php $this->showMarketSelector() ?>

			<br class="clear" />

			<p class="submit" style="text-align:center">
				<input type="submit"
					name="wp-submit"
					id="wp-submit"
					class="button-primary"
					style="float:none"
					value="<?php esc_attr_e( 'Check Purchase Key', 'a10e_av' ); ?>"
					tabindex="100" />
			</p>
		</form>

		<?php
	}


	protected function showMarketSelector()
	{
		$selectedMarket = $this->getSelectedMarket();
		$selectMarketplaceText = __( 'Select Marketplace', 'a10e_av' );
		if( count( $this->markets ) < 2 ){
			?>
				<input type="hidden" name="market-selector" value="<?php echo esc_attr( key( $this->markets ) ); ?>" />
			<?php
		} else {
			?>
			<p>
				<label for="market-selector"><?php echo $selectMarketplaceText ?>:</label><br>
				<select name="market-selector" id="market-selector" class="input">
				<?php
					printf( '<option value="">%s</option>', $selectMarketplaceText );
					foreach ( $this->markets as $marketName => $market ) {
						printf( '<option value="%1$s" %3$s>%2$s</option>',
							esc_attr( $marketName ),
							$marketName,
							selected( $marketName, $selectedMarket, 1 )
						);
					}
				?>
				</select>
			<?php
		}
	}


	protected function getSelectedMarket()
	{
		return $this->getPostVar( 'market-selector' );
	}


	protected function getPurchaseKey()
	{
		return $this->getPostVar( 'purchase-key' );
	}


	protected function getPostVar( $varName )
	{
		return isset( $_POST[ $varName ] ) ? $_POST[ $varName ] : null;
	}
}