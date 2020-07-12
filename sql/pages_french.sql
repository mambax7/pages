# phpMyAdmin SQL Dump
# version 2.5.5-pl1
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Mar 18, 2004 at 05:10 AM
# Server version: 3.23.56
# PHP Version: 4.3.4
# 
# Database : `xoops2`
# 

# --------------------------------------------------------

#
# Table structure for table `pages`
#

CREATE TABLE pages (
  CID tinyint(4) NOT NULL auto_increment,
  pagetitle varchar(255) NOT NULL default '0',
  pageheadline varchar(255) NOT NULL default '0',
  page text NOT NULL,
  weight int(11) NOT NULL default '1',
  html int(11) NOT NULL default '0',
  smiley int(11) NOT NULL default '1',
  xcodes int(11) NOT NULL default '1',
  breaks int(10) NOT NULL default '1',
  defaultpage int(10) NOT NULL default '0',
  indeximage varchar(255) default 'blank.png',
  htmlfile varchar(255) default NULL,
  mainpage int(11) NOT NULL default '0',
  submenu int(11) NOT NULL default '0',
  created int(10) unsigned NOT NULL default '0',
  comments tinyint(11) NOT NULL default '0',
  allowcomments tinyint(11) NOT NULL default '0',
  usedoctitle tinyint(1) NOT NULL default '0',
  publishdate int(10) unsigned NOT NULL default '0',
  expiredate int(10) unsigned NOT NULL default '0',
  counter int(11) NOT NULL default '0',
  search text NULL,
  PRIMARY KEY  (CID),
  UNIQUE KEY topicID (CID),
  FULLTEXT KEY answer (page)
) TYPE=MyISAM COMMENT='Pages';

#
# Dumping data for table `pages`
#

INSERT INTO `pages` VALUES (1,'Page de bienvenue','Page de bienvenue','<h4 align=\"center\" style=\"font-family: Comic Sans MS;\"><font size=\"5\"><span>Bienvenue dans le module Pages</span></font></h4>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span><strong><font size=\"4\">Qu\'est-ce que \'Pages\' ?</font><o:p></o:p></strong></span></p>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span style=\"font-size: 9pt; color: black;\">Pages est une solution pour g&eacute;rer des pages ind&eacute;pendantes les unes des autres. Vous pouvez afficher des pages \'A propos\', \'Recommander\', \'Cr&eacute;er un lien\', \'Clauses de confidentialit&eacute;\' ou n\'importe quelle information int&eacute;ressante pour vos visiteurs.&nbsp;<o:p></o:p></span></p>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span><strong><font size=\"4\">Qu\'est-ce que ce module n\'est pas !</font><o:p></o:p></strong></span></p>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span style=\"font-size: 9pt; color: black;\">Pages n\'est pas un module de publication et de gestion d\'articles comme le module de news par exemple.&nbsp; A part cela le module pages devrait &ecirc;tre parfait pour g&eacute;rer du contenu.<o:p></o:p></span></p>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span style=\"font-size: 9pt; color: black;\">Bonne d&eacute;couverte !<o:p></o:p></span></p>\r\n<p align=\"left\" style=\"font-family: Comic Sans MS;\"><span style=\"font-size: 9pt; color: black;\"><o:p></o:p></span></p>\r\n<p align=\"left\"><span style=\"font-size: 9pt; color: black; font-family: Verdana;\"><span style=\"font-family: Comic Sans MS; font-style: italic;\">Les auteurs</span><o:p></o:p></span></p>',1,0,0,0,0,1,'bienvenue.png','',0,0,1078399017,0,0,0,1079305800,0,64,'Page de bienvenue  Sans MS;\"> Bienvenue dans le module Pages  Sans MS;\"> Qu est-ce que  Pages  ?  Sans MS;\"> color: black;\">Pages est une solution pour gérer des pages indépendantes les unes des autres. Vous pouvez afficher des pages  A propos ,  Recommander ,  Créer un lien ,  Clauses de confidentialité  ou n importe quelle information intéressante pour vos visiteurs.   Sans MS;\"> Qu est-ce que ce module n est pas !  Sans MS;\"> color: black;\">Pages n est pas un module de publication et de gestion d articles comme le module de news par exemple.  A part cela le module pages devrait être parfait pour gérer du contenu.  Sans MS;\"> color: black;\">Bonne découverte !  Sans MS;\"> color: black;\">  color: black; font-family: Verdana;\"> Sans MS; font-style: italic;\">Les auteurs');

