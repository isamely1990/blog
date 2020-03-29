-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_nota`
--

CREATE TABLE IF NOT EXISTS `foto_nota_url` (
  `foto_codigo` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `foto_nombre` varchar(255) DEFAULT NULL,
  `noti_codigo` smallint(5) unsigned NOT NULL DEFAULT '0',
  `foto_archivo` varchar(100) DEFAULT NULL,
  `foto_esprincipal` char(2) DEFAULT NULL,
  `foto_orden` smallint(2) unsigned NOT NULL DEFAULT '0',
  `foto_ultimafecha` datetime DEFAULT NULL,
  PRIMARY KEY (`foto_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE IF NOT EXISTS `nota_url` (
  `noti_codigo` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `noti_orden` smallint(5) NOT NULL DEFAULT '0',
  `noti_titulo` varchar(255) DEFAULT NULL,
  `noti_url` varchar(255) NOT NULL,
  `noti_copete` text,
  `noti_texto` text,
  `noti_ultimafecha` datetime DEFAULT NULL,
  PRIMARY KEY (`noti_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

