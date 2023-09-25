/*
INSTITUTO FEDERAL CATARINENSE
SISTEMAS PARA INTERNET
PROJETO INTEGRADOR II - TSI 21/6
Roger Benevenutti
-
Views para PostgreSQL
*/

/* View que lista todas os usuários */

CREATE VIEW vw_usuarios (idusuario, tipo, nome, usuario, senha, email, monitor)
AS SELECT idusuario, tipo, nome, usuario, senha, email, monitor
FROM usuarios;

--SELECT * FROM vw_usuarios ORDER BY tipo ASC, nome, usuario, email;

/* View que lista todas as escolas */

CREATE VIEW vw_escolas (
    idescola, codigo, nome, cep, logradouro, numero, bairro, cidade, uf, celular, telefone, email, observacao, monitor
)
AS SELECT idescola, codigo, nome, cep, logradouro, numero, bairro, cidade, uf, celular, telefone, email, observacao, monitor
FROM escolas;

--SELECT * FROM vw_escolas ORDER BY nome, bairro, email;