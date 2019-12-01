-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 22-Dez-2018 às 18:53
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgc_pitagoras`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `insert_chave`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_chave` (IN `chave_name` VARCHAR(45), IN `chave_barcode` VARCHAR(15), IN `sector_id` INT, IN `type_id` INT)  BEGIN
    
        SET @barcode_repetido = (SELECT id FROM chaves WHERE barcode = chave_barcode);/*verifica se esse código de barras já está cadastrado*/
        
        IF(@barcode_repetido)THEN/*se o código de barras já estiver cadastrado retorna mensagem de erro*/
            
            UPDATE mensagens SET descricao = "Erro! Código de barras já cadastrado!", titulo = "Erro!", flag = "error" WHERE id = 1;
            
        ELSE/*se o código de barras não estiver cadastrado a nova chave será inserida*/
        
            SET @setor_achou = (SELECT id FROM sector WHERE id = sector_id);/*verifica se o id de setor existe*/
            
            IF(@setor_achou)THEN/*Se esse id de setor existe a nova chave será inserida*/
            
                SET @type_achou = (SELECT id FROM type WHERE id = type_id); /*verifica se o id de tipo existe*/
                
                IF(@type_achou)THEN/*se o id de tipo existir a chave nova será inserida*/
                
                    INSERT INTO chaves(barcode, name_chave, sector_id, type_id, status_id, created_at) 
                        VALUES(chave_barcode, chave_name, sector_id, type_id, 1, now());/*inserção de nova chave com o código de barras, o nome, o id do setor, o id do tipo, o id do status 1 para disponível e 2 para indisponível e a data e hora de criação*/
                        
                    UPDATE mensagens SET descricao = "Chave inserida com sucesso!", titulo = "Sucesso!", flag = "success" WHERE id = 1;
                
                ELSE/*se o id de tipo não existir retornará uma mensagem de erro*/
                
                    UPDATE mensagens SET descricao = "Erro! Tipo de chave não encontrado!", titulo = "Erro!", flag = "error" WHERE id = 1;
                
                END IF;
            
            ELSE/*se esse id de setor não existir retorna um erro*/
            
                UPDATE mensagens SET descricao = "Erro! Setor não existe!", titulo = "Erro!", flag = "error" WHERE id = 1;
            
            END IF;
        
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `insert_request`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_request` (IN `request_cpf` VARCHAR(15), IN `key_barcode` VARCHAR(15), IN `request_service` VARCHAR(45), IN `request_company` VARCHAR(45), IN `request_manager` VARCHAR(45), IN `user_id` INT)  BEGIN
    
        SET @request_achou = (SELECT id FROM requests WHERE barcode_chave = key_barcode);/*verifica se existe algum registro com esse código de barras*/
        
        IF(@request_achou)THEN /*se existir um registro com esse código de barras o registro será atualizado*/
        
            SET @status_chave = (SELECT status_id FROM chaves WHERE barcode = key_barcode);/*verifica o status da chave que está no registro*/
            
            IF(@status_chave = 1)THEN/*se o status da chave for 1 disponível o registro de empréstimo é feito*/
            
                SET @funcionario_achou = (SELECT id FROM request_users WHERE cpf = request_cpf);/*verifica se esse cpf está cadastrado*/
                
                IF(@funcionario_achou)THEN/*Se esse funcionário estiver cadastrado o seu status será verificado*/
                
                    SET @status_funcionario = (SELECT status_id FROM request_users WHERE cpf = request_cpf);/*verifica o status do funcionário*/
                    
                    IF(@status_funcionario = 1)THEN/*Se o status do funcionário for 1 liberado o registro é atualizado e a chave é emprestada*/
                    SET @porteiro_existe = (SELECT id FROM users WHERE id = user_id);/*verifica se o porteiro existe*/
                    
                    IF(@porteiro_existe)THEN
                        UPDATE requests SET request_user_cpf = request_cpf, service = request_service, company = request_company, manager = request_manager, porteiro_id = user_id, dt_emprestimo = now(), hr_emprestimo = now(), dt_devolucao = null, hr_devolucao = null WHERE barcode_chave = key_barcode;/*atualização do cpf, serviço, empresa, coordenador, porteiro, data e hora do empréstimo no registro que contém esse código de barras*/
                        
                        UPDATE chaves SET status_id = 2 WHERE barcode = key_barcode;/*mudando o status da chave para 2 indisponível*/
                        
                       
                        
                        UPDATE request_users SET status_id = 2 WHERE cpf = request_cpf;/*mudando o status do funcionário para 2 barrado*/
                        
                        UPDATE mensagens SET descricao = "Chave solicitada com sucesso!", titulo = "Sucesso!", flag = "success" WHERE id = 1;
                    ELSE
                        
                        CALL mensagem(0, "Erro! Porteiro não encontrado!");
                    END IF;
                    
                    ELSE/*Se o status do funcionário for 2 barrado a chave não será emprestada gerando um erro*/
                    
                        UPDATE mensagens SET descricao = "Erro! Funcionário não devolveu a outra chave!", titulo = "Erro!", flag = "error" WHERE id = 1;
                    
                    END IF;
                    
                ELSE/*Se o cpf não estiver cadastrado vai retornar um erro*/
                
                    UPDATE mensagens SET descricao = "Erro! Funcionário não encontrado!", titulo = "Erro!", flag = "error" WHERE id = 1;
                
                END IF;
            
            ELSE/*Se o status da chave for 2 indisponível vai retornar um erro*/
            
                UPDATE mensagens SET descricao = "Erro! Chave Indisponível!", titulo = "Erro!", flag = "error" WHERE id = 1;
            
            END IF;
        
        ELSE/*Se não existir um registro com esse código de barras ele será inserido*/
        
            SET @chave_achou = (SELECT id FROM chaves WHERE barcode = key_barcode);/*verifica se esse código de barras existe*/
            
            IF(@chave_achou)THEN/*Se esse código de barras existir o cpf vai ser verificado*/
            
                SET @funcionario_achou = (SELECT id FROM request_users WHERE cpf = request_cpf);/*verifica se esse cpf existe*/
                
                IF(@funcionario_achou)THEN/*Se esse cpf existe o status do funcionário será verificado*/
                
                    SET @status_funcionario = (SELECT status_id FROM request_users WHERE cpf = request_cpf);/*verifica o status do funcionário*/
                    
                    IF(@status_funcionario = 1)THEN/*Se o status do funcionário for 1 liberado o registro de empréstimo será inserido*/
                    
                        INSERT INTO requests(barcode_chave, service, manager, company, request_user_cpf, porteiro_id, dt_emprestimo, hr_emprestimo)
                            VALUES(key_barcode, request_service, request_manager, request_company, request_cpf, user_id, now(), now());
                            
                        UPDATE chaves SET status_id = 2 WHERE barcode = key_barcode;
                        
                        UPDATE request_users SET status_id = 2 WHERE cpf = request_cpf;
                        
                        UPDATE mensagens SET descricao = "Registro inserido com sucesso!", titulo = "Sucesso!", flag = "success" WHERE id = 1;
                    
                    ELSE/*Se o status do funcionário for igual a 2 barrado retorna um erro*/
                    
                        UPDATE mensagens SET descricao = "Erro! Funcionário não devolveu a outra chave!", titulo = "Erro!", flag = "error" WHERE id = 1;
                    
                    END IF;
                    
                    
                ELSE
                    UPDATE mensagens SET descricao = "Erro! Funcionário não encontrado!", titulo = "Erro!", flag = "error" WHERE id = 1;
                END IF;
            
            ELSE
                UPDATE mensagens SET descricao = "Erro! Chave não encontrada!", titulo = "Erro!", flag = "error" WHERE id = 1;
            END IF;
        
        END IF;
    
    
    END$$

DROP PROCEDURE IF EXISTS `insert_request_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_request_users` (IN `cpf_user` VARCHAR(15), IN `name` VARCHAR(100), IN `phone1_user` VARCHAR(15), IN `phone2_user` VARCHAR(15))  BEGIN
        
        SET @cpf = (SELECT cpf FROM request_users WHERE cpf = cpf_user);
        
        IF(@cpf)THEN
        
            UPDATE mensagens SET descricao = "Erro! Usuário já existe!", titulo = "Erro!", flag = "error" WHERE id = 1; 
        
        ELSE
            
            INSERT INTO request_users(full_name, cpf, phone1, phone2, status_id)
                VALUES(name, cpf_user, phone1_user, phone2_user, 1);
                
            UPDATE mensagens SET descricao = "Usuário inserido com sucesso!", titulo = "Sucesso!", flag = "success" WHERE id = 1;
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `insert_sector`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sector` (IN `name` VARCHAR(100))  BEGIN
        SET @repetido = (SELECT id FROM sector WHERE sector_name = name);

        IF(@repetido)THEN
            UPDATE mensagens SET descricao = "Erro! Esse setor já existe!", titulo = "Erro!", flag = "warning" WHERE id = 1;
        ELSE

            INSERT INTO sector(sector_name, created_at)
                VALUES(name, now());

            UPDATE mensagens SET descricao = "Setor inserido com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
    END IF;
 END$$

