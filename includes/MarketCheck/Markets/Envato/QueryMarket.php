<?php

namespace MarketCheck\Markets\Envato;

class QueryMarket extends \MarketCheck\Markets\QueryMarket {
	public function getApiURL()
	{
		$apiURL = array(
			'http://marketplace.envato.com/api/edge',
			$this->settings['envato_user'],
			$this->settings['envato_api_key'],
			'verify-purchase:' . $this->purchaseKey . '.json'
		);

		return implode( '/', $apiURL );
	}


	public function parsePurchase( $response )
	{
		if( isset( $response['verify-purchase']['item_id'] ) ){
			$parsedResponse = $response['verify-purchase'];

			return array(
				'id'           => $parsedResponse['item_id'],
				'name'         => $parsedResponse['item_name'],
				'purchased_at' => $parsedResponse['created_at'],
				'order_id'     => $this->purchaseKey,
				'market_name'  => $this->getMarketName()
			);
		}

		return null;
	}


	public function getHelp()
	{
		return 'You can find your item purchase code in your Envato user account » Downloads section';
	}


	public function getMarketName()
	{
		return "Envato";
	}
}
