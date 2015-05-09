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
    public function rate($songId){
        $this->authorized();
        
        if($this->isPost){
            $ratingValue = $_POST['rating-value'];
            $userId = $this->getUserDetails()["id"];
            
            if(0<=$ratingValue && $ratingValue<=5){
                $success = $this->db->vote($songId, $userId, $ratingValue);
                if(!$success){
                    $this->addErrorMessage("You cannot vote for this song!");
                }
            } else{
                $this->addErrorMessage("Your vote must be between 0 and 5!");
            }
        }
        
        $this->redirect("Songs");
    }
    
      
    public function upload(){
        $this->viewbag["genres"] = $this->genresDb->getAll();
        if($this->isPost){
            $fileNewName = $this->generateRandomString();
            if(isset($_POST["submit"])) {
                $rowId = $this->saveMusicFile($fileNewName);
                if($rowId && $_FILES["image"]){
                    $asd = $this->saveImageFile($rowId, $fileNewName);
                    var_dump($asd);
                }
            }
        }
        
        $this->renderView();
    }
    
    private function saveImageFile($rowId, $fileNewName){
        $target_dir = "uploads/covers/";
        $imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
        $target_full_path = $target_dir . $fileNewName.".".$imageFileType;
        $target_file = $fileNewName.".".$imageFileType;
        if ($_FILES["image"]["size"] > 500000) { //5mb
            $this->addErrorMessage("Sorry, your image file is too large.");
            return false;
        }
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            $this->addErrorMessage("File is not an image.");
            return false;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $this->addErrorMessage("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            return false;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_full_path)) {
            $userId = $this->getUserDetails()["id"];
            $isUploaded = $this->db->updateImage($rowId, $userId, $target_file);
            if($isUploaded){
                $this->addInfoMessage("The image file ". basename($_FILES["song"]["name"]). " has been uploaded.");
                return true;
            }
        }

        $this->addErrorMessage("Sorry, there was an error uploading image file.");
        return false;
    }
    
    private function saveMusicFile($fileNewName){
        $extension = explode(".", $_FILES["song"]["name"]);
        $extension = $extension[count($extension)-1];
        $fileNewName .= ".".$extension;
        $target_dir = "uploads/";
        $target_file = $target_dir . $fileNewName;

        if($_FILES["song"]["type"] != "audio/mpeg" || $extension != "mp3"){
            $this->addErrorMessage("Sorry, only MP3 files are allowed.");
            $this->renderView(__FUNCTION__);
            return false;
        }
        if ($_FILES["song"]["size"] > 8000000) { //8 mb
            $this->addErrorMessage("Sorry, your mp3 file is too large.");
            $this->renderView(__FUNCTION__);
            return false;
        }

        if (move_uploaded_file($_FILES["song"]["tmp_name"], $target_file)) {
            $songTitle = substr($_FILES["song"]["name"], 0, -4);
            $genreId = $_POST["genre"];
            $user_id = $this->getUserDetails()["id"];
            $rowId = $this->db->uploadSong($songTitle, $fileNewName, $user_id, $genreId);
            if($rowId){
                $this->addInfoMessage("The file ". basename($_FILES["song"]["name"]). " has been uploaded.");
                $this->renderView();
                return $rowId;
            }
        }

        $this->addErrorMessage("Sorry, there was an error uploading your file.");
        return false;
    }
    
    public function download(){
        $this->authorized();
        
        if($this->isPost){
            $file_url = $_POST["filename"];
            $filetitle = str_replace(" ", "_", $_POST["filetitle"]);
            header("Content-disposition: attachment; filename=".$filetitle);
            header("Content-type: audio/mpeg");
            readfile($file_url);
            
            header('Content-Type: audio/mpeg');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
            
            readfile($file_url);
        }
        else {
            $this->redirect("songs");
        }
    }
}
