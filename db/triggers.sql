/*
INSTITUTO FEDERAL CATARINENSE
SISTEMAS PARA INTERNET
PROJETO INTEGRADOR II - TSI 21/6
Roger Benevenutti
-
Triggers para PostgreSQL
*/

CREATE OR REPLACE FUNCTION fn_register_log() RETURNS TRIGGER
AS $$
DECLARE dados_antigos TEXT; dados_novos TEXT; tabela TEXT;
BEGIN
    tabela := TG_TABLE_NAME;

    IF (TG_OP = 'UPDATE') THEN
        dados_antigos := ROW(OLD.*);
        dados_novos := ROW(NEW.*);
        
        INSERT INTO logs (tabela, operacao, dados_antigos, dados_novos)
        VALUES (tabela, 'UPDATE', dados_antigos, dados_novos);

        RETURN NEW;
    ELSEIF (TG_OP = 'DELETE') THEN
        dados_antigos := ROW(OLD.*);

        INSERT INTO logs (tabela, operacao, dados_antigos, dados_novos)
        VALUES (tabela, 'DELETE', dados_antigos, DEFAULT);
        
        RETURN OLD;
    ELSEIF (TG_OP = 'INSERT') THEN
        dados_novos := ROW(NEW.*);
        
        INSERT INTO logs (tabela, operacao, dados_antigos, dados_novos)
        VALUES (tabela, 'INSERT', DEFAULT, dados_novos);
        
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER tg_registra_log
AFTER INSERT OR UPDATE OR DELETE ON alunas
FOR EACH ROW EXECUTE PROCEDURE fn_register_log();

CREATE TRIGGER tg_registra_log
AFTER INSERT OR UPDATE OR DELETE ON entregas
FOR EACH ROW EXECUTE PROCEDURE fn_register_log();

CREATE TRIGGER tg_registra_log
AFTER INSERT OR UPDATE OR DELETE ON escolas
FOR EACH ROW EXECUTE PROCEDURE fn_register_log();

CREATE TRIGGER tg_registra_log
AFTER INSERT OR UPDATE OR DELETE ON notas
FOR EACH ROW EXECUTE PROCEDURE fn_register_log();

CREATE TRIGGER tg_registra_log
AFTER INSERT OR UPDATE OR DELETE ON usuarios
FOR EACH ROW EXECUTE PROCEDURE fn_register_log();