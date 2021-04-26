-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour musicquizz
CREATE DATABASE IF NOT EXISTS `musicquizz` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `musicquizz`;

-- Listage de la structure de la table musicquizz. musiques
CREATE TABLE IF NOT EXISTS `musiques` (
  `IdMusique` int(11) NOT NULL AUTO_INCREMENT,
  `TitreMusique` char(100) COLLATE utf8_bin DEFAULT NULL,
  `Description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `Musique` char(255) COLLATE utf8_bin NOT NULL,
  `ImagePochette` char(255) COLLATE utf8_bin NOT NULL,
  `IdType` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdMusique`),
  KEY `FK_TYPE_ID` (`IdType`),
  CONSTRAINT `FK_TYPE_ID` FOREIGN KEY (`IdType`) REFERENCES `typemusiques` (`IdType`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table contenant les musiques (image ou mp3)';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. musiques_quizz
CREATE TABLE IF NOT EXISTS `musiques_quizz` (
  `IdMusique` int(11) NOT NULL,
  `IdQuizz` int(11) NOT NULL,
  PRIMARY KEY (`IdMusique`,`IdQuizz`),
  KEY `FK_quizz_id` (`IdQuizz`),
  CONSTRAINT `FK_musique_id` FOREIGN KEY (`IdMusique`) REFERENCES `musiques` (`IdMusique`) ON UPDATE CASCADE,
  CONSTRAINT `FK_quizz_id` FOREIGN KEY (`IdQuizz`) REFERENCES `quizz` (`IdQuizz`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table de liaison pour la musique et le quizz';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. parametres
CREATE TABLE IF NOT EXISTS `parametres` (
  `IdParametre` int(11) NOT NULL AUTO_INCREMENT,
  `NbQuestions` int(11) NOT NULL DEFAULT '0',
  `Temps` int(11) NOT NULL DEFAULT '0',
  `TypePartie` enum('chant','image') COLLATE utf8_bin NOT NULL,
  `IdQuizz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdParametre`),
  UNIQUE KEY `IdQuizz` (`IdQuizz`),
  CONSTRAINT `FK_IdQuizz_Quizz` FOREIGN KEY (`IdQuizz`) REFERENCES `quizz` (`IdQuizz`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='mes paramètres de partie';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. quizz
CREATE TABLE IF NOT EXISTS `quizz` (
  `IdQuizz` int(11) NOT NULL AUTO_INCREMENT,
  `DateQuizz` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdQuizz`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table qui répertorie les quiz qui ce sont déroulés';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. typemusiques
CREATE TABLE IF NOT EXISTS `typemusiques` (
  `IdType` int(11) NOT NULL AUTO_INCREMENT,
  `Type` char(75) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`IdType`),
  UNIQUE KEY `Type` (`Type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='table contenant les différents genre de musiques';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. users
CREATE TABLE IF NOT EXISTS `users` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` char(50) COLLATE utf8_bin DEFAULT NULL,
  `Pseudo` char(50) COLLATE utf8_bin NOT NULL,
  `Email` char(255) COLLATE utf8_bin NOT NULL,
  `Mdp` char(255) COLLATE utf8_bin NOT NULL,
  `Avatar` char(255) COLLATE utf8_bin DEFAULT './user/img/default.jpg',
  `Statut` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdUser`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='table de mes utilisateurs';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table musicquizz. user_parametres
CREATE TABLE IF NOT EXISTS `user_parametres` (
  `IdParametre` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  PRIMARY KEY (`IdParametre`,`IdUser`),
  KEY `FK_USER_ID` (`IdUser`),
  KEY `IdParametre` (`IdParametre`),
  CONSTRAINT `FK_PARAMETRES_ID` FOREIGN KEY (`IdParametre`) REFERENCES `parametres` (`IdParametre`) ON UPDATE CASCADE,
  CONSTRAINT `FK_USER_ID` FOREIGN KEY (`IdUser`) REFERENCES `users` (`IdUser`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='ma table de liaison parametres - users';

-- Les données exportées n'étaient pas sélectionnées.

INSERT INTO `users` (`IdUser`, `Nom`, `Pseudo`, `Email`, `Mdp`, `Avatar`, `Statut`) VALUES (18, 'Tn3', 'Jad', 'Admin@admin.com', '$2y$10$1ePeuWcUqV158WhT9YPdKeWLKiZ4OAyldcBCjl9/y/vdOj5X14Xdm', './user/img/60825e137ed96.jpg', 1);


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
