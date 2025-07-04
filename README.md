# Charge API

API de gerenciamento de cobranças desenvolvida em Laravel 12 com Docker.

## 📋 Descrição

Sistema de API para gerenciamento de clientes e cobranças, com validações robustas, cache inteligente e testes automatizados.

### Funcionalidades

- **Gestão de Clientes**: Cadastro e listagem de clientes com validação de CPF/CNPJ
- **Gestão de Cobranças**: Criação e listagem de cobranças com controle de vencimento
- **Cache Inteligente**: Sistema de cache para otimizar consultas ao banco
- **Validações**: Regras de validação customizadas para CPF/CNPJ
- **Testes**: Cobertura completa com testes unitários e de feature

## 🚀 Instalação

### Pré-requisitos

- Docker
- Docker Compose
- Git

### Passos para Instalação

1. **Clone o repositório**
   ```bash
   git clone git@github.com:devsergyo/charge-api.git
   cd charge-api
   ```

2. **Configure as variáveis de ambiente**
   ```bash
   cp .env.example .env
   ```

3. **Inicie os containers**
   ```bash
   docker-compose up -d
   ```

4. **Instale as dependências do Composer**
   ```bash
   docker-compose exec app composer install
   ```

5. **Gere a chave da aplicação**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Execute as migrações**
   ```bash
   docker-compose exec app php artisan migrate
   ```

7. **Configure as permissões**
   ```bash
   docker-compose exec app chmod -R 775 storage bootstrap/cache
   ```

## 🛠️ Configuração

### Variáveis de Ambiente

Edite o arquivo `.env` com suas configurações:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

# Configurações do PostgreSQL para Docker
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=charge_api
DB_USERNAME=postgres
DB_PASSWORD=postgres

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=file

QUEUE_CONNECTION=database
```

## 🧪 Testes

### Executar Todos os Testes
```bash
docker-compose exec app php artisan test
```

### Manutenção
```bash
# Limpar cache
docker-compose exec app php artisan cache:clear

# Limpar configurações
docker-compose exec app php artisan config:clear

# Recriar banco de dados
docker-compose exec app php artisan migrate:fresh

# Executar seeders (se houver)
docker-compose exec app php artisan db:seed
```
