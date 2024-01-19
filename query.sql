create table books (
    id int unsigned primary key auto_increment,
    title varchar(50) not null,
    description varchar(255),
    author varchar(70)
);

create table clients (
    id int unsigned primary key auto_increment,
    name varchar(70) not null,
    email varchar(70) not null unique,
    phone varchar(15),
    address varchar(255)
);

create table location (
    id int unsigned primary key auto_increment,
    client_id int unsigned references clients(id),
    book_id int unsigned references books(id),
    location_date datetime not null,
    term smallint not null COMMENT 'prazo para devolução',
    returned ENUM("0","1") default "0"
);