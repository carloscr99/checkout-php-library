<?php
/**
 * Created by PhpStorm.
 * User: dhiraj.gangoosirdar
 * Date: 3/17/2015
 * Time: 9:27 AM
 */

namespace com\checkout\ApiServices\Charges;


class ChargesMapper
{
	private $_requestModel;

	public  function __construct( $requestModel)
	{
		$this->setRequestModel($requestModel);
	}
	/**
	 * @return mixed
	 */
	public function getRequestModel ()
	{
		return $this->_requestModel;
	}

	/**
	 * @param mixed $requestModel
	 */
	public function setRequestModel ( $requestModel )
	{
		$this->_requestModel = $requestModel;
	}

	public function requestPayloadConverter($requestModel = null )
	{
		$requestPayload = null;
		if(!$requestModel) {
			$requestModel = $this->getRequestModel();
		}
		if($requestModel) {
			$requestPayload = array ();

			if(method_exists($requestModel,'getEmail') && $requestModel->getEmail()) {
				$requestPayload['email'] = $requestModel->getEmail();
			}

			if(method_exists($requestModel,'getValue') && $requestModel->getValue()) {
				$requestPayload['value'] = $requestModel->getValue();
			}

			if(method_exists($requestModel,'getCurrency') && $requestModel->getCurrency()) {
				$requestPayload['currency'] = $requestModel->getCurrency();
			}

			if(method_exists($requestModel,'getDescription') && $requestModel->getDescription()) {
				$requestPayload['description'] = $requestModel->getDescription();
			}

			if(method_exists($requestModel,'getChargeId') && $requestModel->getChargeId()) {
				$requestPayload['chargeId'] = $requestModel->getDescription();
			}

			if(method_exists($requestModel,'getMetadata') && $metadata = $requestModel->getMetadata()) {
				$requestPayload['metadata'] = $metadata;
			}

			if(method_exists($requestModel,'getCustomerIp') && $customerIp = $requestModel->getCustomerIp()) {
				$requestPayload['customerIp'] = $customerIp;
			}

			if( method_exists($requestModel,'getShippingDetails') && $shippingAddress = $requestModel->getShippingDetails()) {
				$shippingAddressConfig = array (
					'addressLine1' => $shippingAddress->getAddressLine1 () ,
					'addressLine2' => $shippingAddress->getAddressLine2 () ,
					'postcode' => $shippingAddress->getPostcode () ,
					'country' => $shippingAddress->getCountry () ,
					'city' => $shippingAddress->getCity () ,
					'state' => $shippingAddress->getState () ,
					'phone' => $shippingAddress->getPhone () ,
					'recipientName' => $shippingAddress->getRecipientName ()

				);

				$requestPayload['shippingDetails'] = $shippingAddressConfig;
			}

			if(method_exists($requestModel,'getEmail') && $productsItem =  $requestModel->getProducts()) {
				$i = 0;
				foreach ( $productsItem as $item ) {

					if( $item->getName ()) {
						$products[ $i ][ 'name' ] = $item->getName ();
					}
					if( $item->getProductId ()) {
						$products[ $i ][ 'productId' ] = $item->getProductId ();
					}
					if( $item->getSku ()) {
						$products[ $i ][ 'sku' ] = $item->getSku ();
					}
					if( $item->getPrice ()) {
						$products[ $i ][ 'price' ] = $item->getPrice ();
					}
					if( $item->getQuantity ()) {
						$products[ $i ][ 'quantity' ] = $item->getQuantity ();
					}
					if( $item->getDescription ()) {
						$products[ $i ][ 'description' ] = $item->getDescription ();
					}
					if( $item->getImage ()) {
						$products[ $i ][ 'image' ] = $item->getImage ();
					}
					if( $item->getShippingCost ()) {
						$products[ $i ][ 'shippingCost' ] = $item->getShippingCost ();
					}
					if( $item->getTrackingUrl ()) {
						$products[ $i ][ 'trackingUrl' ] = $item->getTrackingUrl ();
					}

				}

				$requestPayload['products'] = $products;
			}

			if(method_exists($requestModel,'getBaseCardCreate') ) {
				$cardBase = $requestModel->getBaseCardCreate ();
				if ( $billingAddress = $cardBase->getBillingDetails () ) {
					$billingAddressConfig = array (
						'addressLine1' => $billingAddress->getAddressLine1 () ,
						'addressLine2' => $billingAddress->getAddressLine2 () ,
						'postcode'     => $billingAddress->getPostcode () ,
						'country'      => $billingAddress->getCountry () ,
						'city'         => $billingAddress->getCity () ,
						'state'        => $billingAddress->getState () ,
						'phone'        => $billingAddress->getPhone ()
					);
					$requestPayload[ 'card' ][ 'billingDetails' ] = $billingAddressConfig;
				}


				if ( $name = $cardBase->getName () ) {
					$requestPayload[ 'card' ][ 'name' ] = $name;
				}

				if ( $number = $cardBase->getNumber () ) {
					$requestPayload[ 'card' ][ 'number' ] = $number;
				}

				if ( $expiryMonth = $cardBase->getExpiryMonth () ) {
					$requestPayload[ 'card' ][ 'expiryMonth' ] = $expiryMonth;
				}

				if ( $expiryYear = $cardBase->getExpiryYear () ) {
					$requestPayload[ 'card' ][ 'expiryYear' ] = $expiryYear;
				}

				if ( $cvv = $cardBase->getCvv () ) {
					$requestPayload[ 'card' ][ 'cvv' ] = $cvv;
				}
			}

			if(method_exists($requestModel,'getCardId') && $cardId = $requestModel->getCardId()) {
				$requestPayload[ 'cardId' ] = $cardId;
			}

			if(method_exists($requestModel,'getCardToken') && $cardToken = $requestModel->getCardToken()) {
				$requestPayload[ 'cardToken' ] = $cardToken;
			}

			if(method_exists($requestModel,'getPaymentToken') && $cardToken = $requestModel->getPaymentToken()) {
				$requestPayload[ 'paymentToken' ] = $cardToken;
			}
		}

		return $requestPayload;

	}
}