DROP PROCEDURE IF EXISTS `insert_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_users` (IN `cpf_user` VARCHAR(15), IN `name` VARCHAR(100), IN `email_user` VARCHAR(100), IN `phone1_user` VARCHAR(15), IN `phone2_user` VARCHAR(15), IN `password_user` VARCHAR(50))  BEGIN
        
        SET @cpf_repetido = (SELECT id FROM users WHERE cpf = cpf_user);/*verifica se já existe um cpf igual ao do novo usuário*/
        
        IF(@cpf_repetido)THEN/*se já existir um cpf igual retorna um erro*/
        
            UPDATE mensagens SET descricao = "Erro! CPF já cadastrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
        
        ELSE/*se não existir um cpf igual o novo usuário é inserido*/
        
            INSERT INTO users(full_name, cpf, email, password, phone1, phone2, user_status_id, permissions_id)
                VALUES(name, cpf_user, email_user, phone1_user, phone2_user, 1, 1);/*inserção do nome, cpf, email, senha, telefone 1, telefone 2, status do usuário que pode ser 1 ativo ou 2 inativo, permissão do usuário que pode ser 1 administrador e 2 para porteiro*/
                
            UPDATE mensagens SET descricao = "Usuário cadastrado com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
        
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `mensagem`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mensagem` (`tipo` INT, `retorno` VARCHAR(100))  BEGIN
IF(tipo = 1)THEN
UPDATE mensagens SET descricao = retorno, titulo = "Sucesso", flag = "sucess" WHERE id = 1; ELSE
UPDATE mensagens SET descricao = retorno, titulo = "Erro", flag = "warning" WHERE id = 1; END IF;
END$$

DROP PROCEDURE IF EXISTS `update_chave`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_chave` (IN `name_novo` VARCHAR(45), IN `chave_barcode` VARCHAR(15), IN `novo_sector_id` INT, IN `novo_type_id` INT)  BEGIN
    
        SET @barcode_achou = (SELECT id FROM chaves WHERE barcode = chave_barcode);/*verifica se esse código de barras já está cadastrado*/
        
        IF(@barcode_achou)THEN/*se o código de barras já estiver cadastrado a chave será atualizada*/
            
            SET @setor_achou = (SELECT id FROM sector WHERE id = novo_sector_id);/*verifica se o id de setor existe*/
            
            IF(@setor_achou)THEN/*Se esse id de setor existe a chave será atualizada*/
            
                SET @type_achou = (SELECT id FROM type WHERE id = novo_type_id); /*verifica se o id de tipo existe*/
                
                IF(@type_achou)THEN/*se o id de tipo existir a chave será atualizada*/
               
                    UPDATE chaves SET name_chave = name_novo, sector_id = novo_sector_id, type_id = novo_type_id, updated_at = now() WHERE barcode = chave_barcode;/*atualização do nome, id do setor, id do tipo e data e hora de atualização da chave com esse código de barras*/
                        
                    UPDATE mensagens SET descricao = "Chave atualizada com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
                
                ELSE/*se o id de tipo não existir retornará uma mensagem de erro*/
                
                    UPDATE mensagens SET descricao = "Erro! Tipo de chave não encontrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
                
                END IF;
            
            ELSE/*se esse id de setor não existir retorna um erro*/
            
                UPDATE mensagens SET descricao = "Erro! Setor não existe!", titulo = "Erro!", flag = "warning" WHERE id = 1;
            
            END IF;
            
            
        ELSE/*se o código de barras não estiver cadastrado retorna um erro*/
        
            UPDATE mensagens SET descricao = "Erro! Chave não encontrada!", titulo = "Erro!", flag = "warning" WHERE id = 1;
        
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `update_request`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_request` (IN `key_barcode` VARCHAR(15))  BEGIN
    
        SET @request_achou = (SELECT id FROM requests WHERE barcode_chave = key_barcode);/*verifica se existe algum registro com esse código de barras*/
        
        IF(@request_achou)THEN/*se existir um registro o status da chave será verificado*/
        
            SET @chave_status = (SELECT status_id FROM chaves WHERE barcode = key_barcode);
            
            IF(@chave_status = 2)THEN/*Se o status da chave for 2 indisponível ela será devolvida*/
            
                
                
                UPDATE requests SET dt_devolucao = now(), hr_devolucao = now() WHERE barcode_chave = key_barcode;/*atualizando o registro preenchendo a data e hora de devolução*/
                
                UPDATE chaves SET status_id = 1  WHERE barcode = key_barcode;/*modificando o status da chave para 1 disponível*/
                
                SET @cpf_funcionario = (SELECT request_user_cpf FROM requests WHERE barcode_chave = key_barcode);/*pegando o cpf do funcionário colocado no registro*/
                
                UPDATE request_users SET status_id = 1 WHERE cpf = @cpf_funcionario;/*mudando o status do funcionário para 1 liberado*/
                
                UPDATE mensagens SET descricao = "Chave devolvida com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
                
            ELSE/*se o status da chave for 1 disponível retorna erro*/
            
                UPDATE mensagens SET descricao = "Erro! Chave disponível!", titulo = "Erro!", flag = "warning" WHERE id = 1;
            
            END IF;
        
        ELSE/*se não existe registro com esse código de barras uma verificação de existência desse código é feita*/
        
            SET @chave_existe = (SELECT id FROM chaves WHERE barcode = key_barcode);
            
            IF(@chave_existe)THEN/*Se esse código de barras existe ele nunca foi utilizado para fazer empréstimo de chave então sua chave está disponível retornando um erro*/
            
                UPDATE mensagens SET descricao = "Erro! Chave disponível!", titulo = "Erro!", flag = "warning" WHERE id = 1;
                
            ELSE/*Se esse código não existe retorna um erro*/
            
                UPDATE mensagens SET descricao = "Erro!Chave inexistente!", titulo = "Erro!", flag = "warning" WHERE id = 1;
            
            END IF;
        
        END IF;
    
    
    END$$

DROP PROCEDURE IF EXISTS `update_requests`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_requests` (IN `key_barcode` VARCHAR(15))  BEGIN

        SET @barcode_existe = (SELECT barcode FROM chaves WHERE barcode = key_barcode);
        
        IF(@barcode_existe)THEN
    
            SET @request_id = (SELECT id FROM requests WHERE barcode_chave = key_barcode);
        
            IF(@request_id)THEN
        
                SET @status_id = (SELECT status_id FROM chaves WHERE barcode = key_barcode);
            
                IF(@status_id = 2)THEN
            
                    UPDATE requests SET dt_devolucao = now(), hr_devolucao = now() WHERE id = @request_id;
                
                    UPDATE chaves SET status_id = 1 WHERE barcode = key_barcode;
                
                    SELECT "Chave devolvida com sucesso!" AS MSG;
                ELSE
            
                    SELECT "Erro!Chave disponível!" AS MSG;
            
                END IF;
            
        
            ELSE
        
                SELECT "Erro! Chave sem registro!" AS MSG;
         
        
            END IF;
        ELSE
            SELECT "Erro! Chave inexistente!" AS MSG;
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `update_request_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_request_users` (IN `cpf_user` VARCHAR(15), IN `name_novo` VARCHAR(100), IN `phone1_novo` VARCHAR(15), IN `phone2_novo` VARCHAR(15), IN `manter_cpf` INT, IN `cpf_novo` VARCHAR(15))  BEGIN
    
        SET @cpf_achou = (SELECT id FROM request_users WHERE cpf = cpf_user);/*verifica se esse cpf está cadastrado*/
        
        IF(@cpf_achou)THEN /*Se esse cpf já estiver cadastrado suas informações serão atualizadas*/
            
            IF(manter_cpf = 1)THEN/*Se manter_cpf igual a 1 o cpf novo irá substituir o antigo*/
                
                SET @cpf_repetido = (SELECT id FROM request_users WHERE cpf = cpf_novo);/*verifica se o cpf novo já está cadastrado*/
               
                IF(@cpf_repetido)THEN/*Se o cpf novo já estiver cadastrado retornará um erro*/
                    
                    UPDATE mensagens SET descricao = "Erro! CPF novo já cadastrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
                
                ELSE/*se o cpf novo não estiver cadastrado os dados do funcionário serão atualizados*/
                    
                    UPDATE request_users SET cpf = cpf_novo, full_name = name_novo, phone1 = phone1_novo, phone2 = phone2_novo WHERE cpf = cpf_user;
                    UPDATE mensagens SET descricao = "Usuário atualizado com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
                
                END IF;
           
            ELSE/*se manter_cpf for igual a 0 o cpf não irá ser alterado, somente os outros dados*/
                
                UPDATE request_users SET full_name = name_novo, phone1 = phone1_novo, phone2 = phone2_novo WHERE cpf = cpf_user;
                
                UPDATE mensagens SET descricao = "Usuário atualizado com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
           
            END IF;
      
        ELSE/*se o cpf não for encontrado retorna um erro*/
            
            UPDATE mensagens SET descricao = "Erro! CPF não encontrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
       
        END IF;
    
    END$$

