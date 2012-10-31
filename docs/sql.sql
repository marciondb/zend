-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 31/10/2012 às 11h49min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `pinhonline11`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_area`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`id_area`, `titulo`) VALUES
(1, 'FINANCEIRO'),
(2, 'CRÃ‰DITO'),
(3, 'COBRANÃ‡A'),
(4, 'CRÃ‰DITO E COBRANÃ‡A'),
(5, 'CAIXA & CREDIÃRIO'),
(6, 'VENDAS'),
(7, 'COMPRAS'),
(8, 'LOGÃSTICA'),
(9, 'ALO'),
(10, 'ADMINISTRATIVO'),
(11, 'DEPARTAMENTO PESSOAL'),
(12, 'RECURSOS HUMANOS'),
(13, 'CONTAS A PAGAR'),
(14, 'CONTAS A RECEBER'),
(15, 'INFORMATICA'),
(16, 'COMPORTAMENTAL'),
(17, 'SUPORTE'),
(18, 'LIDERANÃ‡A'),
(19, 'PRODUÃ‡ÃƒO'),
(20, 'ATENDIMENTO TELEFÃ”NICO'),
(21, 'FERRAMENTAS DA P&C'),
(22, 'ENTREGAS'),
(23, 'CENTRO DE DISTRIBUIÃ‡ÃƒO'),
(24, 'FORNECEDORES ESPECÃFICOS DA EMPRESA '),
(25, 'DIVERSOS'),
(26, 'PÃ“S VENDA PASSIVO'),
(27, 'ESTOQUE'),
(28, 'FATURAMENTO'),
(29, 'ATENDIMENTO'),
(30, 'VITRINE'),
(31, 'MARKETING'),
(32, 'EXPEDIÃ‡ÃƒO'),
(33, 'COMUNICAÃ‡ÃƒO'),
(34, 'DEPARTAMENTO CONTÃBIL'),
(35, 'MOTORISTA DE Ã”NIBUS'),
(36, 'COBRADOR DE Ã”NIBUS'),
(37, 'TROCAS'),
(38, 'BANCÃRIA'),
(39, 'CONTÃBIL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivo`
--

