<?php

namespace MarketCheck\Markets\Mojo;

class QueryMarket extends \MarketCheck\Markets\QueryMarket {
	public function getApiURL()
	{
		$apiURL = array(
			'http://www.mojomarketplace.com/api/v1',
			$this->settings['mojo_user'],
			$this->settings['mojo_api_key'],
			'verify-purchase/' . $this->purchaseKey . '.json'
		);

		return implode( '/', $apiURL );
	}


	public function parsePurchase( $response )
	{
		if( isset( $response['verify-purchase']['item_id'] ) ){
			$parsedResponse = $response['verify-purchase'];

			return array(
				'id'           => $parsedResponse['item_id'],
				'name'         => $parsedResponse['name'],
				'purchased_at' => $parsedResponse['purchase_date'],
				'order_id'     => $this->purchaseKey,
				'market_name'  => $this->getMarketName()
			);
		}

		return null;
	}


	public function getHelp()
	{
		return 'You can find your item purchase code in your Mojo Marketplace user account » Downloads section';
	}


	public function getMarketName()
	{
		return "Mojo Marketplace";
	}
}
