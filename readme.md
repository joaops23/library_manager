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
~~~

## Comandos básicos para a execução
- instale as dependências via composer com o gerenciador de dependências do PHP "composer", com o comando:
~~~PHP
    composer install    
~~~

- No console SQL ou mesmo em seu SGBD
    - Crie e acesse um novo banco de dados com o nome library
        ~~~SQL 
        create database library;
        use library;
        ~~~
    - execute a query completa do arquivo query.sql

- posteriormente, inicie o servidor integrado do PHP com o comando:
~~~PHP
    php -S localhost:8000 -t public
~~~
- Acesse o projeto com respectivo link:
    http://localhost:8000/

# Tecnologias e ferramentas utilizadas
- PHP
- Slim Framework
- Slim/Twig (template engine)
- psr7 (Respose messages)
- JavaSCript
- JQuery
- AJAX
- HTML
- CSS
- PDO(PHP Data Object)
- MYSQL
- SQL
- Composer

# Schemas

### books:
    id primary key,
    title varchar,
    description varchar,
    author varchar

### clients:
    id primary key,
    name varchar,
    email varchar,
    phone varchar,
    address varchar

### location:
    id primary key,
    client_id int ,
    book_id int ,
    location_date datetime,
    term smallint
    returned ENUM(0,1)

## Relationships

books 1:N locations
client 1:N 


# API Routes

## / books - Rotas para administração dos livros

<h3>[GET] / - Return a list of books</h3>
<h3>[GET] /{id} - Return a book by id</h3>
<h3>[POST] / - Insert a new book</h3>
<h3>[PATCH] / - Update a book</h3>

## /clients - Rotas para administração dos clientes

<h3>[GET] / - Return a list of clients</h3>
<h3>[GET] /{id} - Return a client by id</h3>
<h3>[POST] / - Insert a new client</h3>
<h3>[PATCH] / - Update a client</h3>

## /locations - Rotas para administrar alocações

<h3>[GET] / - Return a list of locations</h3>
<h3>[GET] /{id} - Return a location by id</h3>
<h3>[POST] / - Insert a new location</h3>
<h3>[PATCH] / - Update a location</h3>

# Sore o projeto

<p>Neste projeto busquei, na implementação do PHP junto com o micro framewok Slim implementar um projeto monolito com arquitetura MVC para o controle de uma biblioteca, contendo 3 módulos, o módulo de clientes, livros e locações, sendo que para locar um livro, antes precisa-se criar o cliente e o respectivo livro que o mesmo irá locar e, posteriormente relacionar os dois em uma locação, </p>
<p>Uma vez que o livro foi alugado porém ainda não foi devolvido, o cliente não pode locar o mesmo livro novamente, a validação também foi feita para caso o usuário tentar remover o livro e/ou o cliente enquanto o processo de locação não for finalizado(enquanto o livro não for devolvido a livraria).</p>

<p>A atualização não foi permitida no módulo de locações para evitar que haja conflito de informações e possíveis erros do usuário, uma vez que o usuário poderia facilmente trocar o usuário e/ou o livro ou mesmo o prazo para beneficiar um dos lados, em casos de erro de inserção de ma locação, é possível excluí-la e refazer da forma correta.</p>