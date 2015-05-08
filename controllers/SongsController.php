<?php   

class SongsController extends BaseController {
    private $db;
    private $genresDb;

    public function onInit() {
        $this->title = "Songs";
        $this->db = new SongsModel();
        $this->genresDb = new GenresModel();
    }

    public function index() {
        $this->renderView();
    }
    
    public function upload(){
        $this->viewbag["genres"] = $this->genresDb->getAll();
        if($this->isPost){
            $extension = explode(".", $_FILES["song"]["name"]);
            $extension = $extension[count($extension)-1];

            $fileNewName = $this->generateRandomString().".".$extension;
            $target_dir = "uploads/";
            $target_file = $target_dir . $fileNewName;

            if(isset($_POST["submit"])) {
                if($_FILES["song"]["type"] != "audio/mpeg" || $extension != "mp3"){
                    $this->addErrorMessage("Sorry, only MP3 files are allowed.");
                    $this->renderView(__FUNCTION__);
                    return;
                }
                if ($_FILES["song"]["size"] > 5000000) {
                    $this->addErrorMessage("Sorry, your file is too large.");
                    $this->renderView(__FUNCTION__);
                    return;
                }
                
                if (move_uploaded_file($_FILES["song"]["tmp_name"], $target_file)) {
                    $this->addInfoMessage("The file ". basename($_FILES["song"]["name"]). " has been uploaded.");
                } else {
                    $this->addErrorMessage("Sorry, there was an error uploading your file.");
                    $this->renderView(__FUNCTION__);
                    return;
                }
                
                
                
            }
        }
        $this->renderView();
    }
}
