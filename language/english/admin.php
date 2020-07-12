<?php
/**
 * $Id: admin.php,v 1.1 2004/01/12 15:40:57 catzwolf Exp $
 * Module: pages
 * Version: v1.0.2
 * Release Date: 20 November 2003
 * Author: Catzwolf
 * Licence: GNU
 */

/**
 * Uni Lang defines
 */
define("_AM_SUBMIT", "Submit");
define("_AM_CREATE", "Create");
define("_AM_YES", "Yes");
define("_AM_NO", "No");
define("_AM_CANCEL", "Cancel");
define("_AM_DELETE", "Delete");
define("_AM_MODIFY", "Modify");

define("_AM_UPDATED", "Database has been updated");
define("_AM_NOTUPDATED", "There was an error updating the database!");
define("_AM_CANNOTDELETELASTONE", "You cannot delete this item, pages needs at least one item to work correctly");
define("_AM_NODEFAULTPAGESET", "WARNING: No Default page set, please select one");
define("_AM_DEFAULTPAGESET", "Default Page is Titled");
define("_AM_TOTALNUMCHANL", "Total Number of Pages");

/**
 * Lang defines for topics.php
 */
define("_AM_CHANADMIN", "Pages Admin");
define("_AM_ADDCHAN", "Create new page");
define("_AM_CHANQ", "Sub Menu Title:<br /><br /><span style='font-weight: normal;'>Link name to display within the main menu for this page.</span>");
define("_AM_CHANA", "Page Content:");
define("_AM_CHANW", "Page Weight:");
define("_AM_MODIFYCHAN", "Modify Page");
define("_AM_NOTOPICTOEDIT", "This Page does not exist within the database!");
define("_AM_MODIFYTHISCHAN", "Modify this Page");
define("_AM_DELCHAN", "Delete Page");
define("_AM_DELTHISCHAN", "Delete this Page");
define("_AM_NOCHANTOEDIT", "No page in database to modify");
define("_AM_CHANISDELETED", "Page \"%s\" has been deleted");
define("_AM_CHANCREATED", "Page was created and saved");
define("_AM_CHANNOTCREATED", "ERROR: Page was NOT created nor saved");
define("_AM_CHANMODIFY", "Page was modified and saved");
define("_AM_CHANNOTMODIFY", "ERROR: Page was NOT modified nor saved");
define("_AM_CHANIMAGEEXIST", "ERROR: File exists on server, please choose another one!");
define("_AM_CHANNOIMAGEEXIST", "No Image Selected");
define("_AM_SUBALLOW", "Allow");
define("_AM_SUBDELETE", "Delete");
define("_AM_SUBRETURN", "Return to Admin");
define("_AM_AUTHOR", "Author");
define("_AM_PUBLISHED", "Published");
define("_AM_SUBPREVIEW", "The pages Admin view");
define("_AM_SUBADMINPREV", "This is the admin preview of this topic.");
define("_AM_DBUPDATED", "Pages Database has been updated");
define("_AM_TITLE", "Title:");
define("_AM_CHAIMAGE", "Page Logo Image:");
define("_AM_CHANHTML", "Select HTML Document:<br /><br /><span style='font-weight: normal;'>This document will be used<br />as the maintext of the page.</span>");
define("_AM_DOHTMLDB", "Import Static HTML Document to Database? <br /><br /><span style='font-weight: normal;'>This option will store the HTML document<br />within the database for faster access.</span>");
define("_AM_DOCLICKTOIMPORT", " ");
define("_AM_ACTION", "Action");
define("_AM_OPTIONS", "Options:");
define("_AM_ADMINPAGE", "Main Admin Page");
define("_AM_ADMINSPPAGE", "Admin special pages");
define("_AM_PAGESLIST", "Page List");
define("_AM_DOHTML", " Disable HTML Tags");
define("_AM_DOSMILEY", " Disable Smiley Icons");
define("_AM_DOXCODE", " Disable XOOPS Codes");
define("_AM_BREAKS", " Use Xoops Linebreak Conversion? <br />(Best Disabled when using HTML Tags)");
define("_AM_DEFAULT", " Set As pages Index Page?");
define("_AM_ISSUBMENU", "Sub Menu Link");
define("_AM_ALLOWCOMMENTSCHANHTML", "Allow comments in this page?");
define("_AM_TEXTLINKHTML", "Text Link HTML Code");
define("_AM_BUTTONHTML", "Button Link HTML Code");
define("_AM_LOGOHTML", "Logo Link HTML Code");
define("_AM_BANNERHTML", "Banner Link HTML Code");
define("_AM_ADDNEWSFEEDJS", "Add JS newsfeed option to link page?");
define("_AM_CHANHDL", "Page Title:<br /><br /><span style='font-weight: normal;'>Link name to display within Index Page.</span>");
define("_AM_ID", "ID");
define("_AM_PAGETITLE", "Title");
define("_AM_WEIGHT", "Weight");
define("_AM_DEFAULTPAGE", "Index Page");
define("_AM_GENERALSET", "Module configuration");
define("_AM_MAINADMIN", "Module Index");
define("_AM_CREATENEWPAGE", "Create Page");
define("_AM_GROUPPERMISSIONS", "Module Permissions");
define("_AM_ISMAINPAGELINK", "Index Page Link");
define("_AM_PUBLISHEDDATE", "Published");
define("_AM_EXPIREDDATE", "Expired");
define("_AM_READ", "Read");
define("_AM_INEEDHELP", "Get Help");

