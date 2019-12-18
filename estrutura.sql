create database controle;

create table equipamento
(
	num_serie varchar(30) NOT NULL,
	tipo varchar(50) NOT NULL,
	status int DEFAULT 0,
	condicao_entrada int NOT NULL,
	marca varchar(15) NOT NULL,
	modelo varchar(15) NOT NULL,
	descricao text,
	primary key(num_serie)
);

create table e_lotado
(
	protocolo int NOT NULL,
	responsavel varchar(70) NOT NULL,
	dpto varchar(15) NOT NULL,
	descricao text,
	primary key(protocolo)
);

create table ligacao
(
	e_num_serie varchar(30),
	prot_lotacao int NOT NULL,
	data_lotacao date NOT NULL,
	data_devolucao date,
	data_prazo date,
	lot_status int,
	titulo_locador char(14),
	titulo_receptor char(14),
	primary key(e_num_serie,prot_lotacao),
	foreign key(e_num_serie) references equipamento(num_serie)
	ON UPDATE cascade ON DELETE cascade,
	foreign key(prot_lotacao) references e_lotado(protocolo)
	ON UPDATE cascade ON DELETE restrict,
	foreign key(titulo_receptor) references usuario(titulo)
	ON UPDATE cascade ON DELETE set null,
	foreign key(titulo_locador) references usuario(titulo)
	ON UPDATE cascade ON DELETE set null,
);

create table e_lotado_interior
(
	protocolo int NOT NULL,
	responsavel varchar(70) NOT NULL,
	unidade varchar(30) NOT NULL,
	descricao text,
	primary key(protocolo)
);

create table ligacao_interior
(
	i_num_serie varchar(30),
	prot_lotacao int NOT NULL,
	lot_status int NOT NULL,
	data_lotacao date NOT NULL,
	data_devolucao date,
	data_prazo date,
	titulo_locador char(14),
	titulo_receptor char(14),
	primary key(i_num_serie,prot_lotacao),
	foreign key(i_num_serie) references equipamento(num_serie)
	ON UPDATE cascade ON DELETE cascade,
	foreign key(prot_lotacao) references e_lotado_interior(protocolo)
	ON UPDATE cascade ON DELETE restrict,
	foreign key(titulo_receptor) references usuario(titulo)
	ON UPDATE cascade ON DELETE set null,
	foreign key(titulo_locador) references usuario(titulo)
	ON UPDATE cascade ON DELETE set null
);

create table definitivo_interior
(
	def_num_serie varchar(30),
	unidade varchar(30) NOT NULL,
	responsavel varchar(50) NOT NULL,
	data date NOT NULL,
	descricao text,
	primary key(def_num_serie),
	foreign key(def_num_serie) references equipamento(num_serie)
	ON UPDATE cascade ON DELETE cascade
);

create table usuario
(
	nome varchar(30),
	titulo char(14),
	senha varchar(100),
	nivel int,
	primary key (titulo)
);