<?php
class JsonHandler
{

    private string $jsonFolder;
    private string $jsonFile;
    private string $jsonPath;
    private $stream;

    //---------- Constructeur ----------//
    public function __construct($jsonFolder, $jsonFile)
    {
        $this->SetJsonFolder($jsonFolder);
        $this->SetJsonFile($jsonFile);
        $this->jsonPath = $this->GetJsonFolder(). $this->GetJsonFile();
    }

    //---------- Setters ----------//
    private function SetJsonFolder($folderPath)
    {
        $this->jsonFolder = $folderPath;
    }

    private function SetJsonFile($fileName)
    {
        $this->jsonFile = $fileName;
    }

    //---------- Getters ----------//
    private function GetJsonFolder()
    {
        return $this->jsonFolder;
    }

    private function GetJsonFile()
    {
        return $this->jsonFile;
    }

    /**
     * Creer le dossier et le fichier suivant les elements passe dans le constructeur.
     */
    private function CreateFile()
    {
        if (!file_exists($this->jsonFolder)) {
            mkdir($this->jsonFolder, 755);
        }
        $this->stream = fopen($this->jsonPath, "a+");
        fclose($this->stream);
    }

    /**
     * Recupere les donnees contenu dans le JSON et retourne un tableau de ces valeurs.
     * @return array
     */
    private function ReadFileToArray()
    {
        $this->stream = fopen($this->jsonPath, "r");
        $fileContent = fread($this->stream, filesize($this->jsonPath));
        fclose($this->stream);
        $jsonArray = json_decode($fileContent,true);
        return $jsonArray;
    }

    /**
     * Recupere les donnees contenu dans le JSON et retourne une chaine de caractere de ces valeurs.
     * @return string
     */
    private function ReadFileToString(){
        $this->stream = fopen($this->jsonPath, "r");
        $fileContent = fread($this->stream, filesize($this->jsonPath));
        fclose($this->stream);
        return $fileContent;
    }

    /**
     * Ecrit les donnees passe en parametre de la fonction dans un fichier au format JSON
     * Gere la creation du dossier et du fichier si inexistant.
     * le parametre DOIT etre un tableau.
     * @param array
     */
    public function WriteOnFile(array $jsonData)
    {
        if (!file_exists($this->jsonPath))
        {
            $jsonExistant [] = $jsonData;
            $this->CreateFile();
            $this->stream = fopen($this->jsonPath, "w");
            $json = json_encode($jsonExistant, JSON_PRETTY_PRINT);
            fwrite($this->stream, $json);
            fclose($this->stream);
        }
        else
        {
            $jsonExistant = $this->ReadFileToArray();
            $jsonExistant [] = $jsonData;
            $this->stream = fopen($this->jsonPath, "w");
            $json = json_encode($jsonExistant, JSON_PRETTY_PRINT);
            fwrite($this->stream, $json);
            fclose($this->stream);
        }
    }

    /**
     * Retourne les donnees du fichier en chaine de caracteres ou retourne un message d'erreur si fichier inexistant.
     * @return string
     */
    public function PrintFileToString(){
        if(file_exists($this->jsonPath))
        {
            return $this->ReadFileToString();
        }
        else
        {
            return "Le fichier n'existe pas dans le chemin : " . $this->jsonPath;
        }
    }

    /**
     * Retourne les donnees du fichier en tableau ou retourne un message d'erreur si fichier inexistant.
     * @return array
     */
    public function PrintFileToArray(){
        if(file_exists($this->jsonPath))
        {
            return $this->ReadFileToArray();
        }
        else
        {
            return "Le fichier n'existe pas dans le chemin : " . $this->jsonPath;
        }
    }
}
