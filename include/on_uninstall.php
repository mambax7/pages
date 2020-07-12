# function supprimer_rep ($tableau) { // fonction pour supprimer un ou plusieurs repertoires et tout ce qu'il y a dedans
#     foreach ($tableau as $dir) {
#     if (file_exists ($dir)) {
#         $dh = opendir ($dir);
#         while (($file = readdir ($dh)) !== false ) {
#             if ($file !== '.' && $file !== '..') {
#             if (is_dir ($dir.'/'.$file)) {
#                 $tab = array ($dir.'/'.$file);
#              supprimer_rep ($tab); // si on trouve un repertoire, on fait un appel recursif pour fouiller ce repertoire
#             }
#             else {
#                 if (file_exists ($dir.'/'.$file)) {
#                     unlink ($dir.'/'.$file); // si on trouve un fichier, on le supprime
#                 }
#             }
#         }
#     }
#     closedir ($dh);
#     if (is_dir ($dir)) {
#         rmdir ($dir); // on supprime le repertoire courant
#     }
# return true;
# }
# }
# }
#  
# supprimer_rep (array ('test2'));