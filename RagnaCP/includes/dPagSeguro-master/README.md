dPagSeguro
==========
Classe em PHP simples e rápida para integração com a API do PagSeguro.

Essa classe contempla TUDO o que você precisa para integração de qualquer
sistema com o PagSeguro, restando para você apenas informar as variáveis
que o PagSeguro julga necessário para processar o pedido de compra, e 
registrar o pagamento da compra no seu sistema quando o PagSeguro
assim informar.

Permissividade
==========
Essa classe também é capaz de identificar erros nas informações digitadas pelos seus clientes e compradores e corrigí-las, para garantir que o PagSeguro não deixe de receber seus compradores, o que pode te levar a perder vendas.

Por exemplo, se o seu cliente diz que o nome dele é "Lucas", o PagSeguro vai recusar a tentativa de pagamento, pois não veio o nome completo da pessoa. Nesse caso, a classe identifica a recusa do PagSeguro, e REMOVE o nome da requisição, obrigando a pessoa a re-digitar o nome diretamente no PagSeguro.

Como configurar corretamente o PagSeguro (sugestão):
==========
- Integração > Gerar TOKEN
- Integração > Página de redirecionamento > Página fixa: "Desativado"
- Integração > Página de redirecionamento > Dinâmico: "Ativado" : "transaction_id"
- Integração > Pagamentos via API > "Ativado" (Sem isso, o redirecionamento dinâmico não funciona)
- Integração > Notificação de transações > "Ativado" (URL NOTIFICACAO)
- Integração > Retorno automático de dados > "Desativado"
- URL Retorno:     http://www.site.com.br/**pagseguro_retorno.php**
- URL Notificação: http://www.site.com.br/**pagseguro_notific.php**

Referência
==========
Todos os nome de variáveis, submits e retornos seguem o padrão informado pelo PagSeguro, sem
modificações. Dessa forma, leia a documentação do PagSeguro para uma referência completa:

https://pagseguro.uol.com.br/v2/guia-de-integracao/visao-geral.html

Como utilizar na prática
===========
Existem três momentos em que você vai querer se comunicar com o PagSeguro, sendo eles:
- Checkout (Você envia o cliente para o PagSeguro);
- Retorno (O PagSeguro envia o cliente de volta para você);
- Notificação (O PagSeguro te avisa quando o pedido for atualizado [boleto pago, etc.])

**Checkout (pagseguro_checkout.php)**

Quando o cliente optar por pagamento através do PagSeguro, você deverá utilizar o método **newPagamento($pedido, $produtos)** para obter a URL para a qual enviar o seu visitante, conforme o exemplo abaixo.

```php
$pedido = Array(
    'reference'   =>'123456',
    'senderEmail' =>...,
    'senderName'  =>...,
    'shippingType'=>...,
    'shippingCost'=>..., // Preço sempre decimal
    // ... Veja a relação completa na documentação do PagSeguro.
    'redirectUrl' =>'http://www.site.com.br/pagseguro_retorno.php'
);
$produtos   = Array();
$produtos[] = Array(
    'id'         =>'123456',
    'description'=>'Nome do produto',
    'amount'     =>25.99, // Preço sempre decimal
    'quantity'   =>1,     // Quantidade
    // ... Veja a relação completa na documentação do PagSeguro.
);

$ps    = new dPagSeguro($Email, $Token);
$goURL = $ps->newPagamento($pedido, $produtos);
if($goURL){
    header("Location: {$goURL}");
	die;
}
else{
    echo "O PagSeguro não aceitou o pedido de compra:\r\n";
    foreach($ps->listErrors() as $errorCode=>$errorStr){
        echo "{$errorStr} (código {$errorCode})\r\n";
    }
}
```

** Retorno (pagseguro_retorno.php) **

Em caso de sucesso ou fracasso, o PagSeguro vai mandar o cliente de volta para o seu site, na página de retorno. Essa página você definiu na hora de enviar o pedido, em ```$pedido['redirectUrl']```. Além da URL, o PagSeguro adiciona à Query String a variável "transaction_id", conforme você deve ter configurado (veja "Como configurar o PagSeguro" no início deste documento).

```
$ps = new dPagSeguro($Email, $Token);
$transactionInfo = $ps->getTransaction($_GET['transaction_id']);
// Array(
//     'date'          =>'2014-02-05 15:46:12',     
//     'lastEventDate'=> '2014-02-05 20:15:00',
//     'code'         => 'XXXXXXXX-XXXXXXXX-XXXXXXX-XXXXXXXX',
//     'reference'    => '123456',
//     'type'         => '1',
//     'status'       => '3',
//     ... Leia a documentação do PagSeguro para a referência completa.
// );
```

Leia a documentação do PagSeguro para entender as variáveis em $transactionInfo:

https://pagseguro.uol.com.br/v2/guia-de-integracao/consulta-de-transacoes-por-codigo.html

** Notificação (pagseguro_notific.php) **

Sempre que um pedido é atualizado, o PagSeguro se conecta ao seu site enviando um código único de notificação. Isso acontece quando o status é alterado, quando um boleto é pago, etc..

```
$ps = new dPagSeguro($Email, $Token);
$notificInfo = $ps->getNotification($_POST['notificationCode'], $_POST['notificationType']);
```
Leia a documentação do PagSeguro para entender as variáveis em $notificInfo:

https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-notificacoes.html


Relação completa de métodos da classe:
=======================================

```
newPagamento($pedido, $produtos);
// Em caso de sucesso, retorna a URL para direcionar o cliente.
// Em caso de fracasso, retorna FALSE (utilize listErrors() p/ informações)

getNotification($type, $code);
// Em caso de sucesso, retorna os campos informados pelo PagSeguro.
// Em caso de fracasso, retorna FALSE (utilize listErrors() p/ informações)

getTransaction($code);
// Em caso de sucesso, retorna os campos informados pelo PagSeguro.
// Em caso de fracasso, retorna FALSE (utilize listErrors() p/ informações)

getTransactionHistory($initialDate, $finalDate[, $page[, $maxPageResults]]);
getAbandonedHistory  ($initialDate, $finalDate[, $page[, $maxPageResults]]);
// Em caso de sucesso, ambos retornam os campos informados pelo PagSeguro.
// Em caso de fracasso, retorna FALSE (utilize listErrors() p/ informações)

listErrors();
// Se não houverem erros, retorna FALSE;
// Se houverem erros, retornará um array contendo [errCode]=>errString.
```

