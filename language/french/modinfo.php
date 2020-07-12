<?php
/**
 * $Id: modinfo.php 681 2009-08-20 16:07:20Z dugris $
 * Module: WF-Channel - modified by Philou & Christian
 * Version: v1.0.2
 * Release Date: 20 November 2003
 * Author: Catzwolf
 * Licence: GNU
 */

// Module Info


// The name of this module
define("_MI_WFS_CHANNEL","Pages");

// A brief description of this module
define("_MI_WFS_CHANDESC","Module de gestion de pages ind&#233;pendantes");

// Names of admin menu items
define("_MI_WFSCHAN_ADMENU1","Administration");
define("_MI_WFSCHAN_ADMENU2","Nouvelle page");
define("_MI_WFSCHAN_ADMENU3","Aide");

define("_MI_CHAN_USESPAW","Utiliser l&#39;&#233;diteur Spaw (si install&#233;)");
define("_MI_CHAN_USEFCK","Utiliser l&#39;&#233;diteur FCK");
define("_MI_CHAN_MAXFILESIZE","Taille maximum upload size (kb)");
define("_MI_CHAN_IMGWIDTH","Largeur maximum des images en upload (px)");
define("_MI_CHAN_IMGHEIGHT","Hauteur maximum des images en upload (px)");
define("_MI_CHAN_UPLOADDIR","R&#233;pertoire de stockage des images upload&#233;es <br />(Sans slash de fin)");
define("_MI_CHAN_LINKIMAGES","R&#233;pertoire d&#39;upload des images li&#233;es <br />(Sans slash de fin)");
define("_MI_CHAN_HTMLUPLOADDIR","R&#233;pertoire d&#39;upload des fichiers HTML <br /> (Sans slash de fin)");
define("_MI_CHAN_PERPAGE", "Nombre maximum de pages &#224; afficher dans le menu int&#233;gr&#233;");
define("_MI_CHAN_LINK", "Autoriser les visiteurs anonymes &#224; acc&#233;der &#224; la page : &#34;Faire un lien sur notre site ?&#34;");
define("_MI_CHAN_ANONREFER", "Autoriser les visiteurs anonymes &#224; acc&#233;der &#224; la page : &#34;Informer un ami ?&#34;");
define("_MI_LINKTOUS", "Lien sur notre site");
define("_MI_CHAN_DISPLAYMENU", "Afficher un menu int&#233;gr&#233;<br />(liens sur les autres pages)");
define("_MI_CHAN_DISPLAYTITLE", "Afficher le titre des pages sur la page index ?");
define("_MI_CHAN_STOPSHOUTING", "Cesser Shouting dans les titres ?");

define("_MI_PAGES_BNAME1", "Menu");
define("_MI_CHAN_MENUNAVTYP", "Type d&#39;affichage du menu int&#233;gr&#233;");
define("_MI_CHAN_MENUNAVTYPV", "Vertical");
define("_MI_CHAN_MENUNAVTYPH", "Horizontal");
define("_MI_CHAN_IMAGESET", "Prefixe des images");
define("_MI_CHAN_IMAGESETDESC", "certaines pages utilisent des images par d&#233;faut. Le pr&#233;fixe permet d&#39;utiliser tel ou tel jeu d&#39;images");
define("_MI_CHAN_HTMLIMPORTSHOW", "Afficher la section &#34;Import HTML&#34; dans la cr&#233;ation des pages");
define("_MI_CHAN_HTMLCLEAN", "Afficher la section &#34;Nettoyage HTML&#34; dans la cr&#233;ation des pages");
define("_MI_CHAN_WYSIWYG", "[OPTIONS DE FORMAT]Type d&#39;&#233;diteur ");
define("_MI_CHAN_WYSIWYGDSC", "S&#233;lectionner le type d&#39;&#233;diteur que vous d&#233;sirez utiliser. Veuillez noter que tout autre &#233;diteur que XoopsEditor doit &#234;tre install&#233; sur votre site.");

/**
 * @translation     AFUX (Association Francophone des Utilisateurs de Xoops) <http://www.afux.org/>
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8
 *
 * @version         $Id: modinfo.php 681 2009-08-20 16:07:20Z dugris $
**/
?>