CREATE TABLE IF NOT EXISTS `arquivo` (
  `id_arquivo` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) DEFAULT NULL,
  `id_lda` int(11) DEFAULT NULL,
  `id_subtema` int(11) DEFAULT NULL,
  `id_ferramenta` int(11) DEFAULT NULL,
  `nome_arquivo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_arquivo`),
  KEY `fk_relationship_16` (`id_tema`),
  KEY `fk_relationship_17` (`id_subtema`),
  KEY `fk_relationship_32` (`id_ferramenta`),
  KEY `fk_relationship_33` (`id_lda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivo_liberado`
--

CREATE TABLE IF NOT EXISTS `arquivo_liberado` (
  `id_arquivo_liberado` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_arquivo` int(11) NOT NULL,
  `data_liberacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_arquivo_liberado`),
  KEY `fk_relationship_71` (`id_arquivo`),
  KEY `fk_relationship_72` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

CREATE TABLE IF NOT EXISTS `atividade` (
  `id_descricao` int(11) NOT NULL AUTO_INCREMENT,
  `id_generico_lda` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`id_descricao`),
  KEY `fk_origem_atividade` (`id_empresa`),
  KEY `fk_relationship_25` (`id_setor`),
  KEY `fk_relationship_29` (`id_generico_lda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_escolhida_qqp`
--

CREATE TABLE IF NOT EXISTS `atividade_escolhida_qqp` (
  `id_descricao` int(11) NOT NULL,
  `id_qqp` int(11) NOT NULL,
  PRIMARY KEY (`id_descricao`,`id_qqp`),
  KEY `fk_atividade_escolhida_qqp2` (`id_qqp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Extraindo dados da tabela `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `titulo`) VALUES
(1, 'VENDEDOR'),
(2, 'CAIXA'),
(3, 'COMPRADOR'),
(4, 'AUXILIAR ADMINISTRATIVO'),
(5, 'ENTREGADOR'),
(6, 'MONTADOR'),
(7, 'MOTORISTA'),
(8, 'AJUDANTE DE ENTREGA'),
(9, 'GERENTE'),
(10, 'CREDIARISTA'),
(11, 'PORTEIRO'),
(12, 'AUXILIAR DE SERVIÃ‡OS GERAIS'),
(15, 'ESTAGIÃRIO'),
(17, 'ARQUITETO'),
(18, 'ESTOQUISTA'),
(20, 'MENOR APRENDIZ'),
(22, 'AUXILIAR DE ESCRITÃ“RIO'),
(23, 'DIRETOR'),
(24, 'COORDENADOR'),
(25, 'FAXINEIRA'),
(26, 'ALMOXARIFE'),
(27, 'FATURAMENTO'),
(28, 'SUPERVISOR ADM'),
(29, 'DESIGNER'),
(30, 'AUXILIAR DE ALMOXARIFADO'),
(31, 'CONTAS A PAGAR'),
(32, 'GERENTE ADM'),
(33, 'CONTAS A RECEBER'),
(34, 'SUPERVISOR'),
(35, 'SUPERVISOR COMERCIAL'),
(36, 'SUPORTE GERAL'),
(37, 'GERENTE TI'),
(38, 'OFFICE BOY'),
(39, 'PROMOTOR DE VENDAS'),
(40, 'GERENTE RH'),
(41, 'RECEPCIONISTA'),
(42, 'SUBGERENTE'),
(43, 'TESOUREIRA'),
(45, 'COBRADOR COMISSIONADO'),
(52, 'GENÃ‰RICO OPERACIONAL ADM'),
(47, 'COBRADOR DE Ã”NIBUS'),
(48, 'TELEFONISTA'),
(49, 'VENDEDOR EXTERNO'),
(50, 'AUXILIAR DE INFORMÃTICA'),
(51, 'AUXILIAR DE VENDAS'),
(53, 'CONFERENTE DE ESTOQUE'),
(54, 'VENDEDOR DE LOJA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_empresa`
--

CREATE TABLE IF NOT EXISTS `categoria_empresa` (
  `id_categoria_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_categoria_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `celular` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_relationship_48` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_empresa`
--

CREATE TABLE IF NOT EXISTS `cliente_empresa` (
  `id_cliente` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_cliente`,`id_empresa`),
  KEY `fk_cliente_empresa2` (`id_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria_empresa` int(11) NOT NULL,
  `id_qnp` int(11) DEFAULT NULL,
  `id_operadora_celular` int(11) DEFAULT NULL,
  `id_operadora_celular2` int(11) DEFAULT NULL,
  `id_ramo_empresa` int(11) NOT NULL,
  `id_matriz` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `telefone_1` varchar(11) NOT NULL,
  `telefone_2` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome_fantasia` varchar(250) DEFAULT NULL,
  `nome_contato_1` varchar(250) DEFAULT NULL,
  `tels_contato_1` varchar(11) DEFAULT NULL,
  `email_contato_1` varchar(250) DEFAULT NULL,
  `nome_contato_2` varchar(250) DEFAULT NULL,
  `tels_contato_2` varchar(11) DEFAULT NULL,
  `email_contato_2` varchar(250) DEFAULT NULL,
  `id_operadora_celular_contato_1` int(11) NOT NULL,
  `id_operadora_celular_contato_2` int(11) NOT NULL,
  `cel_contato_1` varchar(11) NOT NULL,
  `cel_contato_2` varchar(11) NOT NULL,
  `razao_social` varchar(250) DEFAULT NULL,
  `apelido` varchar(200) DEFAULT NULL,
  `cnpj` varchar(14) NOT NULL,
  `inscricao_estadual` varchar(50) DEFAULT NULL,
  `celular_1` varchar(11) DEFAULT NULL,
  `celular_2` varchar(11) DEFAULT NULL,
  `fax_1` varchar(11) DEFAULT NULL,
  `fax_2` varchar(11) DEFAULT NULL,
  `site` varchar(250) DEFAULT NULL,
  `orkut` varchar(250) DEFAULT NULL,
  `facebook` varchar(250) DEFAULT NULL,
  `twitter` varchar(250) DEFAULT NULL,
  `skype` char(250) DEFAULT NULL,
  `msn` varchar(250) NOT NULL,
  `numero_de_funcionario` varchar(1) DEFAULT NULL,
  `ativo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  UNIQUE KEY `cnpj` (`cnpj`),
  KEY `fk_operadora_empresa_1` (`id_operadora_celular2`),
  KEY `fk_operadora_empresa_2` (`id_operadora_celular`),
  KEY `fk_relationship_1` (`id_matriz`),
  KEY `fk_relationship_4` (`id_categoria_empresa`),
  KEY `fk_relationship_5` (`id_ramo_empresa`),
  KEY `fk_relationship_52` (`id_endereco`),
  KEY `fk_relationship_64` (`id_qnp`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `id_categoria_empresa`, `id_qnp`, `id_operadora_celular`, `id_operadora_celular2`, `id_ramo_empresa`, `id_matriz`, `id_endereco`, `telefone_1`, `telefone_2`, `email`, `nome_fantasia`, `nome_contato_1`, `tels_contato_1`, `email_contato_1`, `nome_contato_2`, `tels_contato_2`, `email_contato_2`, `id_operadora_celular_contato_1`, `id_operadora_celular_contato_2`, `cel_contato_1`, `cel_contato_2`, `razao_social`, `apelido`, `cnpj`, `inscricao_estadual`, `celular_1`, `celular_2`, `fax_1`, `fax_2`, `site`, `orkut`, `facebook`, `twitter`, `skype`, `msn`, `numero_de_funcionario`, `ativo`) VALUES
(1, 0, NULL, NULL, NULL, 0, 0, NULL, 'dddTel1tele', '0', 'email', 'nome_fantasia', 'nome_contato_1', 'dddTelTemp1', 'email_contato_1', 'nome_contato_2', 'dddTelTemp2', 'email_contato_2', 0, 0, 'dddCelTemp1', 'dddCelTemp2', 'razao_social', 'apelido', 'cnpj', 'inscricao_estadual', 'dddCel1celu', 'dddCel2celu', 'dddFax1fax_', 'dddFax2fax_', 'site', 'orkut', 'facebook', 'twitter', 'skype', 'msn', '-', 'a'),
(2, 0, NULL, NULL, NULL, 0, 0, NULL, 'dddTel1tele', '0', 'email', 'nome_fantasia_2', 'nome_contato_1', 'dddTelTemp1', 'email_contato_1', 'nome_contato_2', 'dddTelTemp2', 'email_contato_2', 0, 0, 'dddCelTemp1', 'dddCelTemp2', 'razao_social', 'apelido', 'cnpj2', 'inscricao_estadual', 'dddCel1celu', 'dddCel2celu', 'dddFax1fax_', 'dddFax2fax_', 'site', 'orkut', 'facebook', 'twitter', 'skype', 'msn', '-', 'a'),
(3, 0, NULL, NULL, NULL, 0, 0, NULL, 'dddTel1tele', '0', 'email', 'nome_fantasia_3', 'nome_contato_1', 'dddTelTemp1', 'email_contato_1', 'nome_contato_2', 'dddTelTemp2', 'email_contato_2', 0, 0, 'dddCelTemp1', 'dddCelTemp2', 'razao_social', 'apelido', 'cnpj3', 'inscricao_estadual', 'dddCel1celu', 'dddCel2celu', 'dddFax1fax_', 'dddFax2fax_', 'site', 'orkut', 'facebook', 'twitter', 'skype', 'msn', '-', 'a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `rua_av` varchar(250) DEFAULT NULL,
  `complemento` varchar(250) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `cidade` varchar(250) DEFAULT NULL,
  `bairro` varchar(250) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `referencia` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_relationship_50` (`id_cliente`),
  KEY `fk_relationship_53` (`id_empresa`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `id_cliente`, `id_empresa`, `cep`, `rua_av`, `complemento`, `numero`, `cidade`, `bairro`, `estado`, `referencia`) VALUES
(1, NULL, 1, 'cep', 'rua_av', 'complemento', 'numero', 'cidade', 'bairro', 'AC', 'referencia'),
(2, NULL, 2, 'cep', 'rua_av', 'complemento', 'numero', 'cidade', 'bairro', 'AC', 'referencia'),
(3, NULL, 3, 'cep', 'rua_av', 'complemento', 'numero', 'cidade', 'bairro', 'AC', 'referencia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `familia`
--

CREATE TABLE IF NOT EXISTS `familia` (
  `id_familia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_familia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=392 ;

--
-- Extraindo dados da tabela `familia`
--

INSERT INTO `familia` (`id_familia`, `titulo`) VALUES
(1, 'AQUECEDOR KOMECO'),
(2, 'AQUECEDOR LORENZETH'),
(3, 'AQUECEDOR BOSCH'),
(4, 'AQUECEDOR SOLAR BELOSOL'),
(7, 'RAC - R'),
(8, 'RAC - A'),
(9, 'RAC - C'),
(10, 'ATENDIMENTO TELEFÃ”NICO'),
(11, 'POLÃTICA DE ENCOMENDAS'),
(12, 'TINTAS CORAL'),
(13, 'PORCELANATOS DIVERSOS'),
(14, 'PISOS DURAFLOOR'),
(15, 'ESTRUTURA DE TI'),
(16, 'PRODUTO DE ENCOMENDA'),
(17, 'Documento Fiscal'),
(18, 'INCEPA ROCA'),
(19, 'GYOTOKU'),
(20, 'LOJA'),
(22, 'FERRAMENTAS PARA LIDER'),
(23, 'OTTO BAUMGART'),
(24, 'BANHEIRAS MULTIMAX'),
(25, 'BANHEIRAS JACUZZI'),
(26, 'MOSAICOS E PASTILHAS'),
(27, 'PASTILHAS DE VIDRO VIDROTIL'),
(28, 'PASTILHAS NGK'),
(29, 'ROTINA DE CREDIÃRIO DE FILIAIS'),
(30, 'PROCEDIMENTOS INTERNOS'),
(31, 'IMPERMEABILIZANTES VEDACIT'),
(32, 'CINCO-UM-MEIO'),
(33, 'FERRAMENTAS DIVERSAS'),
(41, 'AMBIENTE DA EMPRESA'),
(35, 'MARKETING PESSOAL'),
(36, 'A IMPORTÃ‚NCIA DO SORRISO'),
(37, 'PINHONET'),
(38, 'CARTÃƒO FAMA'),
(39, 'TROMBETAS'),
(40, 'CHECKLIST'),
(42, 'PISOS E REVESTIMENTOS INCEPA/ROCA'),
(43, 'PISOS E REVESTIMENTOS GYOTOKU'),
(44, 'PRODUTOS DA EMPRESA'),
(45, 'PISOS E PORCELANATOS GYOTOKU'),
(46, 'AVALIAÃ‡ÃƒO DE DESEMPENHO VENDEDORES'),
(47, 'COLCHÃ•ES DE MOLA HERBAL'),
(48, 'FECHADURAS E DOBRADIÃ‡AS IMAB'),
(49, 'CUBAS E BACIAS DECA'),
(50, 'METAIS SANITÃRIOS'),
(51, 'PISOS, REVESTIMENTOS E PORCELANATOS GYOTOKU'),
(52, 'PISOS, REVESTIMENTOS E PORCELANATOS INCEPA E ROCA'),
(53, 'MOSARTE'),
(54, 'PISO CLEAN'),
(55, 'PISOS E REVESTIMENTOS SOLARIUM'),
(56, 'CUBAS E METAIS DIVERSOS'),
(57, 'LOUÃ‡AS E METAIS SANITÃRIOS'),
(58, 'BLOQUEADOR SOLAR SUNDOWN'),
(59, 'ESTOFADOS RONDOMÃ“VEIS'),
(60, 'CAMAS DE CASAL LOPAS MACEIO'),
(61, 'Ã“CULOS DE NATAÃ‡ÃƒO'),
(62, 'CALÃ‡ADOS RAMARIM'),
(63, 'RELÃ“GIOS DE PULSO'),
(64, 'COMBUSTÃVEIS PARA VEÃCULOS'),
(65, 'PROCESSOS BÃSICOS RM'),
(66, 'REVISTA VENDA MAIS'),
(67, 'DUPLICATAS - BOLETOS'),
(68, 'CONEXÃ•ES AQUATHERM'),
(69, 'ATENDIMENTO AO CLIENTE'),
(70, 'BOTAS RAMARIM'),
(71, 'CALÃ‡ADOS DE COURO'),
(72, 'CARTEIRAS E CINTOS FERRACINI'),
(73, 'CHUTEIRAS'),
(74, 'CALÃ‡ADOS DAKOTA'),
(75, 'PRODUTOS DURAFLOOR'),
(76, 'PISOS, REVESTIMENTOS E PORCELANATOS'),
(77, 'CUBAS E METAIS'),
(78, 'PORCELANATOS PORCELANOSA'),
(79, 'BIANCOGRES'),
(80, 'CHUVEIROS LORENZETTI'),
(81, 'TAPETES E CAPACHOS KAPAZI'),
(82, 'PISOS PIETRA'),
(83, 'CADASTRO'),
(84, 'COLETOR SOLAR KOMECO'),
(86, 'COACHING DE VENDAS'),
(87, 'PRM - PROGRAMA DE RELACIONAMENTO MUNDIAL'),
(88, 'PRODUTOS DIVERSOS'),
(89, 'PORCELANAS PORTO DESIGN'),
(90, 'VIDROS E CERÃ‚MICAS EMME DUE'),
(91, 'FERMAR'),
(92, 'PASTILHAS E FAIXAS HENRY'),
(93, 'PASTILHAS DE VIDRO E PORCELANA'),
(94, 'METAIS PERFLEX'),
(95, 'PISOS SOLARIUM'),
(96, 'ESMALTE SINTÃ‰TICO CORALIT'),
(97, 'VERNIZ MARÃTIMO CORAMAR'),
(98, 'PORTINARI'),
(99, 'TINTAS'),
(100, 'LOUÃ‡AS E METAIS SANITÃRIOS INCEPA/ROCA'),
(101, 'MOSAICOS VIDROTIL'),
(102, 'METAIS DECALUX'),
(103, 'LOUÃ‡AS DIVERSAS'),
(104, 'BLOCOS E PASTILHAS DE VIDRO PORTO DESIGN'),
(105, 'AQUECEDORES'),
(106, 'PURIFICADOR DE ÃGUA LORENZETTI'),
(107, 'ARGAMASSAS ACIII'),
(108, 'ARGAMASSAS QUARTZOLIT FLEXÃVEL'),
(109, 'ARGAMASSAS DRYWAL'),
(110, 'ARGAMASSAS QUARTZOLIT LIBERA RÃPIDO'),
(111, 'ARGAMASSAS QUARTZOLIT MÃRMORES E GRANITOS INTERNOS'),
(112, 'ARGAMASSAS PARA PASTILHA DE VIDRO QUARTZOLIT'),
(113, 'ARGAMASSAS PARA PORCELANATO QUARTZOLIT'),
(114, 'ARGAMASSAS QUARTZOLIT AC-I'),
(115, 'ARGAMASSAS QUARTZOLIT'),
(116, 'ARGAMASSAS QUARTZOLIT REFRATÃRIA'),
(117, 'RESINAS BIANCO VEDACIT'),
(118, 'METAIS BRUMET'),
(119, 'IMPERMEABILIZANTE CAMADA FINA'),
(120, 'IMPERMEABILIZANTE CAMADA FINA QUARTZOLIT'),
(121, 'CORAL - AKZO NOBEL'),
(122, 'REJUNTAMENTO EPÃ“XI PAREDE QUARTZOLIT'),
(123, 'REJUNTAMENTO EPÃ“XI PISO QUARTZOLIT'),
(124, 'TAPETES'),
(126, 'MÃ“VEIS DE ÃREAS EXTERNAS DONA FLOR'),
(127, 'DORMITÃ“RIOS FLORATTA'),
(128, 'DORMITÃ“RIOS TULIPA'),
(129, 'ESTOFADOS HERVAL'),
(130, 'MESAS SAARINEN'),
(131, 'INFORMAÃ‡Ã•ES SOBRE A EMPRESA MUNDIAL INTERIORES'),
(132, 'MÃ“VEIS ARMIL'),
(133, 'MÃ“VEIS HERVAL'),
(134, 'MÃ“VEIS SIER'),
(135, 'NOTAS DE DEMONSTRAÃ‡ÃƒO E RETORNO'),
(136, 'OMBRELLONE GREEN HOUSE'),
(137, 'SOFÃS RETRÃTEIS BELL ARTE'),
(138, 'TAPETES E CARPETES SÃƒO CARLOS'),
(139, 'METAIS ADMO'),
(140, 'ARGAMASSAS E PASTILHAS ATLAS'),
(141, 'CORAL'),
(142, 'CONJUNTO PARA BANHEIRO FERMAR SCALLINE'),
(143, 'IMAB'),
(144, 'IMPERMEABILIZANTES E REVESTIMENTOS QUARTZOLIT'),
(145, 'METAIS DECA'),
(146, 'METAIS MOLDENOX'),
(147, 'ARGAMASSAS PISO SOBRE PISO INTERNO QUARTZOLIT'),
(148, 'REJUNTE FLEXÃVEL QUARTZOLIT'),
(149, 'REJUNTAMENTO RENOVAÃ‡ÃƒO QUARTZOLIT'),
(150, 'VEDACIT COMPOMUD '),
(151, 'IMPERMEABILIZANTES VEDACIT ACQUELLA STONE'),
(152, 'IMPERMEABILIZANTE VEDAJÃ'),
(153, 'IMPERMEABILIZANTE VEDAPREN PRETO'),
(154, 'PISOS CIMENTÃCIOS'),
(155, 'CROMOTERAPIA JACUZZI'),
(156, 'CUBAS E LOUÃ‡AS INCEPA'),
(157, 'CUBAS E TANQUES TRAMONTINA'),
(158, 'PISOS ECOART'),
(159, 'JACUZZI'),
(160, 'PRODUTOS TRAMONTINA'),
(161, 'LOUÃ‡AS E MATERIAIS SANITÃRIOS INCEPA'),
(162, 'MATERIAIS SANITÃRIOS'),
(163, 'PISOS REVELUX'),
(164, 'PISOS VINÃLICOS TARKETT FADEMAC'),
(165, 'INCEPA'),
(166, 'LOUÃ‡AS CELITE'),
(167, 'LOUÃ‡AS INCEPA'),
(168, 'PASTILHAS E PORCELANATOS DIVERSOS'),
(169, 'PISOS E PORCELANATOS DIVERSOS'),
(170, 'PISOS E REVESTIMENTOS'),
(171, 'PISOS, PASTILHAS E REVESTIMENTOS DIVERSOS'),
(172, 'PISOS, REVESTIMENTOS E PORCELANATOS INCEPA'),
(173, 'PORCELANATOS INCEPA/ROCA'),
(174, 'REVESTIMENTOS E PORCELANATOS'),
(175, 'REVESTIMENTOS'),
(176, 'MARKETING PESSOAL FEMININO'),
(177, 'MARKETING PESSOAL MASCULINO'),
(178, 'INFORMATIVO ELETRÃ”NICO'),
(179, 'DECA'),
(180, 'METRAGENS E PORCENTAGENS'),
(181, 'BANHEIRAS'),
(182, 'VÃLVULA HYDRA DUO FLUX'),
(183, 'FECHADURAS IMAB'),
(184, 'IMPERMEABILIZANTE IGOLFLEX'),
(185, 'ARGAMASSAS E IMPERMEABILIZANTES SIKA IMPER MUR'),
(186, 'ACESSÃ“RIOS ELÃ‰TRICOS'),
(187, 'ARRUMAÃ‡ÃƒO DE VITRINE'),
(188, 'ATRATIVOS'),
(189, 'MÃ“VEIS BONATTO'),
(190, 'BRILHO INOX'),
(191, 'CIMENTO ESTRUTURAL'),
(192, 'CIMENTO HOLCIM'),
(193, 'MATERIAIS HIDRAÃšLICOS'),
(194, 'CRIS METAL'),
(195, 'CUBAS'),
(196, 'ENTREGAS E PRAZOS'),
(197, 'ESGOTO'),
(198, 'FACHADA'),
(199, 'FITA ANTIDERRAPANTE'),
(200, 'INFORMAÃ‡Ã•ES ÃšTEIS'),
(201, 'MISTURADORES PARA LAVATÃ“RIO FABRIMAR'),
(202, 'METAIS'),
(203, 'ARGAMASSAS E IMPERMEABILIZANTES OVERCOLL'),
(204, 'PASTAS DE POLIR'),
(205, 'RESINAS HYDRONORTH'),
(206, 'ARGAMASSAS E IMPERMEABILIZANTES SIKAFILL'),
(207, 'BACIAS ACOPLADAS CELITE'),
(208, 'TINTAS PVA'),
(209, 'MATERIAIS ELÃ‰TRICOS DIVERSOS'),
(210, 'ARGAMASSAS E IMPERMEABILIZANTES VEDALAGE'),
(211, 'VERNIZES DIVERSOS'),
(212, 'ARGAMASSAS FERMA RÃPIDO INTERNO'),
(213, 'TUBULAÃ‡Ã•ES DE ÃGUA FRIA'),
(214, 'CAIXA D ÃGUA TIGRE'),
(215, 'CAIXA SIFONADA GIRAFÃCIL'),
(216, 'CUBAS E BACIAS CELITE'),
(217, 'METAIS FABRIMAR'),
(218, 'METAIS CELITE'),
(219, 'COMUNICAÃ‡ÃƒO INTERNA'),
(220, 'CONEXÃ•ES'),
(221, 'CONEXÃ•ES ROSCÃVEIS'),
(222, 'ARGAMASSAS E IMPERMEABILIZANTES CONTRA UMIDADE'),
(223, 'LINHA AQUATHERM TIGRE'),
(224, 'CONTÃBIL E FISCAL'),
(225, 'IMPERMEABILIZANTE IGOLFLEX BRANCO'),
(226, 'ARGAMASSAS E IMPERMEABILIZANTES NEUTROL'),
(227, 'REGISTRO DE ESFERA COMPACTO'),
(228, 'SELADORA EXTRA NOBILE'),
(229, 'ADESIVOS SIKA CHAPISCO PLUS'),
(230, 'TEXTURA CLÃSSICO'),
(231, 'TEXTURA MARMORATTO'),
(232, 'TEXTURA RÃšSTICA'),
(233, 'TEXTURATTO LISO'),
(234, 'TINTAS GLASURIT'),
(235, 'TINTAS PISO SUVINIL'),
(236, 'TORNEIRAS TOPJET REF 1170'),
(237, 'TUBOS DE COBRE ELUMA'),
(238, 'VÃLVULA DE PE COM CRIVO'),
(239, 'IMPERMEABILIZANTES VIAFLEX PRETO'),
(240, 'COBRANÃ‡A'),
(241, 'ELÃ‰TRICA'),
(242, 'ESMALTES'),
(243, 'FUNDO PREPARADOR PARA GESSO E PAREDE'),
(244, 'SELATRINCA SUVINIL'),
(245, 'ARGAMASSAS PARA PISOS E REVESTIMENTOS'),
(246, 'ESMALTES SINTÃ‰TICOS'),
(247, 'MATERIAIS DIVERSOS PARA ESGOTO'),
(248, 'VERNIZES CETOL'),
(249, 'IDENTIDADE VISUAL'),
(250, 'CUBAS CELITE'),
(251, 'PRODUTOS DECA'),
(252, 'REVESTIMENTOS E PORCELANATOS PORTINARI'),
(253, 'TINTAS CORALIT'),
(254, 'MATERIAIS PARA PINTURA'),
(255, 'AQUECEDORES KO'),
(256, 'REVESTIMENTOS PORTINARI'),
(257, 'CONJUNTO PARA BANHEIRO FERMAR'),
(258, 'PORCELANATOS INCEPA ROCA'),
(259, 'TINTAS ANTI BACTÃ‰RIA SUVINIL'),
(260, 'TINTAS NOVACOR AZULEJO'),
(261, 'ARGAMASSAS E IMPERMEABILIZANTES SIKA'),
(262, 'TINTAS ACRÃLICAS E PVA'),
(263, 'RESINAS SYNTECO'),
(264, 'HIDROFUGANTE ACQUELLA'),
(265, 'ARGAMASSAS E REVESTIMENTOS ARMATEC'),
(266, 'BOMBAS ANAUGER'),
(267, 'TINTAS LÃTEX'),
(268, 'ARMÃRIOS PARA BANHEIROS'),
(269, 'CADASTRO DE FORNECEDORES'),
(270, 'CADASTRO DE PRODUTOS'),
(271, 'RESINAS SINTÃ‰TICAS CASCOLAC'),
(272, 'BASE PARA TESTAR CORES'),
(273, 'CONHECIMENTO DE FRETE'),
(274, 'ELETRODUTO ROSCÃVEL'),
(275, 'FILTRO DE ENTRADA TIGRE'),
(276, 'VERNIZ TINGIDOR'),
(277, 'BOLETOS BANCÃRIOS'),
(278, 'TUBOS SOLDÃVEIS'),
(279, 'INTERRUPTORES E TOMADAS DIVERSAS'),
(280, 'SIFÃ•ES DIVERSOS'),
(281, 'MONOCOMANDOS DIVERSOS'),
(282, 'CONEXÃ•ES SOLDÃVEIS'),
(283, 'ARRUMAÃ‡ÃƒO E ORGANIZAÃ‡ÃƒO DE FRENTE DE LOJA'),
(284, 'ACESSÃ“RIOS PARA BANHEIRAS'),
(285, 'METRAGENS PARA REVESTIR'),
(286, 'TINTAS DIVERSAS'),
(287, 'PISOS, REVESTIMENTOS E ARGAMASSAS DIVERSOS'),
(288, 'MATERIAIS E PRODUTOS PARA PINTURA'),
(289, 'TINTAS E VERNIZES DIVERSOS'),
(290, 'GERENTE'),
(291, 'APLICAÃ‡ÃƒO DOS PISOS, REVESTIMENTOS E PORCELANATOS'),
(292, 'RELAÃ‡ÃƒO COM O CLIENTE'),
(293, 'ARRUMAÃ‡ÃƒO E EXPOSIÃ‡ÃƒO DE VITRINE'),
(294, 'LOUÃ‡AS E METAIS DIVERSOS'),
(295, 'CUBAS E BACIAS DIVERSAS'),
(296, 'INFORMAÃ‡Ã•ES SOBRE PORCELANATOS '),
(297, 'VERNIZES KNOTTING'),
(298, 'METAIS DIVERSOS'),
(299, 'VÃLVULA DE RETENÃ‡ÃƒO'),
(300, 'TINTAS SUVINIL'),
(301, 'IMPERMEABILIZANTE VEDALAGE BRANCO'),
(302, 'SILICONE FLEXITE'),
(303, 'TEXTURA ACRÃLICA SELACRIL'),
(304, 'INSETICIDA JIMO CUPIM'),
(305, 'ADESIVOS VIAPÃ“XI'),
(306, 'ARGAMASSAS ACII'),
(307, 'ARGAMASSA MÃRMORES E GRANITOS INTERNOS'),
(308, 'ARGAMASSA MULTIUSO'),
(309, 'ARGAMASSA PISO SOBRE PISO'),
(310, 'BITOLAS DIVERSAS'),
(311, 'BOIAS DIVERSAS'),
(312, 'CONEXÃ•ES DIVERSAS'),
(313, 'REVESTIMENTOS DIVERSOS'),
(314, 'CIMENTCOLA INTERNO ACI'),
(315, 'CIMENTCOLA LIBERA RÃPIDO'),
(316, 'VERNIZES CETOL DECK'),
(317, 'BANHEIRAS AXELL'),
(318, 'FECHAMENTO DIÃRIO'),
(319, 'PISOS PAVIFLEX'),
(320, 'NOTAS FISCAIS ELETRÃ”NICAS'),
(321, 'NOTAS FISCAIS'),
(322, '5-1-0,5'),
(323, 'DESPEDIDA DE ALTO IMPACTO'),
(324, 'FECHAMENTO DE CAIXA'),
(325, 'ROUPAS DE MALHA PET'),
(326, 'Ã“CULOS COBRA D AGUA'),
(327, 'RELÃ“GIOS COBRA D AGUA'),
(328, 'QNP'),
(329, 'PÃ“S VENDA'),
(330, 'ABORDAGEM NO ATENDIMENTO'),
(331, 'ORGANIZAÃ‡ÃƒO DO ESTOQUE'),
(332, 'INDICADORES DE AVALIAÃ‡ÃƒO'),
(333, 'MOCHILAS COBRA D AGUA'),
(334, 'DEFEITOS DIVERSOS'),
(335, 'SONDAGEM NO ATENDIMENTO'),
(336, 'VENDER Ã‰ INCRÃVEL'),
(337, 'ENCONTROS 1 A 1'),
(338, 'PISOS ROCA CERÃ‚MICA'),
(339, 'EVOLUÃ‡ÃƒO DA LIDERANÃ‡A'),
(340, 'REGISTROS DIVERSOS'),
(341, 'PISOS, REVESTIMENTOS E PORCELANATOS BIANCOGRÃŠS'),
(342, 'PASTILHAS E PORCELANATOS GYOTOKU'),
(343, 'PASTILHAS DIVERSAS'),
(344, 'PISOS E REVESTIMENTOS PIETRA'),
(345, 'PISOS E REVESTIMENTOS DIVERSOS'),
(346, 'VERNIZ ZU'),
(347, 'PRESSURIZADOR PL-20 LORENZETTI'),
(348, 'PROCEDIMENTOS BANCÃRIOS'),
(349, 'REMOVEDORES STRIPTIZI GEL'),
(350, 'TINTAS ALUMILACK YPIRANGA'),
(351, 'ADESIVOS ARALDITE'),
(352, 'LISTAS DAS ATIVIDADES'),
(353, 'PREPARANDO A VENDA'),
(354, 'RAC'),
(355, 'TREINAMENTO DE GERENTES'),
(356, 'ADESIVOS CASCOLA'),
(357, 'COLOR TEST'),
(358, 'DUCHA ADVANCED'),
(359, 'DUCHA FASHION'),
(360, 'ESMALTE PREMIUM SUVINIL 1/4'),
(361, 'ESMALTE SINTÃ‰TICO SUVINIL'),
(362, 'ARGAMASSAS FERMA RÃPIDO'),
(363, 'SOLUÃ‡Ã•ES PROTETORAS FERMAPROTEC - QUARTZOLIT'),
(364, 'ESMALTE SINTÃ‰TICO FERROLACK'),
(365, 'FUNDO PARA GALVANIZADO SUVINIL'),
(366, 'VERNIZES ISOLARE'),
(367, 'TINTAS LÃTEX GLASURIT'),
(368, 'RESINAS ACRÃLICA HYDRONORTH '),
(369, 'IMPERMEABILIZANTES SUVIFLEX'),
(370, 'RESINA ACRÃLICA SUVINIL'),
(371, 'VERNIZ FC'),
(372, 'VERNIZ ULTRA PROTEÃ‡ÃƒO'),
(373, 'VERNIZ SPARLACK CETOL'),
(374, 'TINTA EMBELEZA CERÃ‚MICA'),
(375, 'IMPERMEABILIZANTES SIKA IGOLFLEX FACHADA'),
(376, 'TORNEIRAS LORENZETTI CLEAN'),
(378, 'TINTAS SPRAY SUVINIL'),
(379, 'SELADORA SUVINIL'),
(380, 'TINTAS EFEITO PALHA'),
(381, 'CALHAS TIGRE LINHA ACQUAPLUV STYLE'),
(382, 'MASSAS F-12'),
(383, 'TINTAS OSMOCOLOR STAIN PRESERVATIVO'),
(384, 'TINTAS PICHE EXTRA'),
(385, 'VERNIZES RESILACK'),
(386, 'SELADORA SPARLACK PARA MADEIRA'),
(387, 'FITA VIAFLEX'),
(388, 'IMPERMEABILIZANTE VEDALAGE PLUS'),
(389, 'TINTAS SUPER SYNTECO POLIURETANO'),
(390, 'IMPERMEABILIZANTE SIKA IMPER MUR'),
(391, 'PINTURA DE PAREDES');

-- --------------------------------------------------------

--
-- Estrutura da tabela `familia_empresa`
--

CREATE TABLE IF NOT EXISTS `familia_empresa` (
  `id_familia` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_familia`,`id_empresa`),
  KEY `fk_familia_empresa2` (`id_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ferramenta`
--

CREATE TABLE IF NOT EXISTS `ferramenta` (
  `id_ferramenta` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `descricao` text,
  `eh_ferramenta` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ferramenta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `ferramenta`
--

INSERT INTO `ferramenta` (`id_ferramenta`, `nome`, `titulo`, `descricao`, `eh_ferramenta`) VALUES
(1, 'QQP', 'Quadros de QualificaÃ§Ã£o e PolivalÃªncia', '<p>\r\n	<strong>Instrumento criado pela Pinho &amp; Consultores que permite a avalia&ccedil;&atilde;o e acompanhamento da Capacita&ccedil;&atilde;o e Polival&ecirc;ncia Individual e da Equipe.</strong></p>\r\n<p>\r\n	<strong>Orienta e prioriza as A&ccedil;&otilde;es de Treinamentos conforme as necessidades estrat&eacute;gicas da organiza&ccedil;&atilde;o.</strong></p>\r\n<p>\r\n	<strong>Atrav&eacute;s deste, temos uma Vis&atilde;o Clara e Estruturada da atual performance de cada profissional das diferentes Unidades de Neg&oacute;cios e as A&ccedil;&otilde;es Essenciais a serem implementadas para assegurar a competitividade da empresa e de seus times. &nbsp;</strong></p>\r\n<p>\r\n	<strong>A Alta Velocidade proporcionada pelo QQP na&nbsp;</strong><strong>Assertiva&nbsp;</strong><strong>Gest&atilde;o dos Recursos Humanos &eacute; surpreendente e encantadora!</strong></p>\r\n', 1),
(2, 'QNP', 'QuestionÃ¡rios de Nivelamento Profissional', '<p>\r\n	<strong>Instrumento criado pela Pinho &amp; Consultores que permite uma Aprendizagem Individual e da Equipe, pelo menos 10 X mais r&aacute;pida, essencial nesses novos tempos.</strong></p>\r\n<p>\r\n	<strong>Os Question&aacute;rios captam a Vis&atilde;o do Essencial para a Capacita&ccedil;&atilde;o dos Profissionais, tornando a empresa mais competitiva, atrav&eacute;s do adequado desenvolvimento de Times de Alta Performance.</strong></p>\r\n<p>\r\n	<strong>Otimiza o &quot;saber&quot; das organiza&ccedil;&otilde;es, de forma estruturada, &aacute;gil, inteligente, inovadora e de f&aacute;cil acesso aos envolvidos.</strong></p>\r\n', 1),
(3, 'LDA', 'Lista das Atividades', '<p>\r\n	<strong>Instrumento da Pinho &amp; Consultores que apoia na identifica&ccedil;&atilde;o das Atividades Desenvolvidas pelos profissionais no seu dia a dia. Apresenta a vis&atilde;o do&nbsp;</strong><strong>&quot;o que fazemos&quot;</strong><strong>. &Eacute; essencial para a gest&atilde;o do per&iacute;odo de experi&ecirc;ncia dos novos funcion&aacute;rios, reciclagens, bem como, na organiza&ccedil;&atilde;o dos programas de treinamento da empresa.</strong></p>\r\n', 1),
(5, 'Empresa', 'Empresa', 'nao tem', 0),
(6, 'Funcionário', 'Funcionário', 'nao tem', 0),
(7, 'Controle de Acesso', 'Controle de Acesso	', NULL, 0),
(8, 'Ferramenta', 'Ferramenta', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `foco`
--

CREATE TABLE IF NOT EXISTS `foco` (
  `id_foco` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_foco`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=281 ;

--
-- Extraindo dados da tabela `foco`
--

INSERT INTO `foco` (`id_foco`, `titulo`) VALUES
(1, 'PISOS'),
(2, 'REVESTIMENTOS'),
(3, 'PISOS E REVESTIMENTOS'),
(4, 'AQUECEDORES'),
(5, 'FERRAMENTAS'),
(6, 'MÃQUINAS'),
(7, 'COLCHÃ•ES'),
(8, 'BANHEIRAS'),
(9, 'TINTAS'),
(10, 'LOUÃ‡AS'),
(11, 'METAIS SANITÃRIOS'),
(12, 'PASTILHAS'),
(13, 'PASTILHAS DE VIDRO'),
(14, 'ARGAMASSAS'),
(15, 'RECLAMAÃ‡Ã•ES'),
(16, 'ENCOMENDAS'),
(17, 'ESTOQUE'),
(18, 'ENTREGAS'),
(19, 'TI'),
(20, 'CENTRO DE DISTRIBUIÃ‡ÃƒO'),
(21, 'PREMIAÃ‡ÃƒO'),
(22, 'CHUVEIROS'),
(23, 'MÃ“VEIS MODULADOS'),
(24, 'METAIS'),
(25, 'FERRAMENTAS DE TRABALHO'),
(26, 'SISTEMAS'),
(27, 'CALÃ‡ADOS MASCULINOS'),
(28, 'CALÃ‡ADOS FEMININOS'),
(29, 'CALÃ‡ADOS INFANTIS'),
(33, 'RAC'),
(31, 'AQUECEDORES A GÃS'),
(32, 'AQUECEDORES SOLAR'),
(34, 'ATENDIMENTOS'),
(35, 'DOCUMENTOS'),
(36, 'HIGIENE E CONSERVAÃ‡ÃƒO'),
(37, 'CARGAS'),
(39, 'FORNECEDORES'),
(40, 'KOMECO'),
(41, 'MOSAICOS E PASTILHAS'),
(42, 'PASTILHAS DE PORCELANA'),
(43, 'ROTINAS DE CREDIÃRIO DE FILIAIS'),
(44, 'CREDIÃRIO'),
(45, 'MOTORES'),
(46, 'AUTO FALANTES'),
(47, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE ENCOMENDAS'),
(48, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE CONTRATAÃ‡ÃƒO DE MÃƒO DE OBRA'),
(49, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE DESLIGAMENTO DE PESSOAL'),
(50, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE TROCAS E DEVOLUÃ‡Ã•ES'),
(51, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE COBRANÃ‡AS'),
(52, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE FINANCIAMENTOS'),
(53, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS TI'),
(54, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE TELEFONIA'),
(55, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE ENTREGAS'),
(56, 'IMPERMEABILIZANTES'),
(57, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE CAIXA & CREDIÃRIO'),
(58, 'FERRAMENTAS DA P&C'),
(59, 'ALO NO AMBIENTE DA EMPRESA'),
(60, 'PISOS E PORCELANATOS'),
(61, 'COLCHÃ•ES DE MOLA'),
(62, 'FECHADURAS E DOBRADIÃ‡AS'),
(63, 'LOUÃ‡AS E METAIS'),
(64, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS PARA RECLAMAÃ‡Ã•ES DE CLIENTES'),
(65, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE DEPARTAMENTO PESSOAL'),
(66, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE ESTOQUE'),
(67, 'POLÃTICAS, DIRETRIZES & PROCEDIMENTOS DE FATURAMENTO'),
(68, 'PISOS, REVESTIMENTOS E PORCELANATOS'),
(69, 'PRM'),
(70, 'ALO NOS PRODUTOS'),
(71, 'PROTETOR SOLAR'),
(72, 'BLOQUEADOR SOLAR'),
(73, 'UNIDADES DE PRODUÃ‡ÃƒO'),
(74, 'ESTOFADOS'),
(75, 'CAMAS '),
(76, 'Ã“CULOS'),
(77, 'CALÃ‡ADOS'),
(79, 'RELÃ“GIOS'),
(80, 'COMBUSTÃVEIS'),
(81, 'PALM'),
(82, 'RELAÃ‡ÃƒO COM O CLIENTE'),
(83, 'POLÃTICAS, DIRETRIZES E PROCEDIMENTOS DE EXPEDIÃ‡ÃƒO'),
(84, 'CANCELAMENTO DE DOCUMENTOS'),
(85, 'CONEXÃ•ES AQUATHERM'),
(86, 'BOTAS'),
(87, 'CARTEIRAS E CINTOS'),
(88, 'CHUTEIRAS'),
(225, 'DISJUNTORES E QUADRO DE DISJUNTORES'),
(90, 'VITRINE'),
(91, 'DURAFLOOR'),
(92, 'INCEPA ROCA'),
(93, 'CUBAS E METAIS'),
(94, 'PORCELANOSA'),
(95, 'BIANCOGRES'),
(96, 'PORCELANATOS'),
(97, 'TAPETES E CAPACHOS'),
(98, 'PIETRA'),
(99, 'COLETOR SOLAR'),
(100, 'REVISTA VENDA MAIS'),
(101, 'COACHING DE VENDAS'),
(102, 'PISO CLEAN'),
(103, 'PORCELANAS'),
(104, 'VIDROS E CERÃ‚MICAS'),
(105, 'CONJUNTO PARA BANHEIRO'),
(106, 'PASTILHAS E FAIXAS'),
(107, 'SOLARIUM'),
(108, 'ESMALTE SINTÃ‰TICO'),
(109, 'VERNIZ MARÃTIMO'),
(110, 'PORTINARI'),
(111, 'ATENDIMENTO AO CLIENTE'),
(112, 'MOSAICOS'),
(113, 'DECALUX'),
(114, 'BLOCOS E PASTILHAS '),
(115, 'PURIFICADOR DE ÃGUA'),
(116, 'BIANCO '),
(117, 'BRUMET'),
(118, 'CORAL - AKZO NOBEL'),
(119, 'REJUNTAMENTO'),
(120, 'MÃ“VEIS DE ÃREAS EXTERNAS'),
(121, 'DORMITÃ“RIOS '),
(122, 'DORMITÃ“RIOS TULIPA'),
(123, 'FORMAS DE PAGAMENTO'),
(124, 'MESAS'),
(125, 'EMPRESA MUNDIAL INTERIORES'),
(126, 'MÃ“VEIS'),
(127, 'NOTAS '),
(128, 'OMBRELLONE'),
(129, 'SOFÃS'),
(130, 'TAPETES E CARPETES'),
(131, 'ADMO'),
(132, 'ATLAS'),
(133, 'CORAL'),
(134, 'FERMAR SCALLINE'),
(135, 'IMAB'),
(136, 'IMPERMEABILIZANTES E REVESTIMENTOS'),
(137, 'MOLDENOX'),
(138, 'REJUNTE'),
(139, 'VEDACIT'),
(140, 'VEDACIT AQUELLA STONE'),
(141, 'CROMOTERAPIA'),
(142, 'CUBAS E LOUÃ‡AS'),
(143, 'CUBAS E TANQUES'),
(144, 'ECOART'),
(145, 'JACUZZI'),
(146, 'TRAMONTINA'),
(147, 'LOUÃ‡AS E MATERIAIS SANITÃRIOS'),
(148, 'MATERIAIS SANITÃRIOS'),
(149, 'REVELUX'),
(150, 'TARKETT '),
(151, 'INCEPA'),
(152, 'PASTILHAS E PORCELANATOS'),
(153, 'PISOS, PASTILHAS E REVESTIMENTOS'),
(154, 'REVESTIMENTOS E PORCELANATOS'),
(155, 'MARKETING'),
(156, 'INFORMATIVO '),
(157, 'DECA'),
(158, 'METRAGENS E PORCENTAGENS'),
(159, 'VÃLVULA HYDRA DUO FLUX'),
(160, 'FECHADURAS'),
(161, 'IGOLFLEX'),
(162, 'SIKA IMPER MUR'),
(163, 'ACESSÃ“RIOS ELÃ‰TRICOS'),
(164, 'FRENTE DE LOJA'),
(165, 'ABRASIVOS'),
(166, 'CIMENTO'),
(167, 'CIMENTO HOLCIM'),
(168, 'CONEXÃ•ES SOLDÃVEIS'),
(169, 'CRIS METAL'),
(170, 'CUBAS'),
(171, 'MATERIAIS PARA ESGOTO'),
(172, 'FACHADA'),
(173, 'FITA '),
(174, 'INFORMAÃ‡Ã•ES ÃšTEIS'),
(175, 'MISTURADORES '),
(176, 'MONOCOMANDOS'),
(177, 'ARGAMASSAS E IMPERMEABILIZANTES'),
(178, 'PASTAS '),
(179, 'RESINAS '),
(180, 'SIFÃ•ES '),
(181, 'SIKAFILL'),
(224, 'ARGAMASSAS E PASTILHAS'),
(182, 'BACIAS '),
(183, 'TINTAS PVA'),
(184, 'DISJUNTORES E QUADRO DE DISJUNTORES'),
(185, 'INTERRUPTORES E TOMADAS'),
(186, 'TUBOS SOLDÃVEIS'),
(227, 'HIDROFUGANTE'),
(188, 'VERNIZES'),
(189, 'TUBULAÃ‡Ã•ES '),
(190, 'CAIXA D ÃGUA'),
(191, 'CAIXA SIFONADA '),
(192, 'CUBAS E BACIAS'),
(193, 'COMUNICAÃ‡ÃƒO INTERNA'),
(194, 'CONEXÃ•ES'),
(195, 'CONEXÃ•ES ROSCÃVEIS'),
(196, 'CONTRA UMIDADE'),
(197, 'LINHA AQUATHERM'),
(198, 'CONTÃBIL E FISCAL'),
(199, 'IGOLFLEX BRANCO'),
(200, 'NEUTROL'),
(201, 'REGISTROS'),
(202, 'SELADORA'),
(203, 'ADESIVOS PARA CHAPISCO'),
(204, 'TEXTURA CLÃSSICO'),
(205, 'TEXTURA MARMORATTO'),
(206, 'TEXTURA RÃšSTICA'),
(207, 'TEXTURATTO LISO'),
(208, 'TINTA GLASURIT'),
(209, 'TINTA PISO SUVINIL'),
(210, 'TORNEIRAS'),
(211, 'TUBOS '),
(212, 'VÃLVULA DE PE COM CRIVO'),
(213, 'VIAFLEX PRETO'),
(214, 'COBRANÃ‡A'),
(215, 'MATERIAIS ELÃ‰TRICOS'),
(216, 'ESMALTES'),
(217, 'FUNDO PREPARADOR'),
(218, 'SELATRINCA SUVINIL'),
(219, 'SELATRINCA '),
(220, 'VIAFLEX'),
(221, 'VÃLVULA'),
(222, 'TEXTURATTO '),
(223, 'TEXTURA'),
(226, 'TINTAS E VERNIZES'),
(228, 'BOLETOS'),
(229, 'ARGAMASSAS E REVESTIMENTOS'),
(230, 'BOMBA'),
(231, 'ARMÃRIOS'),
(232, 'BIODIGESTOR'),
(233, 'CADASTRO'),
(234, 'COLORTEST'),
(235, 'FRETE'),
(236, 'ELETRODUTO'),
(237, 'FILTRO'),
(238, 'FUNDO PREPARADOR'),
(239, 'PISOS, REVESTIMENTOS E ARGAMASSAS'),
(240, 'ATENDIMENTO TELEFÃ”NICO'),
(241, 'SILICONE'),
(242, 'NOTA FISCAL'),
(243, 'INSETICIDA'),
(244, 'MÃQUINAS E CARTÃ•ES'),
(245, 'ADESIVOS'),
(246, 'BITOLAS'),
(247, 'BOIAS'),
(248, 'CÃLCULO DE MEDIDAS'),
(249, 'CIMENTCOLA'),
(251, 'ABERTURA DE LOJA'),
(252, 'CONCORRÃŠNCIA'),
(253, 'FECHAMENTO DA LOJA'),
(254, 'FECHAMENTO DA VENDA'),
(255, 'ROUPAS'),
(256, 'METAS'),
(258, 'ABORDAGEM'),
(259, 'APRESENTAÃ‡ÃƒO DOS PRODUTOS'),
(260, 'INDICADORES'),
(261, 'MOCHILAS'),
(262, 'PRODUTOS COM DEFEITOS'),
(263, 'INVENTÃRIO'),
(264, 'PROCESSAMENTO DE PRODUTO'),
(265, 'SONDAGEM'),
(266, 'PRESSURIZADOR'),
(267, 'BANCOS'),
(268, 'REMOVEDORES'),
(269, 'CHEQUES'),
(270, 'CONTROLE DE CAIXA'),
(271, 'SOLUÃ‡Ã•ES PROTETORAS'),
(272, 'FUNDO PARA GALVANIZADO'),
(273, 'ORGANIZAÃ‡ÃƒO DO ESTOQUE'),
(274, 'PAGAMENTO DE FORNECEDORES'),
(275, 'CALHAS'),
(276, 'MASSAS'),
(277, 'REIMPRESSÃƒO DE DOCUMENTOS'),
(278, 'REMESSAS'),
(279, 'CONTAS'),
(280, 'PINTURA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `foco_empresa`
--

CREATE TABLE IF NOT EXISTS `foco_empresa` (
  `id_foco` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_foco`,`id_empresa`),
  KEY `fk_foco_empresa2` (`id_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionalidade`
--

CREATE TABLE IF NOT EXISTS `funcionalidade` (
  `id_funcionalidade` int(11) NOT NULL AUTO_INCREMENT,
  `id_ferramenta` int(11) NOT NULL,
  `id_funcionalidade_pai` int(11) DEFAULT '0',
  `titulo` varchar(200) DEFAULT NULL,
  `nome_action` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_funcionalidade`),
  KEY `fk_relationship_14` (`id_ferramenta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='funcionalidades da ferramenta, por exemplo: lda tem "cadastr' AUTO_INCREMENT=135 ;

--
-- Extraindo dados da tabela `funcionalidade`
--

INSERT INTO `funcionalidade` (`id_funcionalidade`, `id_ferramenta`, `id_funcionalidade_pai`, `titulo`, `nome_action`) VALUES
(1, 1, 113, 'Cadastrar', NULL),
(2, 1, 113, 'Gerenciar', NULL),
(3, 2, 0, 'Cadastrar', NULL),
(4, 2, 0, 'Gerenciar', NULL),
(5, 3, 108, 'Cadastrar', NULL),
(6, 3, 108, 'Gerenciar', NULL),
(7, 4, 0, 'Cadastrar', NULL),
(8, 4, 0, 'Gerenciar', NULL),
(9, 5, 105, 'Cadastrar', 'cadastrarempresa'),
(10, 5, 0, 'Gerenciar', NULL),
(11, 6, 0, 'Cadastrar', NULL),
(12, 6, 0, 'Gerenciar', NULL),
(13, 7, 0, 'Cadastrar', NULL),
(14, 7, 0, 'Gerenciar', NULL),
(15, 8, 0, 'Cadastrar', NULL),
(16, 8, 0, 'Gerenciar', NULL),
(17, 9, 0, 'Cadastrar', NULL),
(18, 9, 0, 'Gerenciar', NULL),
(19, 10, 0, 'Cadastrar', NULL),
(20, 10, 0, 'Gerenciar', NULL),
(21, 11, 0, 'Cadastrar', NULL),
(22, 11, 0, 'Gerenciar', NULL),
(23, 12, 0, 'Cadastrar', NULL),
(24, 12, 0, 'Gerenciar', NULL),
(25, 13, 0, 'Cadastrar', NULL),
(26, 13, 0, 'Gerenciar', NULL),
(27, 14, 0, 'Cadastrar', NULL),
(28, 14, 0, 'Gerenciar', NULL),
(29, 15, 0, 'Cadastrar', NULL),
(30, 15, 0, 'Gerenciar', NULL),
(31, 16, 0, 'Cadastrar', NULL),
(32, 16, 0, 'Gerenciar', NULL),
(33, 17, 0, 'Cadastrar', NULL),
(34, 17, 0, 'Gerenciar', NULL),
(35, 18, 0, 'Cadastrar', NULL),
(36, 18, 0, 'Gerenciar', NULL),
(37, 19, 0, 'Cadastrar', NULL),
(38, 19, 0, 'Gerenciar', NULL),
(39, 20, 0, 'Cadastrar', NULL),
(40, 20, 0, 'Gerenciar', NULL),
(41, 21, 0, 'Cadastrar', NULL),
(42, 21, 0, 'Gerenciar', NULL),
(43, 22, 0, 'Cadastrar', NULL),
(44, 22, 0, 'Gerenciar', NULL),
(45, 23, 0, 'Cadastrar', NULL),
(46, 23, 0, 'Gerenciar', NULL),
(47, 24, 0, 'Cadastrar', NULL),
(48, 24, 0, 'Gerenciar', NULL),
(49, 25, 0, 'Cadastrar', NULL),
(50, 25, 0, 'Gerenciar', NULL),
(51, 26, 0, 'Cadastrar', NULL),
(52, 26, 0, 'Gerenciar', NULL),
(53, 27, 0, 'Cadastrar', NULL),
(54, 27, 0, 'Gerenciar', NULL),
(55, 28, 0, 'Cadastrar', NULL),
(56, 28, 0, 'Gerenciar', NULL),
(57, 29, 0, 'Cadastrar', NULL),
(58, 29, 0, 'Gerenciar', NULL),
(59, 30, 0, 'Cadastrar', NULL),
(60, 30, 0, 'Gerenciar', NULL),
(61, 31, 0, 'Cadastrar', NULL),
(62, 31, 0, 'Gerenciar', NULL),
(63, 32, 0, 'Cadastrar', NULL),
(64, 32, 0, 'Gerenciar', NULL),
(65, 33, 0, 'Cadastrar', NULL),
(66, 33, 0, 'Gerenciar', NULL),
(67, 34, 0, 'Cadastrar', NULL),
(68, 34, 0, 'Gerenciar', NULL),
(69, 35, 0, 'Cadastrar', NULL),
(70, 35, 0, 'Gerenciar', NULL),
(71, 36, 0, 'Cadastrar', NULL),
(72, 36, 0, 'Gerenciar', NULL),
(73, 37, 0, 'Cadastrar', NULL),
(74, 37, 0, 'Gerenciar', NULL),
(75, 38, 0, 'Cadastrar', NULL),
(76, 38, 0, 'Gerenciar', NULL),
(77, 39, 0, 'Cadastrar', NULL),
(78, 39, 0, 'Gerenciar', NULL),
(79, 40, 0, 'Cadastrar', NULL),
(80, 40, 0, 'Gerenciar', NULL),
(81, 41, 0, 'Cadastrar', NULL),
(82, 41, 0, 'Gerenciar', NULL),
(83, 42, 0, 'Cadastrar', NULL),
(84, 42, 0, 'Gerenciar', NULL),
(85, 43, 0, 'Cadastrar', NULL),
(86, 43, 0, 'Gerenciar', NULL),
(87, 44, 0, 'Cadastrar', NULL),
(88, 44, 0, 'Gerenciar', NULL),
(89, 45, 0, 'Cadastrar', NULL),
(90, 45, 0, 'Gerenciar', NULL),
(91, 46, 0, 'Cadastrar', NULL),
(92, 46, 0, 'Gerenciar', NULL),
(93, 3, 5, 'Atividade', 'cadastraratividade'),
(94, 3, 5, 'Genérico', 'cadastrargenerico'),
(112, 7, 0, 'Controle de Acesso', NULL),
(98, 3, 5, 'LDA', 'cadastrarlda'),
(99, 3, 6, 'LDA', 'gerenciarlda'),
(100, 3, 6, 'Atividade', 'gerenciaratividade'),
(101, 3, 6, 'Matriz LDA', 'gerenciargenerico'),
(102, 3, 6, 'LDA liberado', 'gerenciarldaliberado'),
(103, 7, 112, 'Cadastrar', 'cadastrarcontroleacesso'),
(104, 7, 112, 'Gerenciar', 'gerenciarcontroleacesso'),
(105, 5, 0, 'Empresa', NULL),
(106, 8, 0, 'Ferramenta', NULL),
(107, 6, 0, 'Funcionário', NULL),
(108, 3, 106, 'LDA', NULL),
(109, 5, 105, 'Gerenciar', 'gerenciarempresa'),
(110, 6, 107, 'Cadastrar', 'cadastrarfuncionario'),
(111, 6, 107, 'Gerenciar', 'gerenciarfuncionario'),
(113, 1, 106, 'QQP', NULL),
(120, 5, -1, NULL, 'editarempresa'),
(121, 7, -1, NULL, 'editarcontroleacesso'),
(122, 7, -1, NULL, 'deletarcontroleacesso'),
(123, 6, -1, NULL, 'editarfuncionario'),
(124, 6, -1, NULL, 'deletarfuncionario'),
(125, 3, -1, NULL, 'editaratividade'),
(126, 3, -1, NULL, 'deletaratividade'),
(127, 3, -1, NULL, 'editargenerico'),
(128, 3, -1, NULL, 'deletargenerico'),
(129, 3, -1, NULL, 'editarlda'),
(130, 3, -1, NULL, 'deletarlda'),
(131, 3, -1, NULL, 'liberarlda'),
(132, 3, -1, NULL, 'deletarldaliberado'),
(133, 5, -1, NULL, 'deletarempresa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE IF NOT EXISTS `funcionario` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `id_endereco` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_operadora_celular` int(11) DEFAULT NULL,
  `id_operadora_celular2` int(11) DEFAULT NULL,
  `id_operadora_celular3` int(11) DEFAULT NULL,
  `id_time` int(11) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `apelido` varchar(200) DEFAULT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_admissao` datetime DEFAULT NULL,
  `data_setor` datetime DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `avisar_pinho_marcia` varchar(1) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `tel_residencial_1` varchar(11) DEFAULT NULL,
  `tel_residencial_2` varchar(11) DEFAULT NULL,
  `celular_1` varchar(11) DEFAULT NULL,
  `celular_2` varchar(11) DEFAULT NULL,
  `celular_3` varchar(11) DEFAULT NULL,
  `email_empresa` varchar(250) DEFAULT NULL,
  `email_pessoal_1` varchar(250) DEFAULT NULL,
  `email_pessoal_2` varchar(250) DEFAULT NULL,
  `msn` varchar(250) DEFAULT NULL,
  `skype` char(250) DEFAULT NULL,
  `orkut` varchar(250) DEFAULT NULL,
  `facebook` varchar(250) DEFAULT NULL,
  `twitter` varchar(250) DEFAULT NULL,
  `servico_correios` varchar(1) DEFAULT NULL,
  `estado_civil` varchar(1) DEFAULT NULL,
  `nome_conjuge` varchar(100) DEFAULT NULL,
  `numero_filhos` int(11) DEFAULT NULL,
  `escolaridade` varchar(1) DEFAULT NULL,
  `situacao` varchar(1) DEFAULT NULL,
  `formacao` varchar(100) DEFAULT NULL,
  `possui_pc` varchar(1) DEFAULT NULL,
  `pratica_informatica` varchar(1) DEFAULT NULL,
  `religiao` varchar(100) DEFAULT NULL,
  `possui_biblia` varchar(1) DEFAULT NULL,
  `quer_biblia` varchar(1) DEFAULT NULL,
  `lazer` varchar(200) DEFAULT NULL,
  `talentos` varchar(200) DEFAULT NULL,
  `dom_artes` varchar(200) DEFAULT NULL,
  `sonho` varchar(200) DEFAULT NULL,
  `brindes_recebidos` varchar(200) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `cpf_2` (`cpf`),
  KEY `fk_operadora_funcionario_1` (`id_operadora_celular2`),
  KEY `fk_operadora_funcionario_2` (`id_operadora_celular3`),
  KEY `fk_operadora_funcionario_3` (`id_operadora_celular`),
  KEY `fk_relationship_30` (`id_usuario`),
  KEY `fk_relationship_51` (`id_endereco`),
  KEY `id_time` (`id_time`),
  KEY `id_time_2` (`id_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `id_endereco`, `id_usuario`, `id_operadora_celular`, `id_operadora_celular2`, `id_operadora_celular3`, `id_time`, `nome`, `apelido`, `cpf`, `data_admissao`, `data_setor`, `data_nascimento`, `avisar_pinho_marcia`, `sexo`, `tel_residencial_1`, `tel_residencial_2`, `celular_1`, `celular_2`, `celular_3`, `email_empresa`, `email_pessoal_1`, `email_pessoal_2`, `msn`, `skype`, `orkut`, `facebook`, `twitter`, `servico_correios`, `estado_civil`, `nome_conjuge`, `numero_filhos`, `escolaridade`, `situacao`, `formacao`, `possui_pc`, `pratica_informatica`, `religiao`, `possui_biblia`, `quer_biblia`, `lazer`, `talentos`, `dom_artes`, `sonho`, `brindes_recebidos`, `status`) VALUES
(1, NULL, 1, NULL, NULL, NULL, 1, 'Marcio DIas', 'Pai', '01403965609', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(2, 2, 3, NULL, NULL, NULL, 2, 'marco', 'marquinho', 'cpf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(3, NULL, 4, NULL, NULL, NULL, 1, 'Usuario Teste', 'user', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario_tipo`
--

CREATE TABLE IF NOT EXISTS `funcionario_tipo` (
  `id_funcionario_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `funcionario_tipo`
--

INSERT INTO `funcionario_tipo` (`id_funcionario_tipo`, `titulo`) VALUES
(1, 'ALTA ADMINISTRAÃ‡ÃƒO'),
(2, 'LIDERANÃ‡A'),
(3, 'PINHONET'),
(4, 'OPERACIONAL/ADMINISTRATIVO'),
(5, 'VENDEDOR'),
(6, 'OUTROS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `generico_lda`
--

CREATE TABLE IF NOT EXISTS `generico_lda` (
  `id_generico_lda` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_generico_lda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_de_acesso`
--

CREATE TABLE IF NOT EXISTS `grupo_de_acesso` (
  `id_grupo_de_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_grupo_de_acesso`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `grupo_de_acesso`
--

INSERT INTO `grupo_de_acesso` (`id_grupo_de_acesso`, `nome`) VALUES
(1, 'administrador'),
(2, 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_empresa_visivel`
--

CREATE TABLE IF NOT EXISTS `grupo_empresa_visivel` (
  `id_grupo` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_grupo`,`id_empresa`),
  KEY `fk_grupo` (`id_grupo`),
  KEY `fk_empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Esta tabela amazenara as empresas visiveis pelo grupo';

--
-- Extraindo dados da tabela `grupo_empresa_visivel`
--

INSERT INTO `grupo_empresa_visivel` (`id_grupo`, `id_empresa`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_funcionalidade`
--

CREATE TABLE IF NOT EXISTS `grupo_funcionalidade` (
  `id_grupo_de_acesso` int(11) NOT NULL,
  `id_funcionalidade` int(11) NOT NULL,
  `editar` int(11) NOT NULL DEFAULT '0' COMMENT 'contem o id da funcionalidade',
  `deletar` int(11) NOT NULL DEFAULT '0' COMMENT 'contem o id da funcionalidade',
  `liberar` int(11) NOT NULL DEFAULT '0' COMMENT 'contem o id da funcionalidade',
  PRIMARY KEY (`id_grupo_de_acesso`,`id_funcionalidade`),
  KEY `fk_grupo_permissao2` (`id_funcionalidade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo_funcionalidade`
--

INSERT INTO `grupo_funcionalidade` (`id_grupo_de_acesso`, `id_funcionalidade`, `editar`, `deletar`, `liberar`) VALUES
(1, 98, 0, 0, 0),
(1, 102, 0, 132, 0),
(1, 9, 0, 0, 0),
(1, 1, 1, 1, 1),
(1, 2, 1, 1, 1),
(1, 103, 0, 0, 0),
(1, 104, 121, 122, 0),
(1, 105, 1, 1, 1),
(1, 106, 1, 1, 1),
(1, 107, 1, 1, 1),
(1, 108, 1, 1, 1),
(1, 109, 120, 133, 0),
(1, 110, 0, 0, 0),
(1, 111, 123, 124, 0),
(1, 112, 1, 1, 1),
(1, 93, 0, 0, 0),
(1, 94, 0, 0, 0),
(1, 99, 129, 130, 131),
(1, 100, 125, 126, 0),
(1, 101, 127, 128, 0),
(1, 5, 1, 1, 1),
(1, 6, 1, 1, 1),
(1, 120, 0, 0, 0),
(1, 121, 0, 0, 0),
(1, 122, 0, 0, 0),
(1, 123, 0, 0, 0),
(1, 124, 0, 0, 0),
(1, 125, 0, 0, 0),
(1, 126, 0, 0, 0),
(1, 127, 0, 0, 0),
(1, 128, 0, 0, 0),
(1, 129, 0, 0, 0),
(1, 130, 0, 0, 0),
(1, 131, 0, 0, 0),
(1, 132, 0, 0, 0),
(1, 133, 0, 0, 0),
(2, 109, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_lda`
--

CREATE TABLE IF NOT EXISTS `item_lda` (
  `id_item_lda` int(11) NOT NULL AUTO_INCREMENT,
  `id_lda` int(11) NOT NULL,
  `id_descricao` int(11) NOT NULL,
  `degrau` varchar(1) DEFAULT NULL COMMENT '1 - 1º  degrau\r\n            2 - 2º\r\n            3 - 3°\r\n            4 - 4°    ',
  `classificacao` varchar(1) DEFAULT NULL COMMENT '1 - essencial\r\n            2 - importante\r\n            3 - complementar',
  PRIMARY KEY (`id_item_lda`),
  KEY `fk_relationship_69` (`id_lda`),
  KEY `fk_relationship_70` (`id_descricao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda`
--

CREATE TABLE IF NOT EXISTS `lda` (
  `id_lda` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_ferramenta` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `jogar_fora` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_lda`),
  KEY `fk_origem_lda` (`id_empresa`),
  KEY `fk_relationship_19` (`id_ferramenta`),
  KEY `fk_relationship_26` (`id_setor`),
  KEY `fk_relationship_28` (`id_cargo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionalidade` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `acao` varchar(50) DEFAULT NULL,
  `obs` varchar(500) DEFAULT NULL,
  `nome_id` varchar(50) DEFAULT NULL COMMENT 'contem o nome do campo id da tabela na qual esta sendo feita a operacao',
  `valor_id` int(11) DEFAULT NULL COMMENT 'contem o valor  id da tabela na qual esta sendo feita a operacao',
  PRIMARY KEY (`id_log`),
  KEY `fk_relationship_56` (`id_usuario`),
  KEY `fk_relationship_57` (`id_funcionalidade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lotacao`
--

CREATE TABLE IF NOT EXISTS `lotacao` (
  `id_lotacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_setor` int(11) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_funcionario_tipo` int(11) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `atual` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_lotacao`),
  KEY `fk_relationship_2` (`id_funcionario`),
  KEY `fk_relationship_54` (`id_empresa`),
  KEY `fk_cargo` (`id_cargo`),
  KEY `fk_setor` (`id_setor`),
  KEY `fk_id_funcionario_tipo` (`id_funcionario_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `lotacao`
--

INSERT INTO `lotacao` (`id_lotacao`, `id_empresa`, `id_cargo`, `id_setor`, `id_funcionario`, `id_funcionario_tipo`, `data_hora`, `atual`) VALUES
(1, 1, 1, 1, 1, 1, '2012-09-26 00:00:00', 0),
(3, 2, 1, 2, 1, 1, '2012-10-08 15:43:30', 1),
(4, 3, 1, 2, 2, 1, '2012-10-08 03:54:11', 0),
(5, 2, 2, 2, 4, 1, '2012-10-10 00:00:00', 0),
(6, 3, 2, 2, 2, 2, '2012-10-10 00:00:00', 1),
(7, 1, NULL, NULL, 3, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `operadora_celular`
--

CREATE TABLE IF NOT EXISTS `operadora_celular` (
  `id_operadora_celular` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_operadora_celular`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp`
--

CREATE TABLE IF NOT EXISTS `qnp` (
  `id_qnp` int(11) NOT NULL AUTO_INCREMENT,
  `id_ferramenta` int(11) NOT NULL,
  `codigo` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id_qnp`),
  KEY `fk_relationship_18` (`id_ferramenta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp_item`
--

CREATE TABLE IF NOT EXISTS `qnp_item` (
  `id_qnp` int(11) NOT NULL,
  `id_qnp_questao` int(11) NOT NULL,
  PRIMARY KEY (`id_qnp`,`id_qnp_questao`),
  KEY `fk_qnp_item2` (`id_qnp_questao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp_liberado`
--

CREATE TABLE IF NOT EXISTS `qnp_liberado` (
  `id_qnp_liberado` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_qnp` int(11) NOT NULL,
  `tentativa` varchar(1) DEFAULT NULL,
  `data_liberacao` datetime DEFAULT NULL,
  `nota_1` float DEFAULT NULL,
  `nota_2` float DEFAULT NULL,
  `nota_3` float DEFAULT NULL,
  `nota_final` float DEFAULT NULL,
  `data_termino` datetime DEFAULT NULL,
  `data_sem_acesso` datetime DEFAULT NULL COMMENT 'qdo o usuario tira um nota menor q 7, ele ficara sem poder refazer o qnp por dois dias, caso ainda possua tentivas',
  PRIMARY KEY (`id_qnp_liberado`),
  KEY `fk_relationship_46` (`id_usuario`),
  KEY `fk_relationship_62` (`id_qnp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp_questao`
--

CREATE TABLE IF NOT EXISTS `qnp_questao` (
  `id_qnp_questao` int(11) NOT NULL AUTO_INCREMENT,
  `id_familia` int(11) DEFAULT NULL,
  `id_foco` int(11) DEFAULT NULL,
  `id_qnp_resposta` int(11) DEFAULT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_qnp_tipo` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `id_qnp` int(11) DEFAULT NULL,
  `pergunta` text,
  `a` text,
  `b` text,
  `c` text,
  `d` text,
  `e` text,
  `certo` text,
  `errado` text,
  `correcao_errado` text,
  `verdadeiro` text,
  `falso` text,
  `correcao_falso` text,
  `tipo_questao` varchar(1) DEFAULT NULL COMMENT '0-ce\r\n            1-vf\r\n            2-ad\r\n            3-ae',
  `correta` varchar(1) DEFAULT NULL COMMENT '0-a\r\n            1-b\r\n            2-c\r\n            3-d\r\n            4-e\r\n            5-certo\r\n            6-errado\r\n            7-v\r\n            8-f',
  PRIMARY KEY (`id_qnp_questao`),
  KEY `fk_qnp_de_origem` (`id_qnp`),
  KEY `fk_relationship_41` (`id_foco`),
  KEY `fk_relationship_42` (`id_familia`),
  KEY `fk_relationship_43` (`id_area`),
  KEY `fk_relationship_45` (`id_qnp_resposta`),
  KEY `fk_relationship_47` (`id_qnp_tipo`),
  KEY `fk_relationship_63` (`id_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp_resposta`
--

CREATE TABLE IF NOT EXISTS `qnp_resposta` (
  `id_qnp_resposta` int(11) NOT NULL AUTO_INCREMENT,
  `id_qnp_liberado` int(11) NOT NULL,
  `alternativa` varchar(2) DEFAULT NULL COMMENT '0-a\r\n            1-b\r\n            2-c\r\n            3-d\r\n            4-e\r\n            5-certo\r\n            6-errado\r\n            7-v\r\n            8-f\r\n            9-nao sei',
  PRIMARY KEY (`id_qnp_resposta`),
  KEY `fk_relationship_44` (`id_qnp_liberado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qnp_tipo`
--

CREATE TABLE IF NOT EXISTS `qnp_tipo` (
  `id_qnp_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_qnp_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `qnp_tipo`
--

INSERT INTO `qnp_tipo` (`id_qnp_tipo`, `titulo`) VALUES
(1, 'INSTALAÃ‡ÃƒO'),
(2, 'MANUTENÃ‡ÃƒO'),
(3, 'LIMPEZA'),
(4, 'TRANSPORTE'),
(5, 'ARMAZENAMENTO'),
(6, 'GARANTIA'),
(7, 'FERRAMENTA PINHO CONSULTORES'),
(8, 'RELAÃ‡ÃƒO COM O CLIENTE'),
(9, 'POLÃTICA DA EMPRESA'),
(10, 'CARACTERÃSTICAS DO PRODUTO'),
(11, 'SUPORTE'),
(12, 'COMERCIALIZAÃ‡ÃƒO'),
(13, 'DIFERENCIAIS DE VENDAS'),
(14, 'APLICAÃ‡ÃƒO'),
(15, 'PRODUÃ‡ÃƒO'),
(16, 'PROCEDIMENTOS INTERNOS MATRIZ'),
(17, 'ARGUMENTAÃ‡ÃƒO DE VENDAS'),
(18, 'BENEFÃCIOS & CARACTERÃSTICAS'),
(19, 'REFORÃ‡O APRENDIZAGEM'),
(20, 'FABRICAÃ‡ÃƒO'),
(21, 'PROCEDIMENTOS INTERNOS'),
(22, 'PREPARAÃ‡ÃƒO'),
(23, 'REFORÃ‡O E APRENDIZAGEM'),
(24, 'VENDAS ADICIONAIS'),
(25, 'FERRAMENTAS DE TRABALHO'),
(26, 'IDENTIDADE VISUAL'),
(27, 'PROCEDIMENTOS BANCÃRIOS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qqp`
--

CREATE TABLE IF NOT EXISTS `qqp` (
  `id_qqp` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `id_lda` int(11) NOT NULL,
  `id_ferramenta` int(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_qqp`),
  KEY `fk_relationship_20` (`id_ferramenta`),
  KEY `fk_relationship_34` (`id_lda`),
  KEY `fk_relationship_58` (`id_empresa`),
  KEY `fk_relationship_59` (`id_setor`),
  KEY `fk_relationship_60` (`id_cargo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qqp_liberado`
--

CREATE TABLE IF NOT EXISTS `qqp_liberado` (
  `id_qqp_liberado` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_usuario2` int(11) NOT NULL,
  `id_qqp` int(11) NOT NULL,
  `tentativa` varchar(1) DEFAULT NULL,
  `data_liberacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_qqp_liberado`),
  KEY `fk_avaliado` (`id_usuario`),
  KEY `fk_avaliador` (`id_usuario2`),
  KEY `fk_relationship_35` (`id_qqp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qqp_resposta`
--

CREATE TABLE IF NOT EXISTS `qqp_resposta` (
  `id_qqp_resposta` int(11) NOT NULL AUTO_INCREMENT,
  `id_qqp_liberado` int(11) NOT NULL,
  `id_descricao` int(11) NOT NULL,
  `conceito` varchar(2) DEFAULT NULL COMMENT '0-i\r\n            1-r\r\n            2-b\r\n            3-e\r\n            4-n',
  PRIMARY KEY (`id_qqp_resposta`),
  KEY `fk_relationship_36` (`id_descricao`),
  KEY `fk_relationship_37` (`id_qqp_liberado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ramo_empresa`
--

CREATE TABLE IF NOT EXISTS `ramo_empresa` (
  `id_ramo_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_ramo_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

CREATE TABLE IF NOT EXISTS `setor` (
  `id_setor` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_setor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`id_setor`, `titulo`) VALUES
(1, 'VENDAS'),
(2, 'APOIO Ã€S VENDAS'),
(3, 'OPERACIONAL ADMINISTRATIVO'),
(4, 'LIDERANÃ‡A'),
(5, 'DIRETORIA'),
(6, 'PRODUÃ‡ÃƒO'),
(7, 'LOGÃSTICA'),
(8, 'SERVIÃ‡OS GERAIS'),
(10, 'ENTREGA'),
(11, 'ARQUITETURA'),
(12, 'CREDIÃRIO'),
(13, 'ESTOQUE'),
(15, 'ALMOXARIFADO'),
(16, 'FATURAMENTO'),
(17, 'PROJETOS'),
(18, 'RECEPÃ‡ÃƒO'),
(19, 'FINANCEIRO'),
(20, 'MARKETING'),
(21, 'CONTABILIDADE'),
(22, 'SUPERVISÃƒO'),
(23, 'CEMA'),
(24, 'GERÃŠNCIA'),
(25, 'SEPARAÃ‡ÃƒO'),
(26, 'EXPEDIÃ‡ÃƒO'),
(27, 'INFORMÃTICA'),
(30, 'COMPRAS'),
(29, 'ADMINISTRAÃ‡ÃƒO'),
(31, 'COBRANÃ‡A'),
(32, 'TRÃFEGO'),
(33, 'CAIXA'),
(34, 'GENÃ‰RICO OPERACIONAL ADM');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subtema`
--

CREATE TABLE IF NOT EXISTS `subtema` (
  `id_subtema` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) NOT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_subtema`),
  KEY `fk_relationship_11` (`id_tema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id_tema` int(11) NOT NULL AUTO_INCREMENT,
  `id_ferramenta` int(11) NOT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_tema`),
  KEY `fk_relationship_12` (`id_ferramenta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `id_funcionario_lider` int(11) NOT NULL,
  `id_time` int(10) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id_time`),
  KEY `fk_funcionario_lider` (`id_funcionario_lider`),
  KEY `fk_empresa` (`id_empresa`),
  KEY `fk_setor` (`id_setor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `time`
--

INSERT INTO `time` (`id_funcionario_lider`, `id_time`, `id_empresa`, `id_setor`, `titulo`, `descricao`) VALUES
(1, 1, 1, 1, 'Time ADM', 'ra'),
(1, 2, 3, 3, 'Time 2', 'uuu'),
(1, 3, 2, 2, 'Time 3', 'asdasdas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(35) NOT NULL,
  `chave_controle` varchar(32) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_relationship_31` (`id_funcionario`),
  KEY `fk_relationship_49` (`id_cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_funcionario`, `id_cliente`, `login`, `senha`, `chave_controle`) VALUES
(1, 1, NULL, 'marcio', '16306cbf07bd766bffa54d739745ed96', ''),
(3, 2, NULL, 'marco', 'f5888d0bb58d611107e11f7cbc41c97a', ''),
(4, 3, NULL, 'usuario', 'f8032d5cae3de20fcec887f395ec9a6a', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_empresa_visivel`
--

CREATE TABLE IF NOT EXISTS `usuario_empresa_visivel` (
  `id_usuario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_empresa`),
  KEY `fk_funcionario` (`id_usuario`),
  KEY `fk_empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Esta tabela amazenara as empresas visiveis pelo usuario';

--
-- Extraindo dados da tabela `usuario_empresa_visivel`
--

INSERT INTO `usuario_empresa_visivel` (`id_usuario`, `id_empresa`) VALUES
(1, 1),
(3, 1),
(3, 3),
(4, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_funcionalidade`
--

CREATE TABLE IF NOT EXISTS `usuario_funcionalidade` (
  `id_usuario` int(11) NOT NULL,
  `id_funcionalidade` int(11) NOT NULL,
  `editar` int(11) DEFAULT NULL COMMENT 'contem o id da funcionalidade',
  `deletar` int(11) DEFAULT NULL COMMENT 'contem o id da funcionalidade',
  `liberar` int(11) DEFAULT NULL COMMENT 'contem o id da funcionalidade',
  PRIMARY KEY (`id_usuario`,`id_funcionalidade`),
  KEY `fk_usuario_permissao2` (`id_funcionalidade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_grupo`
--

CREATE TABLE IF NOT EXISTS `usuario_grupo` (
  `id_usuario` int(11) NOT NULL,
  `id_grupo_de_acesso` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_grupo_de_acesso`),
  KEY `fk_usuario_grupo2` (`id_grupo_de_acesso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`id_usuario`, `id_grupo_de_acesso`) VALUES
(1, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_time_visivel`
--

CREATE TABLE IF NOT EXISTS `usuario_time_visivel` (
  `id_usuario` int(11) NOT NULL,
  `id_time` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_time`),
  KEY `fk_time` (`id_time`),
  KEY `fk_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario_time_visivel`
--

INSERT INTO `usuario_time_visivel` (`id_usuario`, `id_time`) VALUES
(1, 1),
(3, 1),
(3, 3),
(4, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
