<?php 

namespace Singui;

/**
 * @author Edgar Singui <edgarsingui@gmail.com>
 * @version 0.0.1
 */

class ProxyPay {

	private $_apiKey;
	private $_baseUrl;

	public function __construct($key,$url="https://api.proxypay.co.ao") {
		$this->_apiKey = $key;
		$this->_baseUrl = $url;
	}

	public function generateReferenceId(){
		$curl = curl_init();
		$httpHeader = [
		    "Authorization: " . "Token " . $this->_apiKey,
		    "Accept: application/vnd.proxypay.v2+json",
		];

		$opts = [
		    CURLOPT_URL             => $this->_baseUrl."/reference_ids",
		    CURLOPT_CUSTOMREQUEST   => "POST",
		    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_TIMEOUT         => 30,
		    CURLOPT_HTTPHEADER      => $httpHeader
		];

		curl_setopt_array($curl, $opts);

		$reference = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if($err != "")
			return $err;

		return $reference;
	}

	public function createPayment(float $amount,$expdate,$callback=""){
		$refID = $this->GenerateReferenceId();

		strlen($refID) == 8 ? $refID = "0".$refID : $refID;

		if($callback !=""):
			$reference = [
			    "amount"        => $amount,
			    "end_datetime"  => $expdate,
	            "custom_fields" => [
	                "callback_url"=>$callback
	            ]
			];
		else:
			$reference = [
			    "amount"        => $amount,
			    "end_datetime"  => $expdate,
			];
		endif;


		$data = json_encode($reference);

		$curl = curl_init();

		$httpHeader = [
		    "Authorization: " . "Token " . $this->_apiKey,
		    "Accept: application/vnd.proxypay.v2+json",
		    "Content-Type: application/json",
		    "Content-Length: " . strlen($data)
		];

		$opts = [
		    CURLOPT_URL             => $this->_baseUrl."/references/".$refID,
		    CURLOPT_CUSTOMREQUEST   => "PUT",
		    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_TIMEOUT         => 30,
		    CURLOPT_HTTPHEADER      => $httpHeader,
		    CURLOPT_POSTFIELDS      => $data
		];

		curl_setopt_array($curl, $opts);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if($err != "")
			return $err;

		return $refID;
	}

	public function allPayments()
	{
		$curl = curl_init();

		$httpHeader = [
		    "Authorization: " . "Token " . $this->_apiKey,
		    "Accept: application/vnd.proxypay.v2+json",
		];

		$opts = [
		    CURLOPT_URL             => $this->_baseUrl."/payments",
		    CURLOPT_CUSTOMREQUEST   => "GET",
		    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_TIMEOUT         => 30,
		    CURLOPT_HTTPHEADER      => $httpHeader
		];

		curl_setopt_array($curl, $opts);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if($err != "")
			return $err;

		return $response;
	}

	public function confirmPayment(int $paymentID)
	{
		$curl = curl_init();

		$httpHeader = [
		    "Authorization: " . "Token " . $this->_apiKey,
		    "Accept: application/vnd.proxypay.v2+json",
		];

		$opts = [
		    CURLOPT_URL             => $this->_baseUrl."/payments/".$paymentID,
		    CURLOPT_CUSTOMREQUEST   => "DELETE",
		    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_TIMEOUT         => 30,
		    CURLOPT_HTTPHEADER      => $httpHeader
		];

		curl_setopt_array($curl, $opts);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if($err != "")
			return $err;

		return $response;
	}

}

?>