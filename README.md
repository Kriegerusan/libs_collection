290524 { 
  - Creation du repo
  - Ajout classe de gestion des JSON
  - Ajout Fonction de retour JSON en format : 
    - string : PrintFileToString()
    - array : PrintFileToArray()
  - changement des acces pour le getters et setters : public => private
}

130624 {
  - Ajout classe de gestion des images pour $_FILES :
    - Instanciation de la classe avec param "$_FILES['image']" -> verifie l'extension de l'image, la taille, et les erreurs. attribue un nom unique au fichier.
    - Fonction getImageInfo() -> renvoie les infos de l'image dans un tableau ['name','uniqueName','size','path','type'].
    - Fonction moveImageToFolder() -> deplace l'image du dossier temporaire vers le dossier "public" dans l'arborescence du projet par son nom unique.
    - Fonction getError() -> affiche les details de l'erreur si l'instanciation retourne null.
}