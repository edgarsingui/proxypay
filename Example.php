<?php 

require 'vendor/autoload.php';
use Singui\Proxypay;

// Instanciando a classe
$proxypay = new ProxyPay('SUA_CHAVE_DE_API','https://api.sandbox.proxypay.co.ao');

// Criando um pagamento
$res  = $proxypay->createPayment("4999.99","2022-01-15");

var_dump($res);

?>