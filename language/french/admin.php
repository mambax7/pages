&#34;<?php
/**
 * $Id: admin.php 681 2009-08-20 16:07:20Z dugris $
 * Module: WF-Channel
 * Version: v1.0.2
 * Release Date: 20 November 2003
 * Author: Catzwolf
 * Licence: GNU
 */

/**
 * Uni Lang defines
 */

define("_AM_SUBMIT", "Valider");
define("_AM_CREATE", "Cr&#233;er");
define("_AM_YES", "Oui");
define("_AM_NO", "Non");
define("_AM_CANCEL", "Annuler");
define("_AM_DELETE", "Supprimer");
define("_AM_MODIFY", "Modifier");

define("_AM_UPDATED", "Base de donn&#233;es mise &#224; jour");
define("_AM_NOTUPDATED", "Erreur dans la mise &#224; jour de la base de donn&#233;es !");
define("_AM_CANNOTDELETELASTONE", "Vous ne pouvez supprimer cet item, ce module a besoin d&#39;au moins une page pour travailler correctement");
define("_AM_NODEFAULTPAGESET", "ATTENTION : Pas de page par d&#233;faut, merci d&#39;en s&#233;lectionner une");
define("_AM_DEFAULTPAGESET", "Titre de la page index");
define("_AM_TOTALNUMCHANL", "Nombre total de pages");

/**
 * Lang defines for topics.php
 */
define("_AM_CHANADMIN", "Administration du module Pages");
define("_AM_ADDCHAN", "Ajouter une page");
define("_AM_CHANQ", "Titre du sous-menu :<br /><br /><span style='font-weight: normal;'>Nom du lien qui sera affich&#233; dans le menu principal pour cette page.</span>");
define("_AM_CHANA", "Contenu :");
define("_AM_CHANW", "Poids de la page :");
define("_AM_MODIFYCHAN", "Modifier page");
define("_AM_NOTOPICTOEDIT", "Cette page n&#39;existe pas dans la base de donn&#233;es !");
define("_AM_MODIFYTHISCHAN", "Modifier cette page");
define("_AM_DELCHAN", "Supprimer page");
define("_AM_DELTHISCHAN", "Supprimer cette page");
define("_AM_NOCHANTOEDIT", "Aucune page &#224; modifier dans la base de donn&#233;es");
define("_AM_CHANISDELETED", "Page \"%s\" a &#233;t&#233; supprim&#233;e");
define("_AM_CHANCREATED", "Page cr&#233;&#233;e avec succ&#232;s");
define("_AM_CHANNOTCREATED", "ERREUR : La page n&#39;a pu &#234;tre cr&#233;&#233;e ou sauvegard&#233;e");
define("_AM_CHANMODIFY", "Page modifi&#233;e et sauvegard&#233;e");
define("_AM_CHANNOTMODIFY", "ERREUR : La page n&#39;a pu &#234;tre cr&#233;&#233;e ou sauvegard&#233;e");
define("_AM_CHANIMAGEEXIST", "ERREUR : le fichier existe d&#233;j&#224; sur le serveur, veuillez corriger !");
define("_AM_CHANNOIMAGEEXIST", "Pas d&#39;image s&#233;lectionn&#233;e");
define("_AM_SUBALLOW", "Autoriser");
define("_AM_SUBDELETE", "Supprimer");
define("_AM_SUBRETURN", "Retour &#224; l&#39;admin");
define("_AM_AUTHOR", "Auteur");
define("_AM_PUBLISHED", "Publi&#233;");
define("_AM_SUBPREVIEW", "Visualisation Administrateur");
define("_AM_SUBADMINPREV", "Ceci est la pr&#233;visualisation admin du sujet.");
define("_AM_DBUPDATED", "Base de donn&#233;es mise &#224; jour");
define("_AM_TITLE", "Titre :");
define("_AM_CHAIMAGE", "Image ou logo de la page :");
define("_AM_CHANHTML", "S&#233;lection d&#39;un document HTML :<br /><br /><span style='font-weight: normal;'>Ce document sera utilis&#233; comme contenu de la page.</span>");
define("_AM_DOHTMLDB", "Import du document HTML dans la base de donn&#233;es ? <br /><br /><span style='font-weight: normal;'>Cette option stockera le document HTML<br />dans la base de donn&#233;es pour des acc&#232;s plus rapides.</span>");
define("_AM_DOCLICKTOIMPORT", "_AM_DOCLICKTOIMPORT ");
define("_AM_ACTION", "Action");
define("_AM_OPTIONS", "Options :");
define("_AM_ADMINPAGE", "Admin page principale");
define("_AM_ADMINSPPAGE", "Admin pages sp&#233;ciales");
define("_AM_PAGESLIST", "Liste des pages");
define("_AM_DOHTML", " D&#233;sactiver les balises HTML");
define("_AM_DOSMILEY", " D&#233;sactiver les icones Smiley");
define("_AM_DOXCODE", " D&#233;sactiver les codes XOOPS");
define("_AM_BREAKS", " Utiliser la conversion Xoops Linebreak ? <br />(Meilleure performance si d&#233;coch&#233;e quand on utilise des balises HTML)");
define("_AM_DEFAULT", " D&#233;finir comme page index du module ?");
define("_AM_ISSUBMENU", "Lien sous-menu ");
define("_AM_ALLOWCOMMENTSCHANHTML", "Autoriser les commentaires dans cette page ?");
define("_AM_TEXTLINKHTML", "Code html du lien texte");
define("_AM_BUTTONHTML", "Code html du bouton de lien");
define("_AM_LOGOHTML", "code html du lien Logo");
define("_AM_BANNERHTML", "Code html du lien banni&#232;re");
define("_AM_ADDNEWSFEEDJS", "Ajout de l&#39;option fil d&#39;information javascript &#224; la page de liens ?");
define("_AM_CHANHDL", "Titre de la page :<br /><br /><span style='font-weight: normal;'>Nom du lien qui sera affich&#233; sur la page index.</span>");
define("_AM_ID", "ID");
define("_AM_PAGETITLE", "Titre");
define("_AM_WEIGHT", "Poids");
define("_AM_DEFAULTPAGE", "Page Index");
define("_AM_GENERALSET", "Pr&#233;f&#233;rences");
define("_AM_MAINADMIN", "Page Index");
define("_AM_CREATENEWPAGE", "Nouvelle page");
define("_AM_GROUPPERMISSIONS", "Autorisations");
define("_AM_ISMAINPAGELINK", "Lien page Index");
define("_AM_PUBLISHEDDATE", "Publi&#233;");
define("_AM_EXPIREDDATE", "Expiration");
define("_AM_READ", "Lectures");
define("_AM_INEEDHELP", "Aide");

