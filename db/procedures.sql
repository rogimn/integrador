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

CREATE PROCEDURE pd_usuario_update(IN a_tipo boolean, IN a_nome character varying, IN a_usuario character varying, IN a_senha character varying, IN a_email character varying, IN a_idusuario integer)
    LANGUAGE plpgsql
    AS $$
BEGIN	
	UPDATE usuarios SET 
	tipo = a_tipo, nome = a_nome, usuario = a_usuario, senha = a_senha, email = a_email, updated_at = CURRENT_TIMESTAMP WHERE idusuario = a_idusuario;
END;
$$;

--CALL pd_usuario_update('1', 'Administrador', 'admin', 'admin', 'admin@acme.cc', 1);

/* Procedure que desativa um usuário */

CREATE OR REPLACE PROCEDURE pd_usuario_delete(a_monitor BOOLEAN,a_idusuario INTEGER)
AS $$
BEGIN
	UPDATE usuarios SET monitor = a_monitor WHERE idusuario = a_idusuario;
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_usuario_delete('0', 1);

/* Procedure que insere uma nova escola */

CREATE OR REPLACE PROCEDURE pd_insert_escola(
	a_codigo VARCHAR(20),
    a_nome VARCHAR(200),
	a_cep VARCHAR(8),
	a_endereco VARCHAR(200),
	a_bairro VARCHAR(100),
	a_cidade VARCHAR(100),
	a_estado CHAR(2),
	a_celular VARCHAR(11),
	a_telefone VARCHAR(11),
	a_email VARCHAR(100),
	a_observacao TEXT
)
AS $$
BEGIN	
	INSERT INTO escolas (codigo, nome, cep, endereco, bairro, cidade, uf, telefone, celular, email, observacao)
	VALUES (a_codigo, a_nome, a_cep, a_endereco, a_bairro, a_cidade, a_uf, a_telefone, a_celular, a_email, a_observacao);
END;
$$ LANGUAGE 'plpgsql';

--CALL pd_insert_escola('Nome do Cliente', '0', '23497510922', '88340000', 'Rua 10, 9', 'Bairro', 'Cidade', 'AC', '47988774433', '4734009988', 'nome@cliente.com', 'obs');