define("_AM_UPLOAD", "Upload Settings");
define("_AM_REORDER", "Reorder pages");
define("_AM_UPLOADPATH", "Upload Path:");
define("_AM_REORDERADMIN", "Change order of pages");
define("_AM_REORDERINTRO", "To change the order in which pages appear in your pages, change their weights and then click on 'Submit'");
define("_AM_UPLOADCHANLOGO", "This page logo");
define("_AM_UPLOADCHANHTML", "Static HTML File");
define("_AM_EDITHTMLFILEEDIT", "Edit HTML file in TextAreabox");
define("_AM_CONNECTHTML", " Connect Page?");
define("_AM_CHAN_UPLOADDIR","Images upload directory");
define("_AM_CHAN_LINKIMAGES","Link images upload Directory");
define("_AM_CHAN_HTMLUPLOADDIR","HTML files upload directory");

define("_AM_PUBLISHDATE","Page Publish Date:");
define("_AM_EXPIREDATE","Page Expire Date:");
define("_AM_CLEARPUBLISHDATE","<br /><br />Remove Publish date:");
define("_AM_CLEAREXPIREDATE","<br /><br />Remove Expire date:");
define("_AM_PUBLISHDATESET"," Publish date set: ");
define("_AM_SETDATETIMEPUBLISH"," Set the date/time of publish");
define("_AM_SETDATETIMEEXPIRE"," Set the date/time of expire");
define("_AM_SETPUBLISHDATE","<b>Set Publish Date: </b>");
define("_AM_SETEXPIREDATE","<b>Set Expire Date: </b>");
define("_AM_EXPIREWARNING","<br />WARNING: Expire date set before publish date! ");

define("_AM_DOCTITLE","Use Document Title");
define("_AM_CLEANHTML","Clean HTML Document on import?<br /><br /><span style='font-weight: normal;'>WARNING: This may have adverse affects on the document.</span>");
define("_AM_STRIPHTML","Strip HTML Tags on import?<br /><br /><span style='font-weight: normal;'>WARNING: This will remove 'ALL' HTML tags from the document.</span>");
define("_AM_CLEANHTML2","Clean Page Contents on Save?<br /><br /><span style='font-weight: normal;'>Strip unwanted MS Word tags. <br />May have adverse affect on Document.</span>");
define("_AM_STRIPHTML2","Strip HTML Tags on Save?<br /><br /><span style='font-weight: normal;'>WARNING: This will remove 'ALL' HTML tags from the document.</span>");

