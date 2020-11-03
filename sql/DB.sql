
CREATE TABLE `user`
(
  id int
(11) NOT NULL AUTO_INCREMENT,
  login varchar
(100) NOT NULL,
  mdp varchar
(255) NOT NULL,
  email varchar
(255), 
  remember varchar
(255),
  avatar varchar
(255),
  
  PRIMARY KEY
(id),
  UNIQUE KEY login
(login)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO user
VALUES(1, 'gilles', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'gilles@toto.fr', '', '');