define("_AM_UPLOAD", "Upload");
define("_AM_REORDER", "R&#233;ordonner les pages");
define("_AM_UPLOADPATH", "Chemin d&#39;upload :");
define("_AM_REORDERADMIN", "Changer l&#39;ordre des pages");
define("_AM_REORDERINTRO", "Pour modifier l&#39;ordre dans lequel les pages apparaissent, changer leur poids et cliquer sur valider");
define("_AM_UPLOADCHANLOGO", "Logo pour cette page");
define("_AM_UPLOADCHANHTML", "Fichier HTML statique");
define("_AM_EDITHTMLFILEEDIT", "Editer le fichier HTML dans une boite de texte");
define("_AM_CONNECTHTML", " Connecter la page?");
define("_AM_CHAN_UPLOADDIR","R&#233;pertoire d&#39;upload des images");
define("_AM_CHAN_LINKIMAGES","R&#233;pertoire d&#39;upload des images li&#233;es");
define("_AM_CHAN_HTMLUPLOADDIR","R&#233;pertoire d&#39;upload des fichiers HTML");

define("_AM_PUBLISHDATE","Date de publication :");
define("_AM_EXPIREDATE","Date d&#39;expiration :");
define("_AM_CLEARPUBLISHDATE","<br /><br />Retirer la date de publication :");
define("_AM_CLEAREXPIREDATE","<br /><br />Retirer la date d&#39;expiration :");
define("_AM_PUBLISHDATESET"," d&#233;finir la date de publication : ");
define("_AM_SETDATETIMEPUBLISH"," d&#233;finir date et heure de publication");
define("_AM_SETDATETIMEEXPIRE"," d&#233;finir date et heure d&#39;expiration");
define("_AM_SETPUBLISHDATE","<strong>Date de publication : </strong>");
define("_AM_SETEXPIREDATE","<strong>Date d&#39;expiration : </strong>");
define("_AM_EXPIREWARNING","<br />ATTENTION : la date d&#39;expiration est ant&#233;rieure &#224; la date de publication ! ");

