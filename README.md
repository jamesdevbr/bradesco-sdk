# Bradesco SDK

**Bradesco SDK** é uma biblioteca PHP para integração com os serviços do Banco Bradesco, oferecendo suporte a transações como emissão de boletos bancários, geração de PIX e consulta de pedidos e pagamentos.

## 🚀 Funcionalidades

- Emissão de boletos bancários
- Geração de cobranças via PIX
- Consulta de pedidos por data, status e ID
- Listagem de pagamentos
- Criptografia e descriptografia de notificações (SPS Notifica)
- Configuração simplificada via `config/bradesco.php`

## 📦 Instalação

Use o Composer para instalar:

```bash
composer require jamesdevbr/bradesco-sdk
```

Se estiver usando Laravel, adicione o provider (caso não use auto-discovery):

```php
JamesDevBR\BradescoSDK\Providers\BradescoServiceProvider::class,
```

Publique o arquivo de configuração:

```bash
php artisan vendor:publish --provider="JamesDevBR\BradescoSDK\Providers\BradescoServiceProvider"
```

## ⚙️ Configuração

O arquivo `config/bradesco.php` permite definir:

- `merchant_id`
- `client_id` e `client_secret`
- `env` (`sandbox` ou `production`)
- `encryption_key` (para SPS Notifica)
- URLs de callback

## 🧱 Estrutura do SDK

- `Services\DTOs` – DTOs como `Buyer`, `Order`, `BankSlip`, `Address`
- `Services\Resources` – Recursos para PIX, boletos e pedidos (`PixResource`, `OrderResource`)
- `Services\Traits` – Tratamento de erros
- `Bradesco` – Classe principal para autenticação e requisições

## ✅ Exemplo de uso

```php
use JamesDevBR\BradescoSDK\Services\Bradesco;

$bradesco = new Bradesco();
$order = $bradesco->order()->getById('123456');

if (!$order) {
    echo $bradesco->getErrorMessage();
} else {
    print_r($order);
}
```

## 🔐 Notificações criptografadas

Utilize os métodos de `Bradesco::encrypt()` e `Bradesco::decrypt()` para lidar com SPS Notifica.

## 🛠 Requisitos

- PHP 7.4 ou superior
- Extensões `openssl` e `curl` habilitadas

## 📝 Licença

MIT © [JamesDevBR](https://github.com/JamesDevBR)
