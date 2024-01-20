## Plataforma de Gerenciamento de Bilbliotecas - Desafio Finnet

## Como instalar o projeto
- Clone o repositório
- Configure as variáveis de ambiente substituindo o arquivo env.json.example por env.json
- Para configurar as variáveis de ambiente, acesse o arquivo env.json e configure as variáveis de acordo com o seguinte objeto:
~~~JSON
{
    "host": "HOST_DO_SERVIDOR_MYSQL",
    "user": "USUARIO_VÁLIDO",
    "pwd": "SENHA_VÁLIDA",
    "db": "library", 
    "driver": "mysql"
}

Obs: db e driver não necessitam de alteração, pois é necessário que tenha o mysql instalado no servidor qual a aplicação irá se conectar.

-
~~~
- instale as dependências via composer com o comando
~~~PHP
    composer install    
~~~

- No console SQL ou mesmo em seu SGBD, execute a query completa do arquivo query.sql

- posteriormente, inicie o servidor integrado do PHP com o comando:
~~~PHP
    php -S localhost:8000 -t public
~~~
- Acesse o projeto com respectivo link:
    http://localhost:8000/

### Tecnologias
- PHP
- Slim Framework


### Schemas

books:
    id primary key,
    title varchar,
    description varchar,
    author varchar

clients:
    id primary key,
    name varchar,
    email varchar,
    phone varchar,
    address varchar

location:
    id primary key,
    client_id int ,
    book_id int ,
    location_date datetime,
    term smallint
    returned ENUM(0,1)

### Relationships

books 1:N locations
client 1:N 


# Routes

# / books

<h3>[GET] / - Return a list of books</h3>
<h3>[GET] /{id} - Return a book by id</h3>
<h3>[POST] / - Insert a new book</h3>
<h3>[PATCH] / - Update a book</h3>

# /clients

<h3>[GET] / - Return a list of clients</h3>
<h3>[GET] /{id} - Return a client by id</h3>
<h3>[POST] / - Insert a new client</h3>
<h3>[PATCH] / - Update a client</h3>

# /locations

<h3>[GET] / - Return a list of locations</h3>
<h3>[GET] /{id} - Return a location by id</h3>
<h3>[POST] / - Insert a new location</h3>
<h3>[PATCH] / - Update a location</h3>