define("_AM_CLINKTOUS", "Link Page Settings");
define("_AM_CMODIFYLINK", "Link Page Settings:");
define("_AM_SUBMENUITEM", "Add as Sub Menu Link?");
define("_AM_MAINPAGEITEM", "Add as Page Menu Link?");
define("_AM_TEXTLINK", "Text Link Title:");
define("_AM_LINKPAGELOGO", "Link Logo:");
define("_AM_BUTTON", "Image for button link:");
define("_AM_LOGO", "Image for logo link:");
define("_AM_BANNER", "Image for banner link:");
define("_AM_ADDNEWSFEED", "Add newsfeed option to link page?");
define("_AM_NEWSFEEDTITLE", "Newsfeed Title:");
define("_AM_UPLOADIMAGE", "Upload ");
define("_AM_UPLOADLINKIMAGE", "File to upload:");
define("_AM_DIRSELECT", "Choose upload directory:");
define("_AM_PREVIOUS", "Previous");
define("_AM_NEXT", "Next");
define("_AM_LINKTOUS", "Link to Us");

define("_AM_REFER", "Refer Page Settings");
define("_AM_CCONFIGREFER", "Refer Page Settings:");
define("_AM_CREFERINTRO", "Introduction to this page:<br /><span style='font-weight: normal;'>(This appears before the form)</span>");
define("_AM_REFERPAGELOGO", "Refer page logo:");
define("_AM_EMAILSETTINGS", "Email Settings");
define("_AM_EMAILADDRESS", "Use Senders Stored Email address?");
define("_AM_USERSBLURB", "Allow User to enter own Message?");
define("_AM_DEFBLURB", "Enter default message:");
define("_AM_CHECKEMAILADDRESS", "Perform Email Checks?");

define("_AM_MENU", "Menu and Page Settings");
define("_AM_LOGONNEWSFEED", "Logo and newsfeed options");

define("_AM_MENUOTHER", "Other Settings");
define("_AM_EMAILCHECK", "Perform check for invalid email addresses?");
define("_AM_DISPLAYPRIVACY", "Display Privacy statement?");
define("_AM_PRIVACYSTATEMENT", "Enter New Privacy Statement:");

define("_AM_REORDERID", "ID");
define("_AM_REORDERTITLE", "Title");
define("_AM_REORDERWEIGHT", "Weight");
define("_AM_REORDERCHANNEL", "Pages have been re-ordered!");

define("_AM_SERVERSTATUS", "Server Status");
define("_AM_SAFEMODE", "Safe Mode: ");
define("_AM_UPLOADS", "Server Uploads: ");
define("_AM_OFF", "OFF");
define("_AM_ON", "ON");
define("_AM_SAFEMODEPROBLEMS", " (This may cause problems) ");
define("_AM_ANDTHEMAX", "Max Upload Size: ");
define("_AM_DELETEFILE", "WARNING<br/>Delete This File?");
define("_AM_ERRORDELETEFILE", "Error Deleting File!");
define("_AM_TOTALEMAILSSENT", "Total Refer Emails Sent");

define("_AM_NOTHINGHEREYET", "No Pages Created: So nothing to set yet!");
define("_AM_PAGEHTMLBODY", "HTML and Page Body Settings");
define("_AM_FILEUPLOADED", "File Uploaded");
define("_AM_UPLOADDOC", "Convert Word Document:<br /><span style='font-weight: normal;'>This will convert a word document to HTML.<br />You must have word installed <br />and COM activated on your computer to work correctly.</span>");

define("_AM_IMGEDITPAGE", "Edit Page");
define("_AM_IMGDELPAGE", "Delete Page");
define("_AM_PERMISSIONCHECK", "Check the boxes of those pages each group is allowed to view.");
define("_AM_EXPIREDATESET", " Expire date set: ");
define("_AM_WORDCOUNT", " Word Count: ");
define("_AM_NOTSET", "Not Set");
define("_AM_REPORTBUGS", "Report Bug");
//error data
define("_AM_WF_ERROR_DELCHANNEL", "Error while deleting pages Page Data: <br /><br />");
define("_AM_WF_ERROR_CREATCHANNEL", "Error while creating pages Page Data: <br /><br />");
define("_AM_WF_ERROR_UPDATCHANNEL", "Error while updating pages Page Data: <br /><br />");
define("_AM_WF_ERROR_UPDATLINK", "Error while updating Link Page Data: <br /><br />");
define("_AM_WF_ERROR_UPDATREFER", "Error while updating Refer Page Data: <br /><br />");
define("_AM_MENU","Menu");
define("_AM_UPLOADCHANTYP","Choose Upload Type");

define("_AM_HELP","content of the help page");
define("_AM_PAGE_CAN_VIEW","Select groups who can see the page");
?>