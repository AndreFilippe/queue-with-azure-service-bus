# Integração com Service Bus via REST no Laravel

## Visão Geral

Este projeto Laravel foi criado para demonstrar como integrar com um serviço de barramento (Service Bus) por meio de APIs RESTful. Neste exemplo, vamos criar uma integração simples com um serviço de barramento, permitindo o envio e recebimento de mensagens usando as poderosas funcionalidades do Laravel.

## Pré-Requisitos

Antes de começar, certifique-se de que você tenha os seguintes pré-requisitos instalados:

- [Laravel](https://laravel.com/docs) - Certifique-se de que o Laravel esteja instalado em seu ambiente de desenvolvimento local.

## Primeiros Passos

Siga essas etapas para configurar e usar este projeto de Integração do Laravel com Service Bus:

1. Clone o repositório para o seu ambiente de desenvolvimento local:

   ```bash
   git clone https://github.com/AndreFilippe/queue-with-azure-service-bus.git
   ```

2. Altere o diretório de trabalho para a pasta do projeto:

   ```bash
   cd queue-with-azure-service-bus
   ```

3. Instale as dependências do projeto usando o Composer:

   ```bash
   composer install
   ```

4. Configure suas variáveis de ambiente copiando o arquivo `.env.example` para `.env`:

   ```bash
   cp .env.example .env
   ```

5. Abra o arquivo `.env` e configure as configurações do banco de dados e a conexão com o serviço de barramento. Por exemplo:

   ```dotenv
    SERVICE_BUS_URL=
    SERVICE_BUS_KEY=
    SERVICE_BUS_POLICE=
    SERVICE_BUS_QUEUE_DEFAULT=
   ```

6. Gere uma nova chave de aplicativo:

   ```bash
   php artisan key:generate
   ```

7. Execute as migrações do banco de dados para configurar o esquema do banco de dados:

   ```bash
   php artisan migrate
   ```

8. Inicie o ouvinte da fila:

   ```bash
   php artisan app:service-bus-receive {queue}
   ```

## Licença

Este projeto é de código aberto e está sob a Licença MIT. Sinta-se à vontade para usar e modificar conforme suas necessidades de integração.

---

Aproveite a integração com seu serviço de barramento via REST usando o Laravel! Se você tiver alguma dúvida ou encontrar problemas, não hesite em entrar em contato para obter assistência.
