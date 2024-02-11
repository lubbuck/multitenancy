# Sobre o Sistema

Sistema com biblioteca multitenancy

### Configurações Iniciais

-   `docker-compose up -d` **( Cria o container do docker )**
-   `docker-compose run --rm composer install` **( Instala a dependecia do php via composer )**
-   `cp .env.example .env` **( Copia e cria o arquivo de configuracao do laravel )**
-   `docker-compose run --rm artisan key:generate` **( Gera a chave do sistema )**

O arquivo .env deve ser configurado nesse momento para que o comando migrate funcione.
É fundamental que a configuração esteja nesta ordem.
e posteriormente os dados de acesso ao banco do sistema. O env.example já esta neste formato só
aguardando os dados.

### ACESSO AO BANCO LOCAL

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=multitenancy_db
DB_USERNAME=postgres
DB_PASSWORD=multitenancy_password

## Configurações Frontend, dependencias e permissões

-   `docker-compose run --rm npm install` **( Instala as dependencias do frontEnd )**
-   `docker-compose run --rm npm run dev` **( Compilacao das libs do frontEnd )**

-   `docker-compose run --rm artisan migrate --seed` **( Cria as tabelas do banco de dados e popula ele )**

-   `docker-compose run --rm composer update` **( Atualiza a dependecia do php via composer )**

-   `docker-compose run --rm artisan storage:link` **( Cria o link nas pastas das remessas )**

-   `docker-compose run --rm app chmod -R 775 bootstrap storage` **( Mudo a permisao )**
-   `docker-compose run --rm app chown -R www-data.www-data bootstrap storage` **( Coloco o nginx para se dono da pasta )**
