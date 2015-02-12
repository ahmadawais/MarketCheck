<?php

namespace MarketCheck\Markets\Envato;

class Envato {
	private $api = 'http://marketplace.envato.com/api/edge/';
	private $stableAPI = 'http://marketplace.envato.com/api/v3/';

	public function register( $user_id ){
	  if ( ! empty( $_POST['envato_username'] ) ) {
	  	update_user_meta( $user_id, 'envato_username', trim( $_POST['envato_username'] ) );
	  }
	}
}