DROP PROCEDURE IF EXISTS `update_sector`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sector` (IN `id` INT, IN `name` VARCHAR(100))  BEGIN
	    SET @achou = (SELECT id FROM sector WHERE id = sector.id);
		
		IF(@achou)THEN
		
		    SET @repetido = (SELECT id FROM sector WHERE sector_name = name);
			
			IF(@repetido)THEN
			
			    UPDATE mensagens SET descricao = "Erro! Esse setor já existe, insira um nome diferente!", titulo = "Erro!", flag = "warning" WHERE id = 1;
				
			ELSE
			    UPDATE sector SET sector_name = name, updated_at = now() WHERE id = sector.id;

		        UPDATE mensagens SET descricao = "Setor atualizado com sucesso!", titulo = "Sucesso!", flag = "sucess" WHERE id = 1;
			END IF;
		
		ELSE             
		    UPDATE mensagens SET descricao = "Informação Inválida!", titulo = "Erro!", flag = "warning" WHERE id = 1;
		END IF;

	END$$

DROP PROCEDURE IF EXISTS `update_users`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_users` (IN `cpf_user` VARCHAR(15), IN `name_novo` VARCHAR(100), IN `email_novo` VARCHAR(100), IN `phone1_novo` VARCHAR(15), IN `phone2_novo` VARCHAR(15), IN `manter_cpf` INT, IN `cpf_novo` VARCHAR(15), IN `password_novo` VARCHAR(50))  BEGIN
    
        SET @cpf_achou = (SELECT id FROM users WHERE cpf = cpf_user);/*verifica se esse cpf está cadastrado*/
        
        IF(@cpf_achou)THEN /*Se esse cpf já estiver cadastrado suas informações serão atualizadas*/
            
            IF(manter_cpf = 1)THEN/*Se manter_cpf igual a 1 o cpf novo irá substituir o antigo*/
                
                SET @cpf_repetido = (SELECT id FROM users WHERE cpf = cpf_novo);/*verifica se o cpf novo já está cadastrado*/
               
                IF(@cpf_repetido)THEN/*Se o cpf novo já estiver cadastrado retornará um erro*/
                    
                    UPDATE mensagens SET descricao = "Erro! CPF novo já cadastrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
                
                ELSE/*se o cpf novo não estiver cadastrado os dados do usuário serão atualizados*/
                    
                    UPDATE users SET cpf = cpf_novo, full_name = name_novo, email = email_novo, phone1 = phone1_novo, phone2 = phone2_novo, password = password_novo WHERE cpf = cpf_user;
                
                END IF;
           
            ELSE/*se manter_cpf for igual a 0 o cpf não irá ser alterado, somente os outros dados*/
                
                UPDATE users SET full_name = name_novo, email = email_novo, phone1 = phone1_novo, phone2 = phone2_novo, password = password_novo WHERE cpf = cpf_user;
           
            END IF;
      
        ELSE/*se o cpf não for encontrado retorna um erro*/
            
            UPDATE mensagens SET descricao = "Erro! CPF não encontrado!", titulo = "Erro!", flag = "warning" WHERE id = 1;
       
        END IF;
    
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chaves`
--

DROP TABLE IF EXISTS `chaves`;
CREATE TABLE IF NOT EXISTS `chaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_chave` varchar(45) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `created_at` date NOT NULL,
  `sector_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `chaves`
