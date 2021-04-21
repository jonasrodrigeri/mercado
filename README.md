Mercado
===========

Versões de desenvolvimento
--------------------------
- PHP 7.4
- PostgreSQL 9.4

Instalando pacotes
------------------

    composer install

**Obs: deve ter o composer instalado.**

Bibliotecas usadas
------------------

    "illuminate/database": "^8.37" (usada para manipulação do banco de dados)
    "rakit/validation": "^1.4"     (usada para validação de dados)
    "twig/twig": "^3.0"            (usada para manipulação do html)

Criando banco
-------------

Criar um banco com nome **mercado**
Fazer um Restore do arquivo **mercado.sql** (está na raiz do projeto)

Alterando configuração de conexão
---------------------------------

Altere de acordo com suas configurações locais o arquivo **database.php** (está na raiz do projeto)

    $capsule->addConnection([
        'driver'    => 'pgsql',
        'host'      => 'localhost',
        'database'  => 'mercado',
        'username'  => 'postgres',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ]);

Rodando aplicação
-----------------

Usando servidor nativo do PHP

    php -S localhost:8080 -t public/