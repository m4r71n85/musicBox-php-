<?php   

class SongsController extends BaseController {
    private $db;
    private $genresDb;

    public function onInit() {
        $this->title = "All Songs";
        $this->db = new SongsModel();
        $this->genresDb = new GenresModel();
    }

    public function index() {
        $songs = $this->db->getAll();

        $this->viewbag["songs"] = $songs;
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
                    $songTitle = substr($_FILES["song"]["name"], 0, -4);
                    $genreId = $_POST["genre"];
                    $user_id = $this->getUserDetails()["id"];
                    $isUploaded = $this->db->uploadSong($songTitle, $fileNewName, $user_id, $genreId);
                    if($isUploaded){
                        $this->addInfoMessage("The file ". basename($_FILES["song"]["name"]). " has been uploaded.");
                        $this->renderView();
                        return;
                    }
                }

                $this->addErrorMessage("Sorry, there was an error uploading your file.");
            }
        }
        
        $this->renderView();
    }
}
