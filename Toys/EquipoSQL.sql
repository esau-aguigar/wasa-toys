Drop database if exists Toys;
create database if not exists Toys;
use Toys;


create table if not exists rol(
	id integer(3) AUTO_INCREMENT,
	nombre varchar(30) not null,
	Primary key (id)
);

create table if not exists area(
	id integer(3) AUTO_INCREMENT,
	nombre varchar(30) not null,
	Primary key (id)
);

create table if not exists marca(
	id integer(3) AUTO_INCREMENT,
	nombre varchar(30) NOT NULL,
	Primary key (id)
);

create table if not exists tamanio(
	id integer(3) AUTO_INCREMENT,
	nombre varchar(30) NOT NULL,
	Primary key (id)
);

create table if not exists proveedor (
	id integer(3) AUTO_INCREMENT,
	nombre varchar(40) not null,
	telefono text not null,
	correo varchar(40) not null,
	domicilio text not null,
	Primary key (id)
);

create table if not exists status (
	id integer(3) AUTO_INCREMENT,
	nombre varchar(20) not null,
	Primary key (id)
);

create table if not exists MPago (
	id integer(3) AUTO_INCREMENT,
	nombre varchar(20) not null,
	Primary key (id)
);

create table if not exists usuario (
	codigo integer(10) AUTO_INCREMENT,
	nombre varchar(40) not null,
	password varchar(10) not null,
	status integer(3) not null,
	rol integer(3) not null,
	area integer(3) not null,
	Primary key(codigo),
	constraint FK_rol foreign key (rol) references rol(id),
	constraint FK_area foreign key (area) references area(id),
	constraint FK_status foreign key (status) references status(id)
);

create table if not exists FacturaVenta (
	folio integer(10) AUTO_INCREMENT,
	usuario integer(10) not null,
	Total decimal(10,2) not null,
	fechaHora timestamp not null,
	pago integer(3) not null,
	Primary key (folio),
	constraint FK_Usuario foreign key (usuario) references usuario(codigo),
	constraint FK_Pago foreign key (pago) references MPago(id)
);

create table if not exists FacturaCompra (
	id int(10),
	folio integer(10) Primary key,
	usuario integer(10) not null,
	proveedor integer(3) not null,
	Total decimal(10,2) not null,
	fechaHora timestamp not null,
	constraint FK_proveedorcompra foreign key (proveedor) references proveedor(id),
	constraint FK_UsuarioCompra foreign key (usuario) references usuario(codigo)
);

ALTER TABLE FacturaCompra ADD index(id);
ALTER TABLE FacturaCompra CHANGE id id int(10) NOT NULL AUTO_INCREMENT;

create table if not exists producto (
	barcode integer(10) AUTO_INCREMENT,
	nombre varchar(40) not null,
	marca integer(3) not null,
	tamanio integer(3) not null,
	precioVenta decimal(10,2) not null,
	precioCompra decimal(10,2) not null,
	existencia integer(3) not null,
	Primary key (barcode),
	constraint FK_marca foreign key (marca) references marca(id),
	constraint FK_tamanio foreign key (tamanio) references tamanio(id)
);


create table if not exists DetalleCompra (
	id integer(3) AUTO_INCREMENT Primary key,
	factura integer(10) not null,
	producto integer(10) not null,
	cantidad varchar(5) not null,
	precio decimal(10,2) not null,
	constraint FK_facturaCompra foreign key (factura) references FacturaCompra(folio),
	constraint FK_productoCompra foreign key (producto) references producto(barcode)
);

create table if not exists DetalleVenta (
	id integer(3) AUTO_INCREMENT Primary key,
	factura integer(10) not null,
	producto integer(10) not null,
	cantidad integer not null,
	precio decimal(10,2) not null,
	constraint FK_facturaVenta foreign key (factura) references FacturaVenta(folio),
	constraint FK_productoVenta foreign key (producto) references producto(barcode)
);

insert into rol (nombre) values ("Administrador");
insert into area (nombre) values("Administracion");
insert into status (nombre) values("Activo");

insert into marca (nombre) values("NULL");
insert into tamanio (nombre) values("NULL");
insert into mpago (nombre) values("Efectivo");

insert into proveedor (nombre,telefono,correo,domicilio) values ('NULL','0000000000','NULL','NULL');

insert into usuario (nombre,password,status,rol,area) values ('admin','admin',1,1,1);
insert into usuario (nombre,password,status,rol,area) values ('ESQUIVEL BARBOSA DIEGO HUMBERTO','Desquivel',1,1,1);
insert into usuario (nombre,password,status,rol,area) values ('AGUILAR GARCIA JORGE ESAU','Jaguilar',1,1,1);
insert into usuario (nombre,password,status,rol,area) values ('ALVAREZ DENNIS KENNETH','Kalvarez',1,1,1);


DELIMITER //
CREATE PROCEDURE genFactura(IN user int(10),total decimal(10,0),mpago int(3))
BEGIN
	INSERT INTO facturaventa (usuario,Total,pago)
	VALUES (user,total,mpago);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE genFacturaCompra(IN folio int(10), user int(10),proveedor int(3), total decimal(10,0))
BEGIN
	INSERT INTO facturaCompra (folio,usuario,proveedor,Total)
	VALUES (folio,user,proveedor,total);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getFolio()
BEGIN
	SELECT * FROM facturaventa
	ORDER BY folio DESC
	LIMIT 1;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE getFolioCompra()
BEGIN
	SELECT * FROM facturacompra
	ORDER BY id DESC
	LIMIT 1;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertDetalle(in folio int(10), item int(10), cant int, precio decimal(10,2))
BEGIN
	INSERT INTO detalleventa (factura,producto,cantidad,precio)
	VALUES (folio,item,cant,precio);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertDetalleCompra(in folio int(10), item int(10), cant int, precio decimal(10,2))
BEGIN
	INSERT INTO detalleCompra (factura,producto,cantidad,precio)
	VALUES (folio,item,cant,precio);
END //
DELIMITER ;

Delimiter //
CREATE TRIGGER UPDATEFactura AFTER INSERT ON detalleventa
FOR EACH ROW
BEGIN 
UPDATE producto SET existencia = existencia - new.cantidad WHERE barcode = NEW.producto;
UPDATE facturaventa SET Total = NEW.precio + Total WHERE folio = new.factura;
END //
DELIMITER ;

Delimiter //
CREATE TRIGGER UPDATEFacturaCompra AFTER INSERT ON detalleCompra
FOR EACH ROW
BEGIN 
UPDATE producto SET existencia = existencia + new.cantidad WHERE barcode = NEW.producto;
UPDATE facturaCompra SET Total = NEW.precio + Total WHERE folio = new.factura;
END //
DELIMITER ;

