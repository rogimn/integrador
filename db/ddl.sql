
/*
INSTITUTO FEDERAL CATARINENSE
SISTEMAS PARA INTERNET
PROJETO INTEGRADOR II - TSI 21/6
Roger Benevenutti
-
Modelo Físico para PostgreSQL
*/

CREATE TABLE logs (
    idlog SERIAL NOT NULL,
    datado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tabela VARCHAR(100) NOT NULL,
    operacao VARCHAR(10) NOT NULL,
    dados_antigos VARCHAR(250),
    dados_novos VARCHAR(250),
    CONSTRAINT logs_pkey PRIMARY KEY(idlog)
);

CREATE TABLE escolas (
    idescola SERIAL NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    nome VARCHAR(200) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    logradouro VARCHAR(200) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    uf CHAR(2) NOT NULL,
    telefone VARCHAR(15),
    celular VARCHAR(15),
    email VARCHAR(100) NOT NULL,
    observacao TEXT,
    monitor BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT escolas_pkey PRIMARY KEY(idescola)
);

CREATE TABLE pessoas (
    idpessoa SERIAL NOT NULL,
    fk_escolas_idescola INTEGER NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    nome VARCHAR(200) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    logradouro VARCHAR(200) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    uf CHAR(2) NOT NULL,
    celular VARCHAR(15),
    telefone VARCHAR(15),
    email VARCHAR(100) NOT NULL,
    observacao TEXT,
    monitor BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT pessoas_pkey PRIMARY KEY(idpessoa)
);

CREATE TABLE usuarios (
    idusuario SERIAL NOT NULL,
    tipo BOOLEAN NOT NULL,
    nome VARCHAR(200) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    monitor BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT usuarios_pkey PRIMARY KEY(idusuario)
);

CREATE TABLE notas (
    idnota SERIAL NOT NULL,
    fk_usuarios_idusuario INTEGER NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    texto TEXT NOT NULL,
    monitor BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT notas_pkey PRIMARY KEY(idnota)
);

CREATE TABLE entregas (
    identrega SERIAL NOT NULL,
    fk_usuarios_idusuario INTEGER NOT NULL,
    fk_pessoas_idpessoa INTEGER NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    datado DATE NOT NULL,
    quantidade INTEGER NOT NULL,
    monitor BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT entregas_pkey PRIMARY KEY(identrega)
);

ALTER TABLE pessoas ADD CONSTRAINT FK_pessoas_2
    FOREIGN KEY (fk_escolas_idescola)
    REFERENCES escolas (idescola)
    ON DELETE CASCADE;

ALTER TABLE entregas ADD CONSTRAINT FK_entregas_2
    FOREIGN KEY (fk_pessoas_idpessoa)
    REFERENCES pessoas (idpessoa)
    ON DELETE CASCADE;

ALTER TABLE entregas ADD CONSTRAINT FK_entregas_3
    FOREIGN KEY (fk_usuarios_idusuario)
    REFERENCES usuarios (idusuario)
    ON DELETE CASCADE;

ALTER TABLE notas ADD CONSTRAINT FK_notas_2
    FOREIGN KEY (fk_usuarios_idusuario)
    REFERENCES usuarios (idusuario)
    ON DELETE CASCADE;