define("_AM_DOCTITLE","Utiliser le titre du document");
define("_AM_CLEANHTML","Nettoyer le document HTML lors de l&#39;import ?<br /><br /><span style='font-weight: normal;'>ATTENTION : Ceci peut affecter le document.</span>");
define("_AM_STRIPHTML","Supprimer les balises HTML lors de l&#39;import ?<br /><br /><span style='font-weight: normal;'>ATTENTION : Cette option retire TOUTES  les balises HTML du document.</span>");
define("_AM_CLEANHTML2","Nettoyer le contenu de la page lors de la sauvegarde ?<br /><br /><span style='font-weight: normal;'>Suppression des balises MS Word non d&#233;sir&#233;es. <br />Cela pourra affecter la pr&#233;sentation du document.</span>");
define("_AM_STRIPHTML2","Suppression des balises HTML lors de la sauvegarde  ?<br /><br /><span style='font-weight: normal;'>ATTENTION : Cette option supprimera TOUTES les balises HTML du document.</span>");

define("_AM_CLINKTOUS", "Page de liens");
define("_AM_CMODIFYLINK", "Param&#233;trage de la page de liens :");
define("_AM_SUBMENUITEM", "Ajouter un lien dans le sous-menu ?");
define("_AM_MAINPAGEITEM", "Ajouter cet article dans la page de lien ?");
define("_AM_TEXTLINK", "Titre du lien texte :");
define("_AM_LINKPAGELOGO", "Lien du Logo :");
define("_AM_BUTTON", "Image pour lien sur un bouton :");
define("_AM_LOGO", "Image pour lien sur un logo :");
define("_AM_BANNER", "Image pour lien sur une banni&#232;re :");
define("_AM_ADDNEWSFEED", "Ajouter l&#39;option fil d&#39;information  &#224; la page de liens ?");
define("_AM_NEWSFEEDTITLE", "Titre du fil d&#39;information :");
define("_AM_UPLOADIMAGE", "Upload ");
define("_AM_UPLOADLINKIMAGE", "Fichier &#224; uploader :");
define("_AM_DIRSELECT", "Choisir un r&#233;pertoire d&#39;upload :");
define("_AM_PREVIOUS", "Pr&#233;c&#233;dent");
define("_AM_NEXT", "Suivant");
define("_AM_LINKTOUS", "Lien sur notre site");

define("_AM_REFER", "Informer un ami");
define("_AM_CCONFIGREFER", "Informer un ami :");
define("_AM_CREFERINTRO", "Introduction &#224; cette page :<br /><span style='font-weight: normal;'>(Ceci apparait avant le formulaire)</span>");
define("_AM_REFERPAGELOGO", "Logo :");
define("_AM_EMAILSETTINGS", "Param&#232;tres emails");
define("_AM_EMAILADDRESS", "Utiliser l&#39;adresse mail du profil de l&#39;exp&#233;diteur ?");
define("_AM_USERSBLURB", "Autoriser l&#39;utilisateur &#224; saisir son propre message ?");
define("_AM_DEFBLURB", "Entrer le message par defaut :");
define("_AM_CHECKEMAILADDRESS", "V&#233;rifier l&#39;email ?");


define("_AM_LOGONNEWSFEED", "Logo et options du fil d&#39;informations");

define("_AM_MENUOTHER", "Autres param&#232;tres");
define("_AM_EMAILCHECK", "Ex&#233;cuter une v&#233;rification des addresses emails invalides ?");
define("_AM_DISPLAYPRIVACY", "Afficher les r&#232;gles sur respect de la vie priv&#233;e ?");
define("_AM_PRIVACYSTATEMENT", "Saisir les r&#232;gles sur le respect de la vie priv&#233;e :");

define("_AM_REORDERID", "N&deg;");
define("_AM_REORDERTITLE", "Titre");
define("_AM_REORDERWEIGHT", "Poids");
define("_AM_REORDERCHANNEL", "Les pages ont &#233;t&#233; r&#233;ordonn&#233;es !");

