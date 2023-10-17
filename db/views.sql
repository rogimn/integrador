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

/* View que lista todas as notas */

CREATE VIEW vw_notas (
    idnota, idusuario, codigo, texto, monitor, created_at
)
AS SELECT nt.idnota, nt.fk_usuarios_idusuario AS idusuario, nt.codigo, nt.texto, nt.monitor, nt.created_at
FROM notas nt
INNER JOIN usuarios us ON us.idusuario = nt.fk_usuarios_idusuario;

/* View que lista todas as escolas */

CREATE VIEW vw_escolas (
    idescola, codigo, nome, cep, logradouro, numero, bairro, cidade, uf, celular, telefone, email, observacao, monitor
)
AS SELECT idescola, codigo, nome, cep, logradouro, numero, bairro, cidade, uf, celular, telefone, email, observacao, monitor
FROM escolas;

--SELECT * FROM vw_escolas ORDER BY nome, bairro, email;

/* View que lista todas as pessoas */

CREATE VIEW vw_pessoas (
    idpessoa, idescola, escola, matricula, nome, cep, logradouro, numero, bairro, cidade, uf, celular, telefone, email, observacao, monitor
)
AS SELECT ps.idpessoa, es.idescola, es.nome AS escola, ps.matricula, ps.nome, ps.cep, ps.logradouro, ps.numero, ps.bairro, ps.cidade, ps.uf, ps.celular, ps.telefone, ps.email, ps.observacao, ps.monitor
FROM pessoas ps
INNER JOIN escolas es ON es.idescola = ps.fk_escolas_idescola;

--SELECT * FROM vw_pessoas WHERE idescola = 'idescola' ORDER BY es.nome, ps.nome, ps.matricula;

/* View que lista todas as entregas */

CREATE VIEW vw_entregas (
    identrega, idusuario, usuario, idpessoa, pessoa, matricula, idescola, escola, codigo, quantidade, monitor, created_at
)
AS SELECT en.identrega, us.idusuario, us.nome AS usuario, ps.idpessoa, ps.nome AS pessoa, ps.matricula, es.idescola, es.nome AS escola, en.codigo, en.quantidade, en.monitor, en.created_at
FROM entregas en
INNER JOIN usuarios us ON us.idusuario = en.fk_usuarios_idusuario
INNER JOIN pessoas ps ON ps.idpessoa = en.fk_pessoas_idpessoa
INNER JOIN escolas es ON ps.fk_escolas_idescola = es.idescola;