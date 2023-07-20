create database awfacturademo;

use awfacturademo;

create table cliente(
    idcliente int PRIMARY key auto_increment,
    nombrecliente varchar
(255),
    apaternocliente varchar
(255),
    amaternocliente varchar
(255),
    direccioncliente varchar
(255),
    rfccliente varchar
(255)
);
insert into cliente
values(0, 'Cliente', 'Pato', 'Patito', 'Av. de los patos No. 35', 'XAXA000000XAX');
insert into cliente
values(0, 'Pacho', 'Pantera', 'Chocolate', 'Av. de los chocolates No. 68', 'XEXE000000XEX');

create table producto(
idproducto int PRIMARY key auto_increment,
nombreproducto varchar
(255)
);
insert into producto
values(0, 'Cafe molido 1kg');
insert into producto
values(0, 'Cafe molido 3kg');
insert into producto
values(0, 'Azucar 500grs');
insert into producto
values(0, 'Azucar 1000grs');
insert into producto
values(0, 'Crema para café 300grs');
insert into producto
values(0, 'Crema para café 650grs');



create table venta(
    idventa int PRIMARY key auto_increment,
    fechaventa date default
(now
()),
    idcliente int
);
insert into venta
values(0, now(), 1);
insert into venta
values(0, now(), 1);
insert into venta
values(0, now(), 2);
insert into venta
values(0, now(), 2);

create table detalleventa(
    iddetalleventa int PRIMARY key auto_increment,
    idventa int,
    idproducto int,
    cantidad int,
    preciounitario int
);

insert into detalleventa
values(0, 1, 1, 2, 100);
insert into detalleventa
values(0, 1, 2, 1, 80);
insert into detalleventa
values(0, 2, 3, 3, 100);
insert into detalleventa
values(0, 2, 4, 2, 80);
insert into detalleventa
values(0, 2, 1, 3, 50);