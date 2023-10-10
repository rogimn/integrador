/*
INSTITUTO FEDERAL CATARINENSE
SISTEMAS PARA INTERNET
PROJETO INTEGRADOR II - TSI 21/6
Roger Benevenutti
-
Procedures para PostgreSQL
*/

/* Procedure que insere um novo usuário */

CREATE OR REPLACE PROCEDURE pd_usuario_insert(
	a_tipo BOOLEAN,
	a_nome VARCHAR(200),
	a_usuario VARCHAR(50),
	a_senha VARCHAR(50),
	a_email VARCHAR(100)
)
AS $$
BEGIN	
	INSERT INTO usuarios (tipo, nome, usuario, senha, email)
	VALUES (a_tipo, a_nome, a_usuario, a_senha, a_email);
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_usuario_insert('1', 'Administrador', 'admin', 'admin', 'admin@acme.cc');

/* Procedure que atualiza os dados do usuário */

CREATE OR REPLACE PROCEDURE pd_usuario_update(IN a_tipo boolean, IN a_nome character varying, IN a_usuario character varying, IN a_senha character varying, IN a_email character varying, IN a_idusuario integer)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN	
	UPDATE usuarios SET 
	tipo = a_tipo, nome = a_nome, usuario = a_usuario, senha = a_senha, email = a_email, updated_at = a_updated_at
	WHERE idusuario = a_idusuario;
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_usuario_update('1', 'Administrador', 'admin', 'admin', 'admin@acme.cc', 1);

/* Procedure que desativa um usuário */

CREATE OR REPLACE PROCEDURE pd_usuario_delete(a_monitor BOOLEAN,a_idusuario INTEGER)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN
	UPDATE usuarios SET monitor = a_monitor, updated_at = a_updated_at WHERE idusuario = a_idusuario;
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_usuario_delete('0', 1);

/* Procedure que insere uma nova escola */

CREATE OR REPLACE PROCEDURE pd_escola_insert(
	a_codigo VARCHAR(20),
    a_nome VARCHAR(200),
	a_cep VARCHAR(8),
	a_logradouro VARCHAR(200),
	a_numero VARCHAR(10),
	a_bairro VARCHAR(100),
	a_cidade VARCHAR(100),
	a_uf CHAR(2),
	a_celular VARCHAR(11),
	a_telefone VARCHAR(11),
	a_email VARCHAR(100),
	a_observacao TEXT
)
AS $$
BEGIN	
	INSERT INTO escolas (codigo, nome, cep, logradouro, numero, bairro, cidade, uf, telefone, celular, email, observacao)
	VALUES (a_codigo, a_nome, a_cep, a_logradouro, a_numero, a_bairro, a_cidade, a_uf, a_telefone, a_celular, a_email, a_observacao);
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_insert_escola('Nome do Cliente', '0', '23497510922', '88340000', 'Rua 10, 9', 'Bairro', 'Cidade', 'AC', '47988774433', '4734009988', 'nome@cliente.com', 'obs');

/* Procedure que atualiza uma escola */

CREATE OR REPLACE PROCEDURE pd_escola_update(
    a_nome VARCHAR(200),
	a_cep VARCHAR(8),
	a_logradouro VARCHAR(200),
	a_numero VARCHAR(10),
	a_bairro VARCHAR(100),
	a_cidade VARCHAR(100),
	a_uf CHAR(2),
	a_celular VARCHAR(11),
	a_telefone VARCHAR(11),
	a_email VARCHAR(100),
	a_observacao TEXT,
	a_idescola INTEGER
)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN	
	UPDATE escolas SET nome = a_nome, cep = a_cep, logradouro = a_logradouro, numero = a_numero, bairro = a_bairro, cidade = a_cidade, uf = a_uf, telefone = a_telefone, celular = a_celular, email = a_email, observacao = a_observacao, updated_at = a_updated_at
	WHERE idescola = a_idescola;
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que desativa uma escola */

CREATE OR REPLACE PROCEDURE pd_escola_delete(a_monitor BOOLEAN, a_idescola INTEGER)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN
	UPDATE escolas SET monitor = a_monitor, updated_at = a_updated_at WHERE idescola = a_idescola;
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que insere uma nova nota */

CREATE OR REPLACE PROCEDURE pd_nota_insert(
	a_idusuario INTEGER,
	a_codigo VARCHAR(20),
    a_texto TEXT
)
AS $$
BEGIN	
	INSERT INTO notas (fk_usuarios_idusuario, codigo, texto)
	VALUES (a_idusuario, a_codigo, a_texto);
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que atualiza uma nota */

CREATE OR REPLACE PROCEDURE pd_nota_update(
    a_texto TEXT,
	a_idnota INTEGER
)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN	
	UPDATE notas SET texto = a_texto, updated_at = a_updated_at WHERE idnota = a_idnota;
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que desativa uma escola */

CREATE OR REPLACE PROCEDURE pd_nota_delete(a_monitor BOOLEAN, a_idnota INTEGER)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN
	UPDATE notas SET monitor = a_monitor, updated_at = a_updated_at WHERE idnota = a_idnota;
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que insere uma nova pessoa */

CREATE OR REPLACE PROCEDURE pd_pessoa_insert(
	a_idescola INTEGER,
	a_matricula VARCHAR(20),
    a_nome VARCHAR(200),
	a_cep VARCHAR(8),
	a_logradouro VARCHAR(200),
	a_numero VARCHAR(10),
	a_bairro VARCHAR(100),
	a_cidade VARCHAR(100),
	a_uf CHAR(2),
	a_celular VARCHAR(11),
	a_telefone VARCHAR(11),
	a_email VARCHAR(100),
	a_observacao TEXT
)
AS $$
BEGIN	
	INSERT INTO pessoas (fk_escolas_idescola, matricula, nome, cep, logradouro, numero, bairro, cidade, uf, telefone, celular, email, observacao)
	VALUES (a_idescola, a_matricula, a_nome, a_cep, a_logradouro, a_numero, a_bairro, a_cidade, a_uf, a_telefone, a_celular, a_email, a_observacao);
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que atualiza uma pessoa */

CREATE OR REPLACE PROCEDURE pd_pessoa_update(
	a_idescola INTEGER,
	a_matricula VARCHAR(20),
    a_nome VARCHAR(200),
	a_cep VARCHAR(8),
	a_logradouro VARCHAR(200),
	a_numero VARCHAR(10),
	a_bairro VARCHAR(100),
	a_cidade VARCHAR(100),
	a_uf CHAR(2),
	a_celular VARCHAR(11),
	a_telefone VARCHAR(11),
	a_email VARCHAR(100),
	a_observacao TEXT,
	a_idpessoa INTEGER
)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN	
	UPDATE pessoas SET 
	fk_escolas_idescola = a_idescola, matricula = a_matricula, nome = a_nome, cep = a_cep, logradouro = a_logradouro, numero = a_numero, bairro = a_bairro, cidade = a_cidade, uf = a_uf, telefone = a_telefone, celular = a_celular, email = a_email, observacao = a_observacao, updated_at = a_updated_at
	WHERE idpessoa = a_idpessoa;
END;
$$ LANGUAGE 'plpgsql';

/* Procedure que desativa uma pessoa */

CREATE OR REPLACE PROCEDURE pd_pessoa_delete(a_monitor BOOLEAN, a_idpessoa INTEGER)
AS $$
DECLARE
a_updated_at TIMESTAMP := clock_timestamp();
BEGIN
	UPDATE pessoas SET monitor = a_monitor, updated_at = a_updated_at WHERE idpessoa = a_idpessoa;
END;
$$ LANGUAGE 'plpgsql';