--

INSERT INTO `chaves` (`id`, `name_chave`, `barcode`, `created_at`, `sector_id`, `status_id`, `type_id`) VALUES
(37, 'Lab I', '101220180200', '2018-12-09', 1, 1, 2),
(38, 'TESTE', '101220181151', '2018-12-10', 3, 2, 1),
(34, 'Lab XI', '071220181119', '2018-12-07', 1, 1, 1);

--
-- Acionadores `chaves`
--
DROP TRIGGER IF EXISTS `tgr_gerar_historico_update`;
DELIMITER $$
CREATE TRIGGER `tgr_gerar_historico_update` AFTER UPDATE ON `chaves` FOR EACH ROW BEGIN
	IF(NEW.status_id != OLD.status_id)THEN
    
    	SET @chave_nome = (SELECT name_chave FROM chaves WHERE barcode = OLD.barcode);/*pega o nome da chave que mudou de status*/
            
			SET @chave_setor = (SELECT sector_name FROM chaves INNER JOIN sector ON sector_id = sector.id WHERE barcode = OLD.barcode);/*pega o nome do setor da chave que mudou de status*/
            
			SET @chave_tipo = (SELECT type_name FROM chaves INNER JOIN type ON type_id = type.id WHERE barcode = OLD.barcode);/*pega o nome do tipo da chave que mudou de status*/
            
			SET @servico = (SELECT service FROM requests WHERE barcode_chave = OLD.barcode);/*pega o serviço registrado na chave que mudou de status*/
            
			SET @coordenador = (SELECT manager FROM requests WHERE barcode_chave = OLD.barcode);/*pega o coordenador registrado na chave que mudou de status*/
            
			SET @empresa = (SELECT company FROM requests WHERE barcode_chave = OLD.barcode);/*pega a empresa registrada na chave que mudou de status*/
			SET @funcionario_cpf = (SELECT request_user_cpf FROM requests WHERE barcode_chave = OLD.barcode);/*pega o cpf do funcionario registrado na chave que mudou de status*/
            
			SET @funcionario_nome = (SELECT full_name FROM request_users WHERE cpf = @funcionario_cpf);/*pega o nome do funcionário com esse cpf*/
            
			SET @fone1 = (SELECT phone1 FROM request_users WHERE cpf = @funcionario_cpf);/*pega o fone 1 do funcionário com esse cpf*/
            
			SET @fone2 = (SELECT phone2 FROM request_users WHERE cpf = @funcionario_cpf);/*pega o fone 2 do funcionário com esse cpf*/
            
			SET @porteiro_nome = (SELECT full_name FROM requests INNER JOIN users ON porteiro_id = users.id WHERE barcode_chave = OLD.barcode);/*pega o nome do porteiro registrado na chave que mudou de status*/
		
		IF(NEW.status_id = 2)THEN/*Se o novo status for 2 indisponível quer dizer que ele estava em 1 disponível e a chave foi emprestada*/
        
			SET @dia_emprestimo = (SELECT dt_emprestimo FROM requests WHERE barcode_chave = OLD.barcode);/*pega o dia de empréstimo registrado na chave que foi emprestada*/
            
			SET @horario_emprestimo = (SELECT hr_emprestimo FROM requests WHERE barcode_chave = OLD.barcode);/*pega a hora de empréstimo registrada na chave que foi emprestada*/
            
			INSERT INTO historico(chave_barcode, chave_name, chave_sector, chave_type, evento, data, hora, service, manager, company, request_user_cpf, request_user, request_user_phone1, request_user_phone2, porteiro)
				VALUES(OLD.barcode, @chave_nome, @chave_setor, @chave_tipo, "Empréstimo", @dia_emprestimo, @horario_emprestimo, @servico, @coordenador, @empresa, @funcionario_cpf, @funcionario_nome, @fone1, @fone2, @porteiro_nome);/*insere os registros no histórico*/
                
		ELSE/*se o novo status for 1 disponível quer dizer que o status estava em 2 indisponível e foi devolvida*/
        
			SET @dia_devolucao = (SELECT dt_devolucao FROM requests WHERE barcode_chave = OLD.barcode);/*pega o dia de devolução registrado na chave foi devolvida*/
            
			SET @horario_devolucao = (SELECT hr_devolucao FROM requests WHERE barcode_chave = OLD.barcode);/*pega a hora de devolução registrada na chave que foi devolvida*/
            
			INSERT INTO historico(chave_barcode, chave_name, chave_sector, chave_type, evento, data, hora, service, manager, company, request_user_cpf, request_user, request_user_phone1, request_user_phone2, porteiro)
				VALUES(OLD.barcode, @chave_nome, @chave_setor, @chave_tipo, "Devolução", @dia_devolucao, @horario_devolucao, @servico, @coordenador, @empresa, @funcionario_cpf, @funcionario_nome, @fone1, @fone2, @porteiro_nome);/*insere os registros no histórico*/
		
        END IF;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_barcode` varchar(15) DEFAULT NULL,
  `chave_name` varchar(45) DEFAULT NULL,
  `chave_sector` varchar(100) DEFAULT NULL,
  `chave_type` varchar(45) DEFAULT NULL,
  `evento` varchar(15) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `service` varchar(45) DEFAULT NULL,
  `manager` varchar(45) DEFAULT NULL,
  `company` varchar(45) DEFAULT NULL,
  `request_user_cpf` varchar(15) DEFAULT NULL,
  `request_user` varchar(100) DEFAULT NULL,
  `request_user_phone1` varchar(15) DEFAULT NULL,
  `request_user_phone2` varchar(15) DEFAULT NULL,
  `porteiro` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `historico`
--

INSERT INTO `historico` (`id`, `chave_barcode`, `chave_name`, `chave_sector`, `chave_type`, `evento`, `data`, `hora`, `service`, `manager`, `company`, `request_user_cpf`, `request_user`, `request_user_phone1`, `request_user_phone2`, `porteiro`) VALUES
(11, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Empréstimo', '2018-12-04', '10:34:15', 'ttttttt', 'uuuuuu', 'yyyyyy', '06481429307', 'Karollaine Nunes', '98987412347', '877451236', 'Victor Mesquita'),
(26, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Empréstimo', '2018-12-04', '21:49:23', 'asdas', 'sdfsdf', 'TR INFORMATICA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(25, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Devolução', '2018-12-04', '21:49:07', 'asdas', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(24, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Empréstimo', '2018-12-04', '21:45:25', 'asdas', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(12, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Devolução', '2018-12-04', '10:35:20', 'ttttttt', 'uuuuuu', 'yyyyyy', '06481429307', 'Karollaine Nunes', '98987412347', '877451236', 'Victor Mesquita'),
(13, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Empréstimo', '2018-12-04', '11:16:21', 'asdasda', 'asdasdas', 'asdasda', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(14, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Devolução', '2018-12-04', '11:23:59', 'asdasda', 'asdasdas', 'asdasda', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(15, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Empréstimo', '2018-12-04', '11:51:55', 'Teste', 'Teste', 'Teste', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(16, '291120182376', 'Lab I', 'ESC', 'Restrita', 'Devolução', '2018-12-04', '13:21:45', 'Teste', 'Teste', 'Teste', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(17, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Devolução', '2018-12-04', '13:51:51', 'dddddd', 'bbbbb', 'nnnnn', '2574521325', 'Jhoadyson Pereira da Silva', '98982416384', '9641120023', 'Victor Mesquita'),
(18, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Empréstimo', '2018-12-04', '15:39:19', 'asdas', 'asdasfas', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(19, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Devolução', '2018-12-04', '15:48:35', 'asdas', 'asdasfas', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(20, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Empréstimo', '2018-12-04', '15:58:05', 'asdasd', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(21, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Devolução', '2018-12-04', '16:00:25', 'asdasd', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(22, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Empréstimo', '2018-12-04', '16:08:22', 'asdas', 'asdasfas', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(23, '123456789012', 'Chave 1', 'SAA', 'Dependência', 'Devolução', '2018-12-04', '16:09:02', 'asdas', 'asdasfas', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(27, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Devolução', '2018-12-04', '21:49:58', 'asdas', 'sdfsdf', 'TR INFORMATICA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(28, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Empréstimo', '2018-12-04', '21:50:14', 'asdasd', 'asdasfas', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(29, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Devolução', '2018-12-04', '21:52:39', 'asdasd', 'asdasfas', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(30, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Empréstimo', '2018-12-04', '21:52:56', 'asdasd', 'sdfsdf', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(31, '512201800329', 'João Pereira Rodrigues', 'SAA', 'Restrita', 'Devolução', '2018-12-04', '22:12:57', 'asdasd', 'sdfsdf', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(32, '051220180107', 'Edmilton Mesquita Pinto', 'SICP', 'Restrita', 'Empréstimo', '2018-12-05', '00:15:25', 'asdasd', 'dfgdfgd', 'TR INFORMATICA', '06481429307', 'Karollaine Nunes', '98987412347', '877451236', 'Victor Mesquita'),
(33, '051220181546', 'Victor Mesquita', 'ESC Arquitetura e Urbanismo', 'Dependência', 'Empréstimo', '2018-12-05', '12:50:38', 'hkhkkhj', 'hjjhghjgjhgjhg', 'kjgkjhkjhkh', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(34, '051220180107', 'Edmilton Mesquita Pinto', 'SICP', 'Restrita', 'Devolução', '2018-12-05', '20:05:33', 'asdasd', 'dfgdfgd', 'TR INFORMATICA', '06481429307', 'Karollaine Nunes', '98987412347', '877451236', 'Victor Mesquita'),
(35, '051220181546', 'Victor Mesquita', 'ESC Arquitetura e Urbanismo', 'Dependência', 'Devolução', '2018-12-05', '20:06:04', 'hkhkkhj', 'hjjhghjgjhgjhg', 'kjgkjhkjhkh', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(36, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Empréstimo', '2018-12-07', '08:20:47', 'Teste', 'George', 'Teste', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(37, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Devolução', '2018-12-09', '22:56:49', 'Teste', 'George', 'Teste', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(38, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Empréstimo', '2018-12-09', '22:57:58', 'asdasd', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(39, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Devolução', '2018-12-09', '22:59:44', 'asdasd', 'sdfsdf', 'Dropzone Djs', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(40, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Empréstimo', '2018-12-09', '23:01:06', 'asdas', 'sdfsdf', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(41, '071220181119', 'Lab XI', 'SICP', 'Dependência', 'Devolução', '2018-12-09', '23:02:12', 'asdas', 'sdfsdf', 'TR INFORMATICA LTDA', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita'),
(42, '101220181151', 'TESTE', 'ESC', 'Dependência', 'Empréstimo', '2018-12-20', '21:16:14', 'dwefw', 'wefwef', 'sdewf', '61290749302', 'Victor Mesquita', '98991741075', '98984473556', 'Victor Mesquita');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `flag` varchar(15) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `descricao`, `flag`, `titulo`) VALUES
(1, 'Registro inserido com sucesso!', 'success', 'Sucesso!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `permissions` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `permissions_situation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `permissions`, `created_at`, `updated_at`, `permissions_situation_id`) VALUES
(1, 'Administrador', 'a:27:{s:7:\"cBackup\";s:1:\"1\";s:10:\"cPermissao\";s:1:\"1\";s:6:\"aChave\";s:1:\"1\";s:6:\"eChave\";s:1:\"1\";s:6:\"dChave\";s:1:\"1\";s:6:\"vChave\";s:1:\"1\";s:12:\"aSolicitacao\";s:1:\"1\";s:12:\"eSolicitacao\";s:1:\"1\";s:12:\"dSolicitacao\";s:1:\"1\";s:12:\"vSolicitacao\";s:1:\"1\";s:7:\"aConfig\";s:1:\"1\";s:7:\"eConfig\";s:1:\"1\";s:7:\"dConfig\";s:1:\"1\";s:7:\"vConfig\";s:1:\"1\";s:8:\"aUsuario\";s:1:\"1\";s:8:\"eUsuario\";s:1:\"1\";s:8:\"dUsuario\";s:1:\"1\";s:8:\"vUsuario\";s:1:\"1\";s:12:\"aSolicitante\";s:1:\"1\";s:12:\"eSolicitante\";s:1:\"1\";s:12:\"dSolicitante\";s:1:\"1\";s:12:\"vSolicitante\";s:1:\"1\";s:10:\"vRelatorio\";s:1:\"1\";s:6:\"aSetor\";s:1:\"1\";s:6:\"eSetor\";s:1:\"1\";s:6:\"dSetor\";s:1:\"1\";s:6:\"vSetor\";s:1:\"1\";}', '2018-11-29', NULL, 1),
(2, 'Portaria', 'a:7:{s:7:\"cBackup\";s:1:\"1\";s:6:\"aChave\";s:1:\"1\";s:6:\"vChave\";s:1:\"1\";s:12:\"aSolicitacao\";s:1:\"1\";s:12:\"eSolicitacao\";s:1:\"1\";s:12:\"dSolicitacao\";s:1:\"1\";s:12:\"vSolicitacao\";s:1:\"1\";}', '2018-12-06', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissons_situation`
--

DROP TABLE IF EXISTS `permissons_situation`;
CREATE TABLE IF NOT EXISTS `permissons_situation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `situation_name` varchar(45) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissons_situation`
--

INSERT INTO `permissons_situation` (`id`, `situation_name`, `created_at`, `updated_at`) VALUES
(1, 'Ativo', '2018-11-29', NULL),
(2, 'Inativo', '2018-11-29', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_chave` varchar(15) NOT NULL,
  `service` varchar(45) DEFAULT NULL,
  `manager` varchar(45) DEFAULT NULL,
  `company` varchar(45) DEFAULT NULL,
  `dt_emprestimo` date NOT NULL,
  `hr_emprestimo` time DEFAULT NULL,
  `dt_devolucao` date DEFAULT NULL,
  `hr_devolucao` time DEFAULT NULL,
  `request_user_cpf` varchar(15) NOT NULL,
  `porteiro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requests`
--

INSERT INTO `requests` (`id`, `barcode_chave`, `service`, `manager`, `company`, `dt_emprestimo`, `hr_emprestimo`, `dt_devolucao`, `hr_devolucao`, `request_user_cpf`, `porteiro_id`) VALUES
(28, '291120182376', 'Teste', 'Teste', 'Teste', '2018-12-04', '11:51:55', '2018-12-04', '13:21:45', '61290749302', 1),
(27, '123456789012', 'asdas', 'asdasfas', 'Dropzone Djs', '2018-12-04', '16:08:22', '2018-12-04', '16:09:02', '61290749302', 1),
(29, '512201800329', 'asdasd', 'sdfsdf', 'TR INFORMATICA LTDA', '2018-12-04', '21:52:56', '2018-12-04', '22:12:57', '61290749302', 1),
(30, '051220180107', 'asdasd', 'dfgdfgd', 'TR INFORMATICA', '2018-12-05', '00:15:25', '2018-12-05', '20:05:33', '06481429307', 1),
(31, '051220181546', 'hkhkkhj', 'hjjhghjgjhgjhg', 'kjgkjhkjhkh', '2018-12-05', '12:50:38', '2018-12-05', '20:06:04', '61290749302', 1),
(32, '071220181119', 'asdas', 'sdfsdf', 'TR INFORMATICA LTDA', '2018-12-09', '23:01:06', '2018-12-09', '23:02:12', '61290749302', 1),
(33, '101220181151', 'dwefw', 'wefwef', 'sdewf', '2018-12-20', '21:16:14', NULL, NULL, '61290749302', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `request_users`
--

DROP TABLE IF EXISTS `request_users`;
CREATE TABLE IF NOT EXISTS `request_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `request_users`
--

INSERT INTO `request_users` (`id`, `full_name`, `cpf`, `phone1`, `phone2`, `status_id`) VALUES
(1, 'Victor Mesquita', '61290749302', '98991741075', '98984473556', 2),
(3, 'Karollaine Nunes', '06481429307', '98987412347', '877451236', 1),
(4, 'Osvaldo Carlos N. Pereira', '02723185311', '98988125470', '955621401', 1),
(5, 'Cremilton Mesquita', '70566321300', '9891516499', '98988198529', 0),
(6, 'EDMILTON MESQUITA PINTO', '45000166353', '98988198529', '9891516499', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `request_users_status`
--

DROP TABLE IF EXISTS `request_users_status`;
CREATE TABLE IF NOT EXISTS `request_users_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `request_users_status`
--

INSERT INTO `request_users_status` (`id`, `name`) VALUES
(1, 'Liberado'),
(2, 'Barrado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sector`
--

DROP TABLE IF EXISTS `sector`;
CREATE TABLE IF NOT EXISTS `sector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sector`
--

INSERT INTO `sector` (`id`, `sector_name`, `created_at`, `updated_at`) VALUES
(2, 'SAA', '2018-11-29 11:35:21', NULL),
(3, 'ESC', '2018-11-29 11:35:21', NULL),
(4, 'ESC Arquitetura e Urbanismo', '2018-11-29 11:35:21', NULL),
(5, 'Gerência Operacional', '2018-11-29 11:35:21', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Disponível', '2018-11-29 11:54:16', '2018-11-29 16:22:59'),
(2, 'Indisponível', '2018-11-29 11:54:16', '2018-11-29 16:23:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_relatorio`
--

DROP TABLE IF EXISTS `status_relatorio`;
CREATE TABLE IF NOT EXISTS `status_relatorio` (
  `id` int(11) NOT NULL,
  `descricao` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `status_relatorio`
--

INSERT INTO `status_relatorio` (`id`, `descricao`) VALUES
(1, 'Sim'),
(2, 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(45) DEFAULT NULL,
  `typecol` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `type`
--

INSERT INTO `type` (`id`, `type_name`, `typecol`, `updated_at`) VALUES
(1, 'Dependência', '2018-11-29 11:54:16', NULL),
(2, 'Restrita', '2018-11-29 11:54:16', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `user_status_id` int(11) NOT NULL,
  `permissions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `full_name`, `cpf`, `email`, `password`, `phone1`, `phone2`, `user_status_id`, `permissions_id`) VALUES
(1, 'Victor Mesquita', '2574521325', 'admin@esc.com', '$2y$10$lAW0AXb0JLZxR0yDdfcBcu3BN9c2AXKKjKTdug7Or0pr6cSGtgyGO', '98982416384', '9641120023', 1, 1),
(2, 'Karollaine Nunes', '06481429307', 'karollaine@hotmail.com', '$2y$10$lAW0AXb0JLZxR0yDdfcBcu3BN9c2AXKKjKTdug7Or0pr6cSGtgyGO', '98987412347', '877451236', 1, 1),
(3, 'Osvaldo Carlos N. Pereira', '02723185311', 'osvaldo@gmail.com', '$2y$10$lAW0AXb0JLZxR0yDdfcBcu3BN9c2AXKKjKTdug7Or0pr6cSGtgyGO', '98988125470', '955621401', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_status`
--

DROP TABLE IF EXISTS `user_status`;
CREATE TABLE IF NOT EXISTS `user_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(45) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_status`
--

INSERT INTO `user_status` (`id`, `status_name`, `created_at`, `updated_at`) VALUES
(1, 'Ativo', '2018-11-29', NULL),
(2, 'Inativo', '2018-11-29', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_chaves`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_chaves`;
CREATE TABLE IF NOT EXISTS `vw_chaves` (
`id` int(11)
,`name_chave` varchar(45)
,`barcode` varchar(15)
,`sector_name` varchar(100)
,`name` varchar(45)
,`type_name` varchar(45)
,`created_at` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_historico`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_historico`;
CREATE TABLE IF NOT EXISTS `vw_historico` (
`id` int(11)
,`chave_barcode` varchar(15)
,`chave_name` varchar(45)
,`chave_sector` varchar(100)
,`chave_type` varchar(45)
,`evento` varchar(15)
,`data` date
,`hora` time
,`service` varchar(45)
,`manager` varchar(45)
,`company` varchar(45)
,`request_user_cpf` varchar(15)
,`request_user` varchar(100)
,`request_user_phone1` varchar(15)
,`request_user_phone2` varchar(15)
,`porteiro` varchar(150)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_relatorio`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_relatorio`;
CREATE TABLE IF NOT EXISTS `vw_relatorio` (
`id` int(11)
,`barcode_chave` varchar(15)
,`type_name` varchar(45)
,`name_chave` varchar(45)
,`sector_name` varchar(100)
,`descricao` varchar(4)
,`service` varchar(45)
,`manager` varchar(45)
,`company` varchar(45)
,`usuario` varchar(100)
,`request_user_cpf` varchar(15)
,`phone1` varchar(15)
,`phone2` varchar(15)
,`dt_emprestimo` date
,`hr_emprestimo` time
,`dt_devolucao` date
,`hr_devolucao` time
,`full_name` varchar(150)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_requests`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_requests`;
CREATE TABLE IF NOT EXISTS `vw_requests` (
`id` int(11)
,`barcode` varchar(15)
,`service` varchar(45)
,`manager` varchar(45)
,`company` varchar(45)
,`dt_emprestimo` date
,`hr_emprestimo` time
,`dt_devolucao` date
,`hr_devolucao` time
,`full_name` varchar(100)
,`cpf` varchar(15)
,`phone1` varchar(15)
,`name_chave` varchar(45)
,`sector_name` varchar(100)
,`name` varchar(45)
,`type_name` varchar(45)
,`porteiro` varchar(150)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_requests_disponiveis`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_requests_disponiveis`;
CREATE TABLE IF NOT EXISTS `vw_requests_disponiveis` (
`id` int(11)
,`barcode` varchar(15)
,`service` varchar(45)
,`manager` varchar(45)
,`company` varchar(45)
,`dt_emprestimo` date
,`hr_emprestimo` time
,`dt_devolucao` date
,`hr_devolucao` time
,`full_name` varchar(100)
,`name_chave` varchar(45)
,`sector_name` varchar(100)
,`name` varchar(45)
,`type_name` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_requests_indisponiveis`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_requests_indisponiveis`;
CREATE TABLE IF NOT EXISTS `vw_requests_indisponiveis` (
`id` int(11)
,`barcode` varchar(15)
,`service` varchar(45)
,`manager` varchar(45)
,`company` varchar(45)
,`dt_emprestimo` date
,`hr_emprestimo` time
,`dt_devolucao` date
,`hr_devolucao` time
,`full_name` varchar(100)
,`name_chave` varchar(45)
,`sector_name` varchar(100)
,`name` varchar(45)
,`type_name` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_users`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_users`;
CREATE TABLE IF NOT EXISTS `vw_users` (
`id` int(11)
,`full_name` varchar(150)
,`cpf` varchar(15)
,`email` varchar(100)
,`password` varchar(200)
,`phone1` varchar(15)
,`phone2` varchar(15)
,`status_name` varchar(45)
,`name` varchar(45)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_chaves`
--
DROP TABLE IF EXISTS `vw_chaves`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_chaves`  AS  select `chaves`.`id` AS `id`,`chaves`.`name_chave` AS `name_chave`,`chaves`.`barcode` AS `barcode`,`sector`.`sector_name` AS `sector_name`,`status`.`name` AS `name`,`type`.`type_name` AS `type_name`,`chaves`.`created_at` AS `created_at` from (((`chaves` join `sector` on((`chaves`.`sector_id` = `sector`.`id`))) join `status` on((`chaves`.`status_id` = `status`.`id`))) join `type` on((`chaves`.`type_id` = `type`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_historico`
--
DROP TABLE IF EXISTS `vw_historico`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_historico`  AS  select `historico`.`id` AS `id`,`historico`.`chave_barcode` AS `chave_barcode`,`historico`.`chave_name` AS `chave_name`,`historico`.`chave_sector` AS `chave_sector`,`historico`.`chave_type` AS `chave_type`,`historico`.`evento` AS `evento`,`historico`.`data` AS `data`,`historico`.`hora` AS `hora`,`historico`.`service` AS `service`,`historico`.`manager` AS `manager`,`historico`.`company` AS `company`,`historico`.`request_user_cpf` AS `request_user_cpf`,`historico`.`request_user` AS `request_user`,`historico`.`request_user_phone1` AS `request_user_phone1`,`historico`.`request_user_phone2` AS `request_user_phone2`,`historico`.`porteiro` AS `porteiro` from `historico` order by `historico`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_relatorio`
--
DROP TABLE IF EXISTS `vw_relatorio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_relatorio`  AS  select `requests`.`id` AS `id`,`requests`.`barcode_chave` AS `barcode_chave`,`type`.`type_name` AS `type_name`,`chaves`.`name_chave` AS `name_chave`,`sector`.`sector_name` AS `sector_name`,`status_relatorio`.`descricao` AS `descricao`,`requests`.`service` AS `service`,`requests`.`manager` AS `manager`,`requests`.`company` AS `company`,`request_users`.`full_name` AS `usuario`,`requests`.`request_user_cpf` AS `request_user_cpf`,`request_users`.`phone1` AS `phone1`,`request_users`.`phone2` AS `phone2`,`requests`.`dt_emprestimo` AS `dt_emprestimo`,`requests`.`hr_emprestimo` AS `hr_emprestimo`,`requests`.`dt_devolucao` AS `dt_devolucao`,`requests`.`hr_devolucao` AS `hr_devolucao`,`users`.`full_name` AS `full_name` from (((((((`requests` join `chaves` on((`requests`.`barcode_chave` = `chaves`.`barcode`))) join `request_users` on((`requests`.`request_user_cpf` = `request_users`.`cpf`))) join `sector` on((`chaves`.`sector_id` = `sector`.`id`))) join `type` on((`chaves`.`type_id` = `type`.`id`))) join `status` on((`chaves`.`status_id` = `status`.`id`))) join `status_relatorio` on((`chaves`.`status_id` = `status_relatorio`.`id`))) join `users` on((`requests`.`porteiro_id` = `users`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_requests`
--
DROP TABLE IF EXISTS `vw_requests`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_requests`  AS  select `requests`.`id` AS `id`,`requests`.`barcode_chave` AS `barcode`,`requests`.`service` AS `service`,`requests`.`manager` AS `manager`,`requests`.`company` AS `company`,`requests`.`dt_emprestimo` AS `dt_emprestimo`,`requests`.`hr_emprestimo` AS `hr_emprestimo`,`requests`.`dt_devolucao` AS `dt_devolucao`,`requests`.`hr_devolucao` AS `hr_devolucao`,`request_users`.`full_name` AS `full_name`,`requests`.`request_user_cpf` AS `cpf`,`request_users`.`phone1` AS `phone1`,`chaves`.`name_chave` AS `name_chave`,`sector`.`sector_name` AS `sector_name`,`status`.`name` AS `name`,`type`.`type_name` AS `type_name`,`users`.`full_name` AS `porteiro` from ((((((`requests` join `chaves` on((`requests`.`barcode_chave` = `chaves`.`barcode`))) join `request_users` on((`requests`.`request_user_cpf` = `request_users`.`cpf`))) join `sector` on((`chaves`.`sector_id` = `sector`.`id`))) join `type` on((`chaves`.`type_id` = `type`.`id`))) join `status` on((`chaves`.`status_id` = `status`.`id`))) join `users` on((`requests`.`porteiro_id` = `users`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_requests_disponiveis`
--
DROP TABLE IF EXISTS `vw_requests_disponiveis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_requests_disponiveis`  AS  select `requests`.`id` AS `id`,`requests`.`barcode_chave` AS `barcode`,`requests`.`service` AS `service`,`requests`.`manager` AS `manager`,`requests`.`company` AS `company`,`requests`.`dt_emprestimo` AS `dt_emprestimo`,`requests`.`hr_emprestimo` AS `hr_emprestimo`,`requests`.`dt_devolucao` AS `dt_devolucao`,`requests`.`hr_devolucao` AS `hr_devolucao`,`request_users`.`full_name` AS `full_name`,`chaves`.`name_chave` AS `name_chave`,`sector`.`sector_name` AS `sector_name`,`status`.`name` AS `name`,`type`.`type_name` AS `type_name` from (((((`requests` join `chaves` on((`requests`.`barcode_chave` = `chaves`.`barcode`))) join `request_users` on((`requests`.`request_user_cpf` = `request_users`.`cpf`))) join `sector` on((`chaves`.`sector_id` = `sector`.`id`))) join `type` on((`chaves`.`type_id` = `type`.`id`))) join `status` on((`chaves`.`status_id` = `status`.`id`))) where (`status`.`name` = 'Disponível') ;

-- --------------------------------------------------------

--
-- Structure for view `vw_requests_indisponiveis`
--
DROP TABLE IF EXISTS `vw_requests_indisponiveis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_requests_indisponiveis`  AS  select `requests`.`id` AS `id`,`requests`.`barcode_chave` AS `barcode`,`requests`.`service` AS `service`,`requests`.`manager` AS `manager`,`requests`.`company` AS `company`,`requests`.`dt_emprestimo` AS `dt_emprestimo`,`requests`.`hr_emprestimo` AS `hr_emprestimo`,`requests`.`dt_devolucao` AS `dt_devolucao`,`requests`.`hr_devolucao` AS `hr_devolucao`,`request_users`.`full_name` AS `full_name`,`chaves`.`name_chave` AS `name_chave`,`sector`.`sector_name` AS `sector_name`,`status`.`name` AS `name`,`type`.`type_name` AS `type_name` from (((((`requests` join `chaves` on((`requests`.`barcode_chave` = `chaves`.`barcode`))) join `request_users` on((`requests`.`request_user_cpf` = `request_users`.`cpf`))) join `sector` on((`chaves`.`sector_id` = `sector`.`id`))) join `type` on((`chaves`.`type_id` = `type`.`id`))) join `status` on((`chaves`.`status_id` = `status`.`id`))) where (`status`.`name` = 'Indisponível') ;

-- --------------------------------------------------------

--
-- Structure for view `vw_users`
--
DROP TABLE IF EXISTS `vw_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_users`  AS  select `users`.`id` AS `id`,`users`.`full_name` AS `full_name`,`users`.`cpf` AS `cpf`,`users`.`email` AS `email`,`users`.`password` AS `password`,`users`.`phone1` AS `phone1`,`users`.`phone2` AS `phone2`,`user_status`.`status_name` AS `status_name`,`permissions`.`name` AS `name` from ((`users` join `user_status` on((`users`.`user_status_id` = `user_status`.`id`))) join `permissions` on((`users`.`permissions_id` = `permissions`.`id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
