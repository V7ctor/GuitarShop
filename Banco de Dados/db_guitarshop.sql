-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Mar-2022 às 16:14
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_guitarshop`
--

create database db_guitarshop;
use db_guitarshop;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addresses_save` (IN `pidaddress` INT(11), IN `pidperson` INT(11), IN `paddress` VARCHAR(128), IN `pcomplement` VARCHAR(32), IN `pcity` VARCHAR(32), IN `pstate` VARCHAR(32), IN `pcountry` VARCHAR(32), IN `pzipcode` VARCHAR(12), IN `pdistrict` VARCHAR(32), IN `pnumber` VARCHAR(5))  BEGIN

	IF pidaddress > 0 THEN
		
		UPDATE tb_addresses
        SET
			idperson = pidperson,
            address = paddress,
            complement = pcomplement,
            city = pcity,
            state = pstate,
            country = pcountry,
            zipcode = pzipcode, 
            district = pdistrict,
            number = pnumber
		WHERE idaddress = pidaddress;
        
    ELSE
		
		INSERT INTO tb_addresses (idperson, address, complement, city, state, country, zipcode, district, number)
        VALUES(pidperson, paddress, pcomplement, pcity, pstate, pcountry, pzipcode, pdistrict, pnumber);
        
        SET pidaddress = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_addresses WHERE idaddress = pidaddress;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_brand_save` (`pidbrand` INT(11), `pnamebrand` VARCHAR(200), `pcolorbrand` CHAR(7), `ptextcolorbrand` CHAR(7))  BEGIN

	IF pidbrand > 0 THEN
		
		UPDATE tb_brands
        SET
            namebrand = pnamebrand,
            colorbrand = pcolorbrand,
            textcolorbrand = ptextcolorbrand
		WHERE idbrand = pidbrand;
        
    ELSE
		
		INSERT INTO tb_brands (idbrand, namebrand, colorbrand, textcolorbrand)
        VALUES(pidbrand, pnamebrand, pcolorbrand, ptextcolorbrand);
        
        SET pidbrand = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_brands WHERE idbrand = pidbrand;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carts_save` (IN `pidcart` INT, IN `psessionid` VARCHAR(64), IN `piduser` INT, IN `pzipcode` CHAR(8), IN `pvlfreight` DECIMAL(10,2), IN `pnrdays` INT)  BEGIN

    IF pidcart > 0 THEN
        
        UPDATE tb_carts
        SET
            sessionid = psessionid,
            iduser = piduser,
            zipcode = pzipcode,
            vlfreight = pvlfreight,
            nrdays = pnrdays
        WHERE idcart = pidcart;
        
    ELSE
        
        INSERT INTO tb_carts (sessionid, iduser, zipcode, vlfreight, nrdays)
        VALUES(psessionid, piduser, pzipcode, pvlfreight, pnrdays);
        
        SET pidcart = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_carts WHERE idcart = pidcart;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categories_save` (`pidcategory` INT, `pnamecategory` VARCHAR(130))  BEGIN
	
	IF pidcategory > 0 THEN
		
		UPDATE tb_categories
        SET namecategory = pnamecategory
        WHERE idcategory = pidcategory;
        
    ELSE
		
		INSERT INTO tb_categories (namecategory) VALUES(pnamecategory);
        
        SET pidcategory = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_categories WHERE idcategory = pidcategory;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_orders_save` (`pidorder` INT, `pidcart` INT(11), `piduser` INT(11), `pidstatus` INT(11), `pidaddress` INT(11), `pvltotal` DECIMAL(10,2))  BEGIN
	
	IF pidorder > 0 THEN
		
		UPDATE tb_orders
        SET
			idcart = pidcart,
            iduser = piduser,
            idstatus = pidstatus,
            idaddress = pidaddress,
            vltotal = pvltotal
		WHERE idorder = pidorder;
        
    ELSE
    
		INSERT INTO tb_orders (idcart, iduser, idstatus, idaddress, vltotal)
        VALUES(pidcart, piduser, pidstatus, pidaddress, pvltotal);
		
		SET pidorder = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * 
    FROM tb_orders a
    INNER JOIN tb_ordersstatus b USING(idstatus)
    INNER JOIN tb_carts c USING(idcart)
    INNER JOIN tb_users d ON d.iduser = a.iduser
    INNER JOIN tb_addresses e USING(idaddress)
    WHERE idorder = pidorder;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_products_save` (`pidproduct` INT(11), `pnameproduct` VARCHAR(200), `pvlprice` DECIMAL(10,2), `pvlwidth` DECIMAL(10,2), `pvlheight` DECIMAL(10,2), `pvllength` DECIMAL(10,2), `pvlweight` DECIMAL(10,2), `purlproduct` VARCHAR(128), `pdescriptionproduct` TEXT, `pbrandproduct` INT)  BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_products
        SET 
			nameproduct = pnameproduct,
            vlprice = pvlprice,
            vlwidth = pvlwidth,
            vlheight = pvlheight,
            vllength = pvllength,
            vlweight = pvlweight,
            urlproduct = purlproduct,
            descriptionproduct = pdescriptionproduct,
            brandproduct = pbrandproduct
        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_products (nameproduct, vlprice, vlwidth, vlheight, vllength, vlweight, urlproduct, descriptionproduct, brandproduct) 
        VALUES(pnameproduct, pvlprice, pvlwidth, pvlheight, pvllength, pvlweight, purlproduct, pdescriptionproduct, pbrandproduct);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_products WHERE idproduct = pidproduct;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userspasswordsrecoveries_create` (`piduser` INT, `pip` VARCHAR(45))  BEGIN
	
	INSERT INTO tb_userspasswordsrecoveries (iduser, ip)
    VALUES(piduser, pip);
    
    SELECT * FROM tb_userspasswordsrecoveries
    WHERE idrecovery = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usersupdate_save` (IN `piduser` INT, IN `pnameperson` VARCHAR(200), IN `pemailuser` VARCHAR(200), IN `ppassworduser` VARCHAR(255), IN `pphoneperson` VARCHAR(25), IN `pgenderperson` ENUM("M","F"), IN `pdtbirthperson` DATE, IN `pinadmin` TINYINT)  BEGIN
  
    DECLARE vidperson INT;
    
  SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    UPDATE tb_persons
    SET 
    nameperson = pnameperson,
        dtbirthperson = pdtbirthperson,
        genderperson = pgenderperson,
        phoneperson = pphoneperson
  WHERE idperson = vidperson;
    
    UPDATE tb_users
    SET
    	emailuser = pemailuser,
        passworduser = ppassworduser,
        username = pemailuser,
        inadmin = pinadmin
  WHERE iduser = piduser;
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = piduser;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_delete` (`piduser` INT)  BEGIN
    
    DECLARE vidperson INT;
    
    SET FOREIGN_KEY_CHECKS = 0;
	
	SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
	
    DELETE FROM tb_addresses WHERE idperson = vidperson;
    DELETE FROM tb_addresses WHERE idaddress IN(SELECT idaddress FROM tb_orders WHERE iduser = piduser);
	DELETE FROM tb_persons WHERE idperson = vidperson;
    
    DELETE FROM tb_userslogs WHERE iduser = piduser;
    DELETE FROM tb_userspasswordsrecoveries WHERE iduser = piduser;
    DELETE FROM tb_orders WHERE iduser = piduser;
    DELETE FROM tb_cartsproducts WHERE idcart IN(SELECT idcart FROM tb_carts WHERE iduser = piduser);
    DELETE FROM tb_carts WHERE iduser = piduser;
    DELETE FROM tb_users WHERE iduser = piduser;
    
    SET FOREIGN_KEY_CHECKS = 1;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_save` (IN `pnameperson` VARCHAR(200), IN `pgenderperson` ENUM("M","F"), IN `pphoneperson` VARCHAR(25), IN `pdtbirthperson` DATE, IN `ppassworduser` VARCHAR(255), IN `pemailuser` VARCHAR(200), IN `pinadmin` TINYINT)  BEGIN
  
    DECLARE vidperson INT;
    
  INSERT INTO tb_persons (nameperson, dtbirthperson, phoneperson, genderperson)
    VALUES(pnameperson, pdtbirthperson, pphoneperson, pgenderperson);
    
    SET vidperson = LAST_INSERT_ID();
    
    INSERT INTO tb_users (idperson, emailuser, passworduser, inadmin, username)
    VALUES(vidperson, pemailuser, ppassworduser, pinadmin, pemailuser);
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_addresses`
--

