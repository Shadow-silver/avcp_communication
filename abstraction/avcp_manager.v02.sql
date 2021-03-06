DROP TABLE IF EXISTS `avcpman_users`;
DROP TABLE IF EXISTS `avcpman_raggruppamento`;
DROP TABLE IF EXISTS `avcpman_part_ditta`;
DROP TABLE IF EXISTS `avcpman_ditta`;
DROP TABLE IF EXISTS `avcpman_partecipanti`;
DROP TABLE IF EXISTS `avcpman_gara`;
DROP TABLE IF EXISTS `avcpman_pubblicazione`;
DROP TABLE IF EXISTS `avcpman_indice`;
DROP TABLE IF EXISTS `avcpman_files`;
DROP TABLE IF EXISTS `avcpman_settings`;


CREATE TABLE IF NOT EXISTS `avcpman_files` (
	fid INT AUTO_INCREMENT PRIMARY KEY,
	content MEDIUMBLOB,
	ctype CHAR(1),
	numero NUMERIC,
    name VARCHAR(1024),
	anno INT(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene i files prodotti';

CREATE TABLE IF NOT EXISTS `avcpman_settings` (
	sid INT AUTO_INCREMENT PRIMARY KEY,
	skey VARCHAR(50),
	svalue VARCHAR(1000)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le impostazioni del programma';




CREATE TABLE IF NOT EXISTS `avcpman_indice` (
	anno INT(4) NOT NULL PRIMARY KEY,
	url VARCHAR(255),
	generare CHAR(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene gli indici delle pubblicazioni';


CREATE TABLE IF NOT EXISTS `avcpman_pubblicazione` (
	numero NUMERIC NOT NULL,
	anno INT(4) NOT NULL,
	titolo VARCHAR(1000),
	abstract VARCHAR(1000),
	data_pubblicazione DATE,
	data_aggiornamento DATE,
	modified BIT(1),
	url VARCHAR(1000),
	CONSTRAINT PRIMARY KEY (numero, anno),
	CONSTRAINT fk_anno FOREIGN KEY  (anno) REFERENCES avcpman_indice (anno)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sulle pubblicazioni effettuate';


CREATE TABLE IF NOT EXISTS `avcpman_gara` (
	gid INT AUTO_INCREMENT PRIMARY KEY,
	cig VARCHAR(10),
    streamid INT,
	oggetto VARCHAR(250),
	scelta_contraente NUMERIC,
	importo NUMERIC(15,2),
	importo_liquidato NUMERIC(15,2),
	dummy CHAR(1),
	data_inizio DATE,
	data_fine DATE,
	f_user_id VARCHAR(100),
	f_pub_numero NUMERIC,
	f_pub_anno  INT(4),	
	CONSTRAINT fk_pubblicazione FOREIGN KEY  (f_pub_anno,f_pub_numero) REFERENCES avcpman_pubblicazione (anno,numero) ON DELETE NO ACTION	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sui lotti di gara';


CREATE TABLE IF NOT EXISTS `avcpman_partecipanti` (
	pid INT AUTO_INCREMENT PRIMARY KEY,
	gid INT,
	tipo CHAR(1),
	aggiudicatario CHAR(1),	
	CONSTRAINT FOREIGN KEY fk_gara (gid) REFERENCES avcpman_gara(gid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sui partecipanti ai lotti';


CREATE TABLE IF NOT EXISTS `avcpman_ditta` (
	did INT AUTO_INCREMENT PRIMARY KEY,
	ragione_sociale VARCHAR(250) NOT NULL,
	estera CHAR(1),
	dummy CHAR(1),
	identificativo_fiscale VARCHAR(250) NOT NULL,
    CONSTRAINT uc_id UNIQUE (identificativo_fiscale)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sulle ditte';


CREATE TABLE IF NOT EXISTS `avcpman_part_ditta` (
	pid INT,
	did INT,
	CONSTRAINT PRIMARY KEY(pid,did),
	CONSTRAINT fk_partecipante FOREIGN KEY (pid) REFERENCES avcpman_partecipanti (pid),
	CONSTRAINT fk_ditta FOREIGN KEY (did) REFERENCES avcpman_ditta (did)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sulla partecipazione di singole ditte a lotti';


CREATE TABLE IF NOT EXISTS `avcpman_raggruppamento` (
	pid INT,
	did INT,
	ruolo INT,
	CONSTRAINT PRIMARY KEY(pid,did),
	CONSTRAINT fk_rag_part FOREIGN KEY (pid) REFERENCES avcpman_partecipanti (pid),
	CONSTRAINT fk_rag_ditta FOREIGN KEY (did) REFERENCES avcpman_ditta (did)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sui raggruppamenti di ditte';
b
CREATE TABLE `avcpman_users` (
  id varchar(255) NOT NULL,
  name varchar(255) DEFAULT NULL,
  access_password varchar(255) DEFAULT NULL,
  user_roles VARCHAR(255) DEFAULT NULL,
    filename VARCHAR(1024) 
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene le informazioni sugli utenti';
INSERT INTO `avcpman_users` VALUES ('administrator','Utente amministratore','$2y$10$k8MM746TrhQCyZEUw7fTA.u0YsYx8WZJMkF5HGGW.R3TK0l582Yx6','administrator');
INSERT INTO `avcpman_ditta` (`did`, `ragione_sociale`, `estera`, `dummy`, `identificativo_fiscale`) VALUES(1, 'Comune di Terracina', 'N', NULL, '00246180590');
INSERT INTO `avcpman_ditta` (`did`, `ragione_sociale`, `estera`, `dummy`, `identificativo_fiscale`) VALUES(2, 'Ditta Fantasma', 'Y', 'Y', '12345678912');
INSERT INTO `avcpman_settings` (`skey`, `svalue`) VALUES('ente', '');
INSERT INTO `avcpman_settings` (`skey`, `svalue`) VALUES('licenza', '');
INSERT INTO `avcpman_settings` (`skey`, `svalue`) VALUES('cf_ente', '');
INSERT INTO `avcpman_settings` (`skey`, `svalue`) VALUES('prefisso_url', '');