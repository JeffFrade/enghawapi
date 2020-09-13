# EngHaw API
API que contém as músicas da banda nacional Engenheiros do Hawaii / Pouca Vogal / Humberto Gessinger.

---
## Configuração do Ambiente
A configuração do ambiente é feita via `docker` utilizando `docker-compose`.

O `docker` possui os seguintes containers:

- `enghaw-api-php-fpm` => Container do PHP na versão `7.4 (FPM)` (Esse container já dispõe de `Composer` na versão `latest`)
- `enghaw-api-nginx` => Container do Nginx na versão `1.16`
- `enghaw-api-elasticsearch` => Container do ElasticSearch na versão `7.6.2`

Para executar todos os containers, utilizar `docker-compose up -d`

---
## Configuração da Aplicação:
- Copiar o arquivo `.env.example` para `.env` (Caso tenha necessidade, trocar as variáveis do `.env`)
- Instalar os pacotes da aplicação `composer install`
- Gerar a chave da aplicação com `php artisan key:generate`

---
## Servindo a Aplicação
Caso não tenha alterado a variável `DOCKER_NGINX_PORT` no `.env`, basta acessar `http://localhost:8000/api/music` que será levado ao endpoint que retorna a lista de músicas

---
## Endpoints da API

- `GET`  `/api/music` => Listagem de músicas com ou sem critérios de busca
    - Parâmetros:
        - `text` (Opcional) => Palavra ou frase para fazer a busca

- `POST` `/api/music` => Inserção de músicas
    - Parâmetros:
        - `title` (Obrigatório) => Título da música
        - `music` (Obrigatório) => Letra da música