define("_AM_SERVERSTATUS", "Statuts du serveur");
define("_AM_SAFEMODE", "Safe Mode : ");
define("_AM_UPLOADS", "Server Uploads : ");
define("_AM_OFF", "OFF");
define("_AM_ON", "ON");
define("_AM_SAFEMODEPROBLEMS", " (Ceci peut poser probl&#232;me) ");
define("_AM_ANDTHEMAX", "Taille maximum d&#39;upload : ");
define("_AM_DELETEFILE", "ATTENTION<br/>Supprimer ce fichier ?");
define("_AM_ERRORDELETEFILE", "Erreur lors de la suppression du fichier !");
define("_AM_TOTALEMAILSSENT", "Nombre de mails envoy&#233;s pour Informer un ami");

define("_AM_NOTHINGHEREYET", "Pas de page cr&#233;&#233;e !");
define("_AM_PAGEHTMLBODY", "HTML et param&#233;trage du contenu");
define("_AM_FILEUPLOADED", "Fichier upload&#233;");
define("_AM_UPLOADDOC", "Conversion d&#39;un document Word :<br /><span style='font-weight: normal;'>Cette action convertira un document word en html .<br />Vous devez avoir Word install&#233; <br />et COM activ&#233; sur votre ordinateur pour travailler correctement.</span>");

define("_AM_IMGEDITPAGE", "Modifier la page");
define("_AM_IMGDELPAGE", "Supprimer la page");
define("_AM_PERMISSIONCHECK", "Cocher la case de chaque page pour donner l&#39;acc&#232;s au groupe concern&#233;.");
define("_AM_EXPIREDATESET", " Param&#233;trer la date d&#39;expiration : ");
define("_AM_WORDCOUNT", " <br /> Nombre de mots : ");
define("_AM_NOTSET", "Non rempli");
define("_AM_REPORTBUGS", "Reporter une erreur");
//error data
define("_AM_WF_ERROR_DELCHANNEL", "Erreur pendant la suppression des donn&#233;es de la page : <br /><br />");
define("_AM_WF_ERROR_CREATCHANNEL", "Erreur pendant la cr&#233;ation  des donn&#233;es de la page : <br /><br />");
define("_AM_WF_ERROR_UPDATCHANNEL", "Erreur pendant la mise &#224; jour des donn&#233;es de la page : <br /><br />");
define("_AM_WF_ERROR_UPDATLINK", "Erreur pendant la mise &#224; jour de la page des liens : <br /><br />");
define("_AM_WF_ERROR_UPDATREFER", "Erreur pendant la mise &#224; jour de la page Informer un ami : <br /><br />");
define("_AM_MENU","Menu");
define("_AM_UPLOADCHANTYP","Choisissez le type d&#39;upload");
define("_AM_PAGE_CAN_VIEW","Choisissez les groupes autoris&#233;s &#224; voir la page");

