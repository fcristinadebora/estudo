CREATE DATABASE `listaContatos`;

USE listaContatos;

CREATE TABLE `Usuarios` (
  `usuarioId` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioNome` char(50) NOT NULL,
  `usuarioEmail` char(50) NOT NULL,
  `usuarioSenha` char(40) NOT NULL,
  PRIMARY KEY (`usuarioId`),
  UNIQUE KEY `usuarioEmail` (`usuarioEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;


CREATE TABLE `Contatos` (
  `contatoId` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioId` int(11) NOT NULL,
  `contatoNome` char(50) NOT NULL,
  `contatoEndereco` longtext,
  PRIMARY KEY (`contatoId`),
  KEY `Contatos_ibfk_1` (`usuarioId`),
  CONSTRAINT `Contatos_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `Usuarios` (`usuarioId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;


CREATE TABLE `ContatoTelefones` (
  `telefoneId` int(11) NOT NULL AUTO_INCREMENT,
  `contatoId` int(11) NOT NULL,
  `telefoneNum` char(15) NOT NULL,
  PRIMARY KEY (`telefoneId`),
  KEY `ContatoTelefones_ibfk_1` (`contatoId`),
  CONSTRAINT `ContatoTelefones_ibfk_1` FOREIGN KEY (`contatoId`) REFERENCES `Contatos` (`contatoId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `ContatoEmails` (
  `emailId` int(11) NOT NULL AUTO_INCREMENT,
  `contatoId` int(11) NOT NULL,
  `emailEndereco` char(50) NOT NULL,
  PRIMARY KEY (`emailId`),
  KEY `ContatoEmails_ibfk_1` (`contatoId`),
  CONSTRAINT `ContatoEmails_ibfk_1` FOREIGN KEY (`contatoId`) REFERENCES `Contatos` (`contatoId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


