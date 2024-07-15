<?php

/**
 * classe manipulant $_FILES['image']
 */
class ImageManager
{

    private const FOLDERPATH = "../public/";
    private const MAXFILESIZE = 40000000;
    private array $extensions = ['jpg', 'png', 'jpeg', 'gif'];


    private string $fileName;
    private string $fullPath;
    private string $fileType;
    private string $tmpName;
    private int $fileSize;

    private array $fileInfo;
    private string $pathFile;
    private string $uniqueName;

    private string $errorMessage;



    /**
     * prend en parametre $_FILES['image']
     */
    public function __construct(array $file)
    {
        switch (true) {
            case !$this->checkExtension($file['type']):
                $this->setError("Wrong type of file provided.");
                return null;
            case $file['error'] != 0:
                $this->setError("File provided has errors.");
                return null;
            case $file['size'] >= self::MAXFILESIZE:
                $this->setError("File provided is too big.");
                return null;
            default:
                $this->fileName = $file['name'];
                $this->uniqueName = $this->renameImage($this->fileName);
                $this->fullPath = $file['full_path'];
                $this->fileType = $file['type'];
                $this->tmpName = $file['tmp_name'];
                $this->fileSize = $file['size'];
                $this->pathFile = self::FOLDERPATH . $this->uniqueName;
                break;
        }
    }

    /**
     * DEBUG: Renvoie les Infos principales sur l'image
     */
    public function getImageInfo()
    {
        $this->fileInfo = array(
            'name' => $this->fileName,
            'uniqueName' => $this->uniqueName,
            'size' => $this->fileSize,
            'path' => $this->pathFile,
            'type' => $this->getExtensionByName($this->uniqueName)
        );

        return $this->fileInfo;
    }

    /**
     * Verifie la presence du dossier 'public' dans l'arboressence, sinon cree le dossier.
     */
    private function checkFolderPath()
    {
        if (!file_exists(self::FOLDERPATH)) {
            mkdir(self::FOLDERPATH, 755);
        }
    }

    /**
     * Deplace l'image du dossier temporaire vers le dossier 'public'.
     */
    public function moveImageToFolder()
    {
        $this->checkFolderPath();
        move_uploaded_file($this->tmpName, $this->pathFile);
    }

    /**
     * Renomme le fichier image en id unique.
     */
    private function renameImage(string $fileName)
    {
        $extension = $this->getExtensionByName($fileName);
        $uniqueName = uniqid('', true);
        //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
        return $uniqueName . "." . $extension;
    }

    /**
     * Recupere l'extension d'un fichier par son nom.
     */
    private function getExtensionByName(string $fileName)
    {
        $tabExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($tabExtension));
        return $fileExtension;
    }

    /**
     * Verifie l'extension du fichier par rapport a une liste d'extension prise en charge.
     */
    private function checkExtension(string $fileExt)
    {
        $tabExtension = explode('/', $fileExt);
        $fileExtension = end($tabExtension);
        foreach ($this->extensions as $extension) {
            if ($fileExtension == $extension) {
                return true;
            }
        }
        return false;
    }

    /**
     * Genere un message d'erreur.
     */
    private function setError(string $message)
    {
        $this->errorMessage = "<div class='error'>Erreur : $message</div>";
    }

    public function getError()
    {
        return $this->errorMessage;
    }
}