# --------------------------------------------------------

#
# Table structure for table `pages_linktous`
#

CREATE TABLE pages_linktous (
  submenuitem int(10) NOT NULL default '10',
  textlink varchar(255) NOT NULL default '',
  linkpagelogo varchar(255) NOT NULL default '',
  button varchar(255) NOT NULL default '',
  microbutton varchar(255) NOT NULL default '',
  logo varchar(255) NOT NULL default '',
  banner varchar(255) NOT NULL default '',
  mainpage int(10) NOT NULL default '1',
  newsfeed int(10) NOT NULL default '0',
  texthtml varchar(255) NOT NULL default '',
  titlelink varchar(255) NOT NULL default '',
  newsfeedjs mediumint(10) NOT NULL default '0',
  newstitle varchar(255) NOT NULL default '',
  linkintro text NOT NULL,
  PRIMARY KEY  (submenuitem)
) TYPE=MyISAM;

#
# Dumping data for table `pages_linktous`
#

INSERT INTO `pages_linktous` VALUES (1,'Change Moi','french_linktous.png','poweredby.gif','microbutton.gif','logo.gif','xoops_banner_2.gif',1,1,'','Créer un lien',1,'','Nous vous remercions de créer un lien vers notre site. Sentez-vous libre des créer des liens depuis votre site vers n\'importe quel endroit de notre site.\r\n<br /><br />Lorsque c\'est possible, nous vous demandons d\'inclure notre logo avec le lien sur votre site Web. Vous pouvez pour cela utiliser les logos ci-après.  Merci de faire pointer le lien du logo vers l\'accueil de notre site, ou une autre page plus appropiée si vous créez un lien vers un article ou une ressource spécifique\r\n<br /><br />Pour avoir une copie du fichier logo, clic-droit sur le logo de votre choix et sélectionnez \'Enregistrer limage sous\' depuis le menu contextuel pour copier l\'image sur votre disque dur. Ensuite placez le logo sur la page de votre site web.');

# --------------------------------------------------------

#
# Table structure for table `pages_refer`
#

CREATE TABLE pages_refer (
  titlerefer varchar(255) NOT NULL default '',
  chanrefheadline text NOT NULL,
  submenuitem int(10) NOT NULL default '10',
  mainpage int(10) NOT NULL default '1',
  referpagelogo varchar(255) NOT NULL default '',
  emailaddress int(10) NOT NULL default '1',
  usersblurb int(10) NOT NULL default '0',
  defblurb varchar(255) NOT NULL default '',
  smiley tinyint(11) NOT NULL default '0',
  xcodes tinyint(11) NOT NULL default '0',
  breaks tinyint(4) NOT NULL default '0',
  html tinyint(11) NOT NULL default '1',
  privacy int(1) NOT NULL default '1',
  emailcheck int(1) NOT NULL default '1',
  privacy_statement text NOT NULL,
  counter int(11) NOT NULL default '0',
  PRIMARY KEY  (submenuitem)
) TYPE=MyISAM;

#
# Dumping data for table `pages_refer`
#

INSERT INTO `pages_refer` VALUES ('Recommander','Faites nous connaitre &agrave; l\'un de vos amis.',1,1,'french_referfriend.png',1,1,'Je vous recommande d\'aller visiter le fantastique site web que j\'ai trouvé.',0,0,1,1,1,1,'Notre politique sur le partage de l\'information <br/>\r\nNotre politique est simple : en toute circonstance, jamais nous ne vendons ou louons de renseignements personnels &agrave; votre sujet &agrave; des tiers quelles que soient les circonstances. Cela vaut bien entendu &eacute;galement pour la personne qui recevra ce mail, elle ne recevra que ce seul mail unique.<br/>\r\n<br/>',0);
