# Micro PicPay - Um Microsserviço PHP  

Um microsserviço com a funcionalidade de fazer transferências entre usuários

## Fluxo
1. O usuário faz uma requisição para o endpoint de pagamento `\api\v1\user\{id}\pay` 
1. Essa requisição publica uma mensagem para o exchange `process-transference` no RabbitMQ
1. Um consumer processa a fila que está recebendo mesagens desse exchange
1. O processamento dessa fila publica uma mensagem no exchange `notify-transference` com o status 
da transferência


## Tecnologias utilizadas

- Lumen v6.0
- RabbitMQ
- [anik/amqp](https://github.com/ssi-anik/amqp) - Um wrapper que auxilia com RabbitMQ

## Instalação

- Clonando o repositório
> `git clone git@github.com:moacirjun/micropicpay.git`

- Entre no diretório criado e instale as dependências com o Composer

> `composer install`

- Verifique suas variáveis de ambiente

> `cp .env.example .env`

- Depois de configurar seu acesso ao banco de dados rode as migrations com seeders
> `php artisan migrate --seed`

- RabbitMQ Docker container
> `docker-compose up -d`

- Server API
> `php -S localhost:9090 -t public`

- Para consumir as filas de processamento e notificação de transferência
> Eles também são responsáveis 
por criar as filas. Antes disso as mensagens publicadas no RabbitMQ serão perdidas

> `php artisan process-transference:consume`

> `php artisan notify-transference-result:consume`

- cURL para teste
```shell script
curl --request POST \
  --url http://localhost:9090/api/v1/user/1/pay \
  --header 'cache-control: no-cache' \
  --header 'content-type: application/json' \
  --data '{"target_user": 2, "value": 0.01}'
```