CREATE TABLE `tb_addresses` (
  `idaddress` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `address` varchar(128) NOT NULL,
  `complement` varchar(32) DEFAULT NULL,
  `city` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL,
  `zipcode` varchar(12) NOT NULL,
  `district` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_addresses`
--

INSERT INTO `tb_addresses` (`idaddress`, `idperson`, `address`, `complement`, `city`, `state`, `country`, `zipcode`, `district`, `dtregister`, `number`) VALUES
(1, 1, 'Rua Doutor Orensy Rodrigues da Silva', '341', 'Andradina', 'SP', 'Brasil', '16901-900', 'Centro', '2022-03-07 03:12:30', '341'),
(2, 10, 'Rua Primeiro de Agosto', 'at? Quadra 6', 'Bauru', 'SP', 'Brasil', '17010-011', 'Centro', '2022-03-07 03:14:32', '552');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_brands`
--

CREATE TABLE `tb_brands` (
  `idbrand` int(11) NOT NULL,
  `namebrand` varchar(200) NOT NULL,
  `colorbrand` char(7) NOT NULL,
  `textcolorbrand` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_brands`
--

INSERT INTO `tb_brands` (`idbrand`, `namebrand`, `colorbrand`, `textcolorbrand`) VALUES
(1, 'Gibson', '#d2c746', '#ffffff'),
(2, 'Ibanez', '#1972d2', '#ffffff'),
(3, 'Tagima', '#ac3939', '#ffffff'),
(4, 'Jackson', '#35c058', '#ffffff'),
(5, 'Sem Marca', '#ffffff', '#000000'),
(6, 'Vintage', '#85532e', '#ffffff'),
(7, 'Michael', '#c0d9ed', '#000000'),
(8, 'Strinberg', '#6a290b', '#ffffff'),
(9, 'Harmonics', '#c8c264', '#ffffff');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_carts`
--

CREATE TABLE `tb_carts` (
  `idcart` int(11) NOT NULL,
  `sessionid` varchar(64) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `zipcode` char(8) DEFAULT NULL,
  `vlfreight` decimal(10,2) DEFAULT NULL,
  `nrdays` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_carts`
--

INSERT INTO `tb_carts` (`idcart`, `sessionid`, `iduser`, `zipcode`, `vlfreight`, `nrdays`, `dtregister`) VALUES
(1, 'ne8k6ok1f5vaec0h70vulag8q3', NULL, NULL, NULL, NULL, '2022-03-07 00:44:58'),
(2, 'q6r7nlhi43jqja7ki7e8qbj95j', NULL, NULL, NULL, NULL, '2022-03-07 02:07:26'),
(3, 'qg3a1hrkc53pfc2b68cs4b6mo4', NULL, NULL, '209.09', 1, '2022-03-07 03:02:06'),
(4, '81f3p14m7nh62gou4kn7ilb3s1', NULL, NULL, NULL, NULL, '2022-03-07 14:44:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cartsproducts`
--

CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_cartsproducts`
--

INSERT INTO `tb_cartsproducts` (`idcartproduct`, `idcart`, `idproduct`, `dtremoved`, `dtregister`) VALUES
(1, 3, 10, '2022-03-07 00:13:36', '2022-03-07 03:11:57'),
(2, 3, 5, NULL, '2022-03-07 03:13:30'),
(3, 3, 11, NULL, '2022-03-07 03:13:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categories`
--

CREATE TABLE `tb_categories` (
  `idcategory` int(11) NOT NULL,
  `namecategory` varchar(130) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_categories`
--

INSERT INTO `tb_categories` (`idcategory`, `namecategory`) VALUES
(1, 'Guitarra'),
(2, '6 Cordas'),
(3, 'Les Paul'),
(4, 'Stratocaster'),
(5, 'Telecaster'),
(6, 'Violão Elétrico'),
(7, 'Violão Acústico'),
(8, 'Jumbo'),
(9, 'SG'),
(10, 'Floyd Rose'),
(11, 'Signature'),
(12, 'Contrabaixo'),
(13, '4 Cordas'),
(14, 'Passivo'),
(15, 'Cordas de Aço'),
(16, 'Folk');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_orders`
--

CREATE TABLE `tb_orders` (
  `idorder` int(11) NOT NULL,
  `idcart` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idstatus` int(11) NOT NULL,
  `idaddress` int(11) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_orders`
--

INSERT INTO `tb_orders` (`idorder`, `idcart`, `iduser`, `idstatus`, `idaddress`, `vltotal`, `dtregister`) VALUES
(1, 3, 1, 1, 1, '1305.34', '2022-03-07 03:12:30'),
(2, 3, 10, 4, 2, '9044.59', '2022-03-07 03:14:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_ordersstatus`
--

CREATE TABLE `tb_ordersstatus` (
  `idstatus` int(11) NOT NULL,
  `orderstatus` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_ordersstatus`
--

INSERT INTO `tb_ordersstatus` (`idstatus`, `orderstatus`, `dtregister`) VALUES
(1, 'Em Aberto', '2022-02-26 20:43:43'),
(2, 'Aguardando Pagamento', '2022-02-26 20:43:43'),
(3, 'Pago', '2022-02-26 20:44:11'),
(4, 'Entregue', '2022-02-26 20:44:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_persons`
--

CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL,
  `nameperson` varchar(200) NOT NULL,
  `phoneperson` varchar(25) DEFAULT NULL,
  `dtbirthperson` date NOT NULL,
  `genderperson` enum('M','F') NOT NULL,
  `dtregisterperson` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_persons`
--

INSERT INTO `tb_persons` (`idperson`, `nameperson`, `phoneperson`, `dtbirthperson`, `genderperson`, `dtregisterperson`) VALUES
(1, 'Administrador', '14 99832-2122', '1982-05-23', 'M', '2022-03-06 23:55:59'),
(2, 'Heloise Camila Lima', '(69) 98119-0424', '1991-01-24', 'F', '2022-03-07 00:13:44'),
(3, 'Oliver Joao Nascimento', '(62) 2825-5801', '1986-03-03', 'M', '2022-03-07 00:19:55'),
(4, 'Anthony Noah Cardoso', '(62) 98981-7394', '1980-07-24', 'M', '2022-03-07 00:25:46'),
(5, 'jggjfg', '(41) 3905-0666', '2001-03-10', 'M', '2022-03-07 00:27:56'),
(6, 'adada', '(41) 3905-0666', '2001-03-10', 'M', '2022-03-07 00:29:23'),
(8, 'Oliver Joao Nascimento', '14 99388383', '2001-03-10', 'M', '2022-03-07 00:33:58'),
(9, 'Levi Vinicius Lima', '(98) 99518-9747', '1986-04-03', 'M', '2022-03-07 00:45:45'),
(10, 'Fernanda Claudia Assis', '(67) 99780-7274', '2000-10-20', 'F', '2022-03-07 00:50:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_products`
--

CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL,
  `nameproduct` varchar(200) NOT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `vlwidth` decimal(10,2) NOT NULL,
  `vlheight` decimal(10,2) NOT NULL,
  `vllength` decimal(10,2) NOT NULL,
  `vlweight` decimal(10,2) NOT NULL,
  `urlproduct` varchar(128) NOT NULL,
  `descriptionproduct` text NOT NULL,
  `brandproduct` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_products`
--

INSERT INTO `tb_products` (`idproduct`, `nameproduct`, `vlprice`, `vlwidth`, `vlheight`, `vllength`, `vlweight`, `urlproduct`, `descriptionproduct`, `brandproduct`, `dtregister`) VALUES
(1, 'Violão Medium Jumbo TW-29', '1099.00', '0.10', '0.10', '0.10', '0.10', 'Violão-Medium-Jumbo-TW-29', 'Construção de qualidade é uma das maiores preocupações da Tagima, por isso esse instrumento é confeccionado em Spruce no tampo e Linden no corpo, oferecendo assim, uma sonoridade bem equilibrada e definida. O seu braço é trabalhado em Okoume, para garantir um belo acabamento e estética ao violão. ', 3, '2022-03-07 01:37:21'),
(2, 'Les Paul V100MRJBM Icon Series', '3999.00', '0.10', '0.10', '0.10', '0.10', 'Les-Paul-Vintage-V100MRJBM-Icon-Series', ' Vintage V100MR JBM. Esta guitarra é inspiradas na Les Paul do guitarrista de blues-rock, Joe Bonamassa. Um aspecto que não poderia faltar é o detalhe relic, onde foram feitas as mesmas marcas de uso na pintura, assim como a moldura dos captadores, o escudo preto e os knobs de duas cores. Belíssima Les Paul Gold Top, equipadas com ferragens e captadores genuínos da Wilkinson.\r\n\r\nGuitarra elétrica 6 cordas Vintage ICON V100 series, corpo em mogno, braço em mogno (colado), escala em rosewood, 22 trastes, marcação Pearloid Crown, captadores Wilkinson®, tarraxas Wilkinson®. ', 6, '2022-03-07 01:41:51'),
(3, 'Guitarra Strato Michael GM217N', '888.00', '0.10', '0.10', '0.10', '0.10', 'Guitarra-Strato-Michael-GM217N', 'A Guitarra Strato Michael GM217N é a novidade para aqueles que procuram um produto de construção arrojada e visual marcante. Construída de um corpo em Basswood, escala em Blackwood e braço em Hard Maple, ela é capaz de ressaltar a pressão dos solos e dos riffs dos estilos musicais. E traz conforto ao guitarrista com seu tensor Dual Action, o qual permite o ajuste perfeito do braço do instrumento.\r\nAlém disso, equipada com 3 captadores Single-Coil alinhados com seu circuito de 1 volume e 2 tones, a Michael GM217N apresenta sustain de respeito e um timbre pulsante, além de um preciso controle de sonoridade e volume.', 7, '2022-03-07 01:47:16'),
(4, 'Guitarra Jackson Soloist SLX 583 - Koa', '7000.00', '0.10', '0.10', '0.10', '0.10', 'Guitarra-Jackson-Soloist-SLX-583-Koa', 'O guitarra Jackson X Série Soloist SLX KOA foi construída com um único objetivo, DESEMPENHO.\r\n\r\nO par de captadores Duncan Design, somados ao corpo em basswood, braço em maple (neck thru), a escala em rosewood com raio composto e a ponte Floyd Rose, produzem uma tocabilidade e sustain incríveis!!!', 4, '2022-03-07 01:50:37'),
(5, 'Guitarra SG Epiphone Gibson', '7765.50', '0.10', '0.10', '0.10', '0.10', 'Guitarra-SG-Epiphone-Gibson', 'A Guitarra SG Epiphone Standard chegou surpreendendo a todos com tanta qualidade! Inspirada nos famosos designs da Gibson, essa gracinha recria as clássicas Solid Guitars dos anos 1960, que impulsionaram toda uma geração de instrumentistas do Heavy Metal e Hard Rock, entre eles AC/DC e Black Sabbath.\r\n\r\nO corpo e braço dessa guitarra são construídos em Mahogany, uma madeira densa de timbre aveludado que proporciona graves acentuados, ideais para o rock! O Headstock Kalamazoo e o braço de perfil arredondado, proporcionam mais conforto ao músico, seguidos de uma linda pestana em Graph Tech, Tarraxas Epiphone Deluxe 18:1 e escudo preto no formato “batwing”, que embelezam o visual do instrumento com um charme especial que apenas a Epiphone poderia oferecer.\r\n\r\nAo falarmos do sistema elétrico da Standard, não podemos deixar de citar os potenciômetros CTS e o incrível par de Captadores Humbuckers Alnico Classic PRO™, que são responsáveis por oferecer um som robusto com graves acentuados. Por produzirem menos ruídos, são ideais para guitarristas de estilos mais pesados como o rock n’ roll.', 1, '2022-03-07 01:53:03'),
(6, 'Guitarra Telecaster Vintage V52MR', '3843.32', '0.10', '0.10', '0.10', '0.10', 'Guitarra-Telecaster-Vintage-V52MR', 'A V52MR Icon Series tem o clássico shape Telecaster. A começar pela sua construção, essa guitarra é versátil e pode atender aos mais variados estilos musicais. Leva em sua confecção braço denso em Hard Maple e um corpo em American Alder, além de uma escala em Maple, que compõe uma sonoridade equilibrada, porém encorpada, que se sobressai nos mais diversos estilos musicais. É fabricada com junção Bolt-On Neck (braço parafusado), garantindo maior praticidade em manutenções e peso para os acordes tocados. ', 6, '2022-03-07 01:56:00'),
(7, 'Tagima K2 Signature Kiko Loureiro', '2754.70', '0.10', '0.10', '0.10', '0.10', 'Tagima-K2-Signature-Kiko-Loureiro', '- Corpo: Cedro com rebaixo traseiro\r\n- Braço: Marfim\r\n- Escala: Rosewood\r\n- Marcação: Bolinha em abalone\r\n- Trastes: 27 trastes jumbo\r\n- Captação: Passiva\r\n- Captadores: Tagima Pickups - Ponte Hot Bucker, Braço Super Rails\r\n- Ponte: Floyd Rose System\r\n- Controles: Volume, tonalidade\r\n- Tarraxas: Blindadas\r\n- Ferragem: Cromo Acetinado\r\n- Acessórios: Case de luxo com chave, alavanca, chaves de Regulagem\r\n- Origem: Brasil', 3, '2022-03-07 02:00:59'),
(8, 'Baixo Precision Strinberg PBS-50', '1349.32', '0.10', '0.10', '0.10', '0.10', 'Baixo-Precision-Strinberg-PBS-50', ' Para aquelas linhas gravemente sonoras, é necessário ter um contrabaixo com boa construção e “poder de fogo” para isso!\r\nO Strinberg PBS-50 possui seu corpo em Ash e seu braço em Maple, os dois são em construção Bolt-On, onde o corpo e o braço são parafusados!\r\n\r\nA sua escala é em Rosewood e as tarraxas são Cromadas o que garante maior estabilidade na afinação do instrumento! Na parte elétrica, o Strinberg PBS-50 possui 1 captador de Precision Bass e o outro de Jazz Bass, sendo 2 Knobs de Volume individual de cada captador e 1 Knob de Tone, para ambos. ', 8, '2022-03-07 02:05:27'),
(9, 'Violão Clássico Harmonics GS11', '588.90', '0.10', '0.10', '0.10', '0.10', 'Violão-Clássico-Harmonics-GS11', 'O Violão de Aço GS-11NT da HARMONICS é um sucesso de vendas, ótimo para quem quer um violão para estudo ou reunir seus amigos, fazer uma roda e tocar suas músicas favoritas. Ele possui um som ótimo e uma acústica muito boa, resultando em um excelente custo-benefício.\r\n\r\nOs instrumentos Harmonics se segmentam em: Sopro, Cordas e Microfones. Produtos tecnológicos desenvolvidos com as mais recentes tendências de mercado globais, mantendo o comprometimento com a qualidade e competitividade dos produtos oferecidos', 9, '2022-03-07 02:10:23'),
(10, 'Guitarra Les Paul Strinberg LPS-200', '1248.00', '0.10', '0.10', '0.10', '0.10', 'Guitarra-Les-Paul-Strinberg-LPS-200', ' A Strinberg é uma marca de instrumentos de cordas, como guitarras, contrabaixos, violões e baixolões que vem a cada ano ganhando espaço no cenário nacional. Com seus produtos de ótima qualidade sonora e incrível custo/benefício, os instrumentos Strinberg são bem recebidos, em especial, pelos músicos iniciantes, mas também por profissionais.\r\n\r\nA Strinberg aplica todo seu conhecimento e tecnologia no desenvolvimento de ótimos instrumentos musicais em guitarras com qualidade muito boa e acessíveis à todos os músicos iniciantes. ', 8, '2022-03-07 02:18:22'),
(11, 'Guitarra Strinberg LP LPS230 BK', '1070.00', '0.10', '0.10', '0.10', '0.10', 'Guitarra-Strinberg-LP-LPS230-BK', 'A Strinberg é uma marca de instrumentos de cordas, como guitarras, contrabaixos, violões e baixolões que vem a cada ano ganhando espaço no cenário nacional. Com seus produtos de ótima qualidade sonora e incrível custo/benefício, os instrumentos Strinberg são bem recebidos, em especial, pelos músicos iniciantes, mas também por profissionais.', 8, '2022-03-07 02:22:43'),
(12, 'Violão Folk Strinberg SD300C', '1399.41', '0.10', '0.10', '0.10', '0.10', 'Violão-Folk-Strinberg-SD300C', 'Você encontra este violão disponível nas madeiras Koa ou Walnut, ambos materiais de alta qualidade que oferecem um timbre fantástico a quem toca! Isso se não falarmos do braço em Nato, madeira que consegue equilibrar muito bem as notas do instrumento, dando o toque final que você procurava em seu repertório.\r\n\r\nNão acabou por aí! O sistema elétrico do SD300C é repleto de funcionalidades sensacionais para você, contando com um Pré-Amplificador SE-X e Captação Piezo trabalhando juntos para garantir mais desempenho sonoro ao seu instrumento. Nos palcos ou ensaios, basta conectar seu violão a um amplificador ou caixa de som e aproveitar tudo que ele pode oferecer!', 8, '2022-03-07 03:04:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_productscategories`
--

CREATE TABLE `tb_productscategories` (
  `idcategory` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_productscategories`
--

INSERT INTO `tb_productscategories` (`idcategory`, `idproduct`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(3, 2),
(3, 10),
(3, 11),
(4, 3),
(4, 4),
(4, 7),
(5, 6),
(6, 1),
(6, 12),
(7, 9),
(8, 1),
(9, 5),
(10, 7),
(11, 7),
(12, 8),
(13, 8),
(14, 8),
(15, 1),
(15, 9),
(16, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reviewproducts`
--

CREATE TABLE `tb_reviewproducts` (
  `reviewproductid` int(11) NOT NULL,
  `commentproduct` text NOT NULL,
  `fkuser` int(11) NOT NULL,
  `fkproduct` int(11) NOT NULL,
  `dtcomment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_reviewproducts`
--

INSERT INTO `tb_reviewproducts` (`reviewproductid`, `commentproduct`, `fkuser`, `fkproduct`, `dtcomment`) VALUES
(1, 'ótimo instrumento!!!', 4, 4, '2022-03-07 03:06:54'),
(2, 'A escala em rosewood é excelente.', 4, 2, '2022-03-07 03:07:38'),
(3, 'ótima captação!!!', 2, 11, '2022-03-07 03:08:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_saleproduct`
--

CREATE TABLE `tb_saleproduct` (
  `idsaleproduct` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `newprice` decimal(10,2) NOT NULL,
  `oldprice` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtendsale` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_saleproduct`
--

INSERT INTO `tb_saleproduct` (`idsaleproduct`, `idproduct`, `newprice`, `oldprice`, `dtregister`, `dtendsale`) VALUES
(1, 4, '7000.00', '7588.00', '2022-03-07 03:10:02', '2022-03-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userpreferences`
--

CREATE TABLE `tb_userpreferences` (
  `id_userpreference` int(11) NOT NULL,
  `fkuser` int(11) NOT NULL,
  `receiveemail` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_userpreferences`
--

INSERT INTO `tb_userpreferences` (`id_userpreference`, `fkuser`, `receiveemail`) VALUES
(1, 1, 0),
(3, 2, 1),
(4, 3, 0),
(5, 10, 1),
(6, 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `emailuser` varchar(200) NOT NULL,
  `passworduser` varchar(255) NOT NULL,
  `inadmin` tinyint(4) NOT NULL,
  `dtregisteruser` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idperson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`iduser`, `username`, `emailuser`, `passworduser`, `inadmin`, `dtregisteruser`, `idperson`) VALUES
(1, 'admin@gmail.com', 'admin@gmail.com', '$2y$12$Tfo5e9HFKl/i8hjJsKCl5.GYt1lq2mhQHIxrI42J.LVRhjZK4lbdu', 1, '2022-03-06 23:55:59', 1),
(2, 'heloise_camila@hotmail.com', 'heloise_camila@hotmail.com', '$2y$12$ZNpSaObu0ubCdFkp6j.Bd.ahIqQyuH2Sp0D7OWetPmagN83FrzLzi', 0, '2022-03-07 00:13:44', 2),
(3, 'olivernasc72@gmail.com.br', 'olivernasc72@gmail.com.br', '$2y$12$yCJpMD/NDxsjuyS2zi0C/ec.wRY/EmfC2AAxEaQlMwyTJTVP.5vR6', 0, '2022-03-07 00:19:55', 3),
(4, 'anthonycardoso81@gmail.com', 'anthonycardoso81@gmail.com', '$2y$12$zi74.2WpCPdfhzPUtwwCrOEmyefE22c3sJ6lK8Ngwh8hWRI3pje9a', 0, '2022-03-07 00:25:46', 4),
(9, 'leviviniciuslima@sp.gov.br', 'leviviniciuslima@sp.gov.br', '$2y$12$zqbXp9uhFVROOahFfg4NWuklk.Xt4pljcU4XmVSycWuZ6BJtHiVge', 0, '2022-03-07 00:45:46', 9),
(10, 'fernanda@gmail.com.br', 'fernanda@gmail.com.br', '$2y$12$7nxWmzVecneRZIt6uzJuUeh0getYqmubZKVhYEdSNsGIz09BUiK1S', 0, '2022-03-07 00:50:21', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userslogs`
--

CREATE TABLE `tb_userslogs` (
  `idlog` int(11) NOT NULL,
  `log` varchar(128) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `useragent` varchar(128) NOT NULL,
  `sessionid` varchar(64) NOT NULL,
  `url` varchar(128) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dtregisteruserlog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userspasswordsrecoveries`
--

CREATE TABLE `tb_userspasswordsrecoveries` (
  `idrecovery` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `dtrecovery` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_addresses`
--
ALTER TABLE `tb_addresses`
  ADD PRIMARY KEY (`idaddress`),
  ADD KEY `fk_addresses_persons_idx` (`idperson`);

--
-- Indexes for table `tb_brands`
--
ALTER TABLE `tb_brands`
  ADD PRIMARY KEY (`idbrand`);

--
-- Indexes for table `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD PRIMARY KEY (`idcart`),
  ADD KEY `FK_carts_users_idx` (`iduser`);

--
-- Indexes for table `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  ADD PRIMARY KEY (`idcartproduct`),
  ADD KEY `FK_cartsproducts_carts_idx` (`idcart`),
  ADD KEY `fk_cartsproducts_products_idx` (`idproduct`);

--
-- Indexes for table `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`idcategory`);

--
-- Indexes for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`idorder`),
  ADD KEY `FK_orders_users_idx` (`iduser`),
  ADD KEY `fk_orders_ordersstatus_idx` (`idstatus`),
  ADD KEY `fk_orders_carts_idx` (`idcart`),
  ADD KEY `fk_orders_addresses_idx` (`idaddress`);

--
-- Indexes for table `tb_ordersstatus`
--
ALTER TABLE `tb_ordersstatus`
  ADD PRIMARY KEY (`idstatus`);

--
-- Indexes for table `tb_persons`
--
ALTER TABLE `tb_persons`
  ADD PRIMARY KEY (`idperson`);

--
-- Indexes for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`idproduct`),
  ADD KEY `fk_brand` (`brandproduct`);

--
-- Indexes for table `tb_productscategories`
--
ALTER TABLE `tb_productscategories`
  ADD PRIMARY KEY (`idcategory`,`idproduct`),
  ADD KEY `fk_productscategories_products_idx` (`idproduct`);

--
-- Indexes for table `tb_reviewproducts`
--
ALTER TABLE `tb_reviewproducts`
  ADD PRIMARY KEY (`reviewproductid`),
  ADD KEY `fkproduct` (`fkproduct`),
  ADD KEY `fkuser` (`fkuser`);

--
-- Indexes for table `tb_saleproduct`
--
ALTER TABLE `tb_saleproduct`
  ADD PRIMARY KEY (`idsaleproduct`),
  ADD KEY `idproduct` (`idproduct`);

--
-- Indexes for table `tb_userpreferences`
--
ALTER TABLE `tb_userpreferences`
  ADD PRIMARY KEY (`id_userpreference`),
  ADD KEY `fkuser` (`fkuser`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `idperson` (`idperson`);

--
-- Indexes for table `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  ADD PRIMARY KEY (`idlog`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  ADD PRIMARY KEY (`idrecovery`),
  ADD KEY `fk_userspasswordsrecoveries_users_idx` (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_addresses`
--
ALTER TABLE `tb_addresses`
  MODIFY `idaddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_brands`
--
ALTER TABLE `tb_brands`
  MODIFY `idbrand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_carts`
--
ALTER TABLE `tb_carts`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  MODIFY `idcartproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_ordersstatus`
--
ALTER TABLE `tb_ordersstatus`
  MODIFY `idstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_persons`
--
ALTER TABLE `tb_persons`
  MODIFY `idperson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `idproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_reviewproducts`
--
ALTER TABLE `tb_reviewproducts`
  MODIFY `reviewproductid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_saleproduct`
--
ALTER TABLE `tb_saleproduct`
  MODIFY `idsaleproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_userpreferences`
--
ALTER TABLE `tb_userpreferences`
  MODIFY `id_userpreference` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  MODIFY `idlog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  MODIFY `idrecovery` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_addresses`
--
ALTER TABLE `tb_addresses`
  ADD CONSTRAINT `fk_addresses_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD CONSTRAINT `fk_carts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  ADD CONSTRAINT `fk_cartsproducts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD CONSTRAINT `fk_orders_addresses` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_ordersstatus` FOREIGN KEY (`idstatus`) REFERENCES `tb_ordersstatus` (`idstatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_products`
--
ALTER TABLE `tb_products`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brandproduct`) REFERENCES `tb_brands` (`idbrand`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_productscategories`
--
ALTER TABLE `tb_productscategories`
  ADD CONSTRAINT `fk_productscategories_categories` FOREIGN KEY (`idcategory`) REFERENCES `tb_categories` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productscategories_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_reviewproducts`
--
ALTER TABLE `tb_reviewproducts`
  ADD CONSTRAINT `tb_reviewproducts_ibfk_1` FOREIGN KEY (`fkproduct`) REFERENCES `tb_products` (`idproduct`),
  ADD CONSTRAINT `tb_reviewproducts_ibfk_2` FOREIGN KEY (`fkuser`) REFERENCES `tb_users` (`iduser`);

--
-- Limitadores para a tabela `tb_saleproduct`
--
ALTER TABLE `tb_saleproduct`
  ADD CONSTRAINT `tb_saleproduct_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`);

--
-- Limitadores para a tabela `tb_userpreferences`
--
ALTER TABLE `tb_userpreferences`
  ADD CONSTRAINT `fkuser` FOREIGN KEY (`fkuser`) REFERENCES `tb_users` (`iduser`);

--
-- Limitadores para a tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `idperson` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`);

--
-- Limitadores para a tabela `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  ADD CONSTRAINT `iduser` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);

--
-- Limitadores para a tabela `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  ADD CONSTRAINT `fk_userspasswordsrecoveries_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