define("_AM_HELP","<h1>Pr&#233;f&#233;rences du modules</h1>

<p>Depuis la version de wf-channel, les options disponibles dans cette page ont &#233;volu&#233;es.</p>
<h3>R&#233;pertoire d&#39;upload des fichiers HTML</h3>
<p>Pr&#233;cise la destination du dossier qui r&#233;ceptionnera les fichiers html que vous pourriez transf&#233;rer sur le serveur par l&#39;interface d&#39;administration du module.<br />Une option vous est propos&#233;e par d&#233;faut, en effet le r&#233;pertoire uploads de votre site Xoops comporte d&#233;j&#224; les autorisations de lecture-&#233;criture(chmod>= 775)<br />Veuillez noter que le chemin ne doit pas contenir de slash (/&#34;) &#224; la fin.</p>

<h3>R&#233;pertoire de stockage des images upload&#233;es</h3>
<p>Pr&#233;cise la destination du dossier qui r&#233;ceptionnera les images que vous pourriez transf&#233;rer sur le serveur par l&#39;interface d&#39;administration du module.<br />Une option vous est propos&#233;e par d&#233;faut, en effet le r&#233;pertoire uploads de votre site Xoops comporte d&#233;j&#224; les autorisations de lecture-&#233;criture(chmod>= 775)<br />Veuillez noter que le chemin ne doit pas contenir de slash (&#34;/&#34;) &#224; la fin.</p>

<h3>R&#233;pertoire d&#39;upload des images li&#233;es</h3>
<p>Les images li&#233;es sont les images que vous pouvez choisir dans la liste d&#233;roulante lors de la cr&#233;ation d&#39;une nouvelle page, elle s&#39;afficheront avant le texte et centr&#233;es sur la page.<br />Pr&#233;cise la destination du dossier qui r&#233;ceptionnera les images &#34;li&#233;es&#34; que vous pourriez transf&#233;rer sur le serveur par l&#39;interface d&#39;administration du module.<br />Une option vous est propos&#233;e par d&#233;faut, en effet le r&#233;pertoire uploads de votre site Xoops comporte d&#233;j&#224; les autorisations de lecture-&#233;criture(chmod>= 775)<br />Veuillez noter que le chemin ne doit pas contenir de slash (&#34;/&#34;) &#224; la fin.</p>

<h3>Taille maximum upload size (kb)</h3>
<p>Cette option d&#233;finit la taille maximum en kb des fichiers que vous pouvez transf&#233;rer sur le serveur avec ce module.</p>
<h3>Largeur maximum des images en upload</h3>
<p>Les images que vous transf&#233;rerez par l&#39;interface d&#39;upload des images seront limit&#233;es &#224; la largeur indiqu&#233;e en pixels.</p>
<h3>Hauteur maximum des images en upload</h3>

<p>Les images que vous transf&#233;rerez par l&#39;interface d&#39;upload des images seront limit&#233;es &#224; la hauteur indiqu&#233;e en pixels.</p>
<h3>Nombre maximum de pages &#224; afficher par page</h3>
<p>La page index du module cot&#233; admin affiche dans un tableau les pages que vous avez cr&#233;&#233;s. Cette option d&#233;finit combien de pages sont affich&#233;es en une seule fois.</p>

<h3>Autoriser les visiteurs anonymes &#224; acc&#233;der &#224; la page : &#34; Faire un lien sur notre site ? &#34;</h3>
<p>D&#233;finisser les autorisations d&#39;acc&#232;s pour les visiteurs anonymes pour cette page sp&#233;ciale.</p>
<h3>Autoriser les visiteurs anonymes &#224; acc&#233;der &#224; la page : &#34;Informer un ami ? &#34;</h3>

<p>D&#233;finisser les autorisations d&#39;acc&#232;s pour les visiteurs anonymes pour cette page sp&#233;ciale.</p>
<h3>Utiliser l&#39;&#233;diteur Spaw (si install&#233;)</h3>
<p>Cette option permet de d&#233;finir l&#39;&#233;diteur Spaw comme &#233;diteur par d&#233;faut des pages du module, si cet &#233;diteur est install&#233; sur votre site.</p>

<h3>Utiliser l&#39;&#233;diteur FCK</h3>
<p>Cette option permet de d&#233;finir l&#39;&#233;diteur FCK comme &#233;diteur par d&#233;faut des pages du module, il est install&#233; automatiquement lors de l&#39;installation du module.<br />Si vous r&#233;pondez non &#224; la question c&#39;est l&#39;&#233;diteur standard de Xoops qui sera alors utilis&#233;.</p>

<h3>Afficher le menu sur la page index</h3><p>En r&#233;pondant Oui &#224; cette option, seront affich&#233;s sur la page index du module (cot&#233; client) un lien pour chacune des pages
<h3>Cesser Shouting dans les titres ?</h3>
<p>???????????????????????????????</p>
<h3>Type d&#39;affichage du menu int&#233;gr&#233; en bas de page</h3>

<p>Cette option vous permet de d&#233;finir le format de pr&#233;sentation des liens sur les autres pages du module pour lesquels vous avez r&#233;pondu oui &#224; la question &#34;Ajouter cet article dans la page de lien ?&#34;. Selon votre choix ces liens seront affich&#233;s verticalement ou horizontalement.<br /> A noter que cette option ne s&#39;applique pas aux pages sp&#233;ciales &#34;Recommander &#224; un ami&#34; et &#34;Cr&#233;er un lien&#34; car elles sont g&#233;r&#233;es diff&#233;remment&#34;</p>

<h3>Rcgle des commentaires</h3>
<p>Ici vous pr&#233;cisez comment fonctionne la mod&#233;ration des commentaires</p>
<h3>Autoriser les anonymes &#224; poster des commentaires</h3>
<p>R&#233;pondre oui peut parfois etre r l&#39;origine de commentaires fantaisistes, spam, etc...</p> ");

/**
 * @translation     AFUX (Association Francophone des Utilisateurs de Xoops) <http://www.afux.org/>
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8
 *
 * @version         $Id: admin.php 681 2009-08-20 16:07:20Z dugris $
**/
?>