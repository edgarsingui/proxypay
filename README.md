# PROXYPAY SDK
UM SIMPLES PACOTE EM PHP PARA GERAR PAGAMENTOS UTILIZANDO A PROXYPAY

# INSTALAÇÃO

Se deseja instalar este pacote execute o comando abaixo: 

```
composer require edgarsingui/proxypay
```

# INTRODUÇÃO
ESTE SDK/PACOTE É COMPOSTO POR 4 SIMPLES MÉTPDOS  SENDO ELAS :

1. generateReferenceId() - Este responsável por gerar/sortear o número das referências,
2. createPayment() - Este responsável por criar a referências no painel da proxypay.
3. allPayments() - Este responsável por listar todos os pagamentos.
4. confirmPayment() - Depois de um pagamento ter sido feito, devemos processar eles, podemos usar este método se quisermos fazer o processamento manual.


# UTILIZAÇÃO

Devemos instanciar a classe 'ProxyPay' e passar 2 argumentos sendo eles:
1. apikey -> chave de api obtida quando disponiblizada pela proxypay uma conta de sandbox ou prd. 
2. baseUrl -> EndPoint base da proxypay existe o de prd e o de  sandbox.

Ok vamos começar.

``` 
require __DIR__.'/vendor/autoload.php';
use Singui\Proxypay;

$proxypay = new ProxyPay('SUA_CHAVE_DE_API');
```
Note que não estamos passando o segundo argumento, pois o segundo é opcional, e quando não inserido assume-se que usaremos o EndPoint de prd.

Depois de termos instanciado a classe, poderemos usar os método existentes.
```
$proxypay->generateReferenceId(); //Este apenas retorna um conjunto de 9 números
```


Se quisermos gerar uma referência  para pagamento vamos usar a seguinte função
```
$proxypay->createPayment("4999.99","2022-01-15");
```
Note que a função "createPayment()" recebeu 2 argumetos sendo primeiro o valor da referência e o segundo a data em que a referência deverá expirar, ela recebe um terceiro argumento a url de callback que deverá ser chamada assim que a referência for paga, mas ele é opcional.


E se quisermos ver os pagamentos que foram feitos e ainda não foram processados ? 
para isso usaremos o nosso terceiro método
```
$proxypay()->allPayments();
```
Este ira retornar um JSON contendo os dados de todos as referências já pagas mas ainda não processadas, veja o exemplo abaixo.
````
[
  {
    "amount": "322.00",
    "custom_fields": {},
    "datetime": "2022-01-14T01:39:55Z",
    "entity_id": 99926,
    "fee": null,
    "id": 698200000089,
    "parameter_id": null,
    "period_end_datetime": "2022-01-14T19:00:00Z",
    "period_id": 6982,
    "period_start_datetime": "2022-01-13T19:00:00Z",
    "product_id": 1,
    "reference_id": 370313748,
    "terminal_id": "0000000001",
    "terminal_location": "LUANDA",
    "terminal_period_id": 1,
    "terminal_transaction_id": 1,
    "terminal_type": "ATM",
    "transaction_id": 89
  }
]
`````

Agora vamos processar este pagamento, devemos sempre processar os pagamentos, para fazer o processamento deste pagamento vamos usar o nosso último método.

```
$proxypay()->confirmPayment("698200000089");
```
Este método recebe um argumento, este argumento é o id do pagamento , note que não é a referência, mas sim o id do pagamento realizado nesta referências, podemos encontrar este id no JSON acima.