# Projeto Laravel - Gestão de Clientes

## Descrição

API RESTful para gerenciamento de clientes e seus endereços, construída com Laravel.  
Implementa repositórios para organização da lógica de persistência, validação customizada e filtros para consultas.

## Tecnologias

-   PHP 8.x
-   Laravel 10
-   MySQL
-   Docker

## Estrutura do Projeto

-   **app/Filters**: Classes para filtros de pesquisa na listagem de clientes.
-   **app/Helpers**: Helpers para formatação de campos como CEP, telefone e CPF.
-   **app/Rules**: Regras customizadas para validação de CPF e telefone.
-   **app/Services**: Serviços para lógica de negócio.
-   **app/Repositories**: Repositórios para abstração da camada de acesso a dados.
-   **app/Http/Requests**: Requests para validação das entradas.
-   **database/seeders**: Seeds para popular dados iniciais.

## Como rodar o projeto com Docker

1. Clone o repositório.
2. Execute o comando para subir os containers com Docker Compose:
    ```
    docker-compose up -d --build
    ```
3. Acesse o container da aplicação:
    ```
    docker-compose exec app bash
    ```
4. Instale as dependências
    ```
    composer install
    ```
5. Crie o arquivo .env a partir do .env.example
    ```
    cp .env.example .env
    ```
6. Gere uma nova chave de aplicação:
    ```
    php artisan key:generate
    ```
7. Execute as migrations:
    ```
    php artisan migrate
    ```
8. Rode as seeds para popular o banco:
    ```
    php artisan db:seed
    ```

## Endpoints principais

-   `GET /api/customers` - Listar clientes com filtros.
-   `POST /api/customers` - Criar novo cliente.
-   `PUT/PATCH /api/customers/{id_customer}` - Atualizar cliente.
-   `GET /api/customers/{id_customer}` - Detalhes do cliente.

## Cache

- Endpoints `GET /api/customers` e `GET /api/customers/{id_customer}` utilizam cache com Redis para melhorar performance.
- Cache é limpo automaticamente ao criar, atualizar ou deletar clientes para evitar dados desatualizados.

## Contato

Desenvolvido por Guilherme Viana.
