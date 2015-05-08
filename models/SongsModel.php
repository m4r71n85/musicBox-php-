    <?php

    class SongsModel extends BaseModel {
        public function getAll() {
            $statement = self::$db->query(
                "SELECT * FROM songs ORDER BY id");
            return $statement->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getByUserId(){
            
        }

        public function uploadSong($title, $filename, $user_id, $genre_id) {
            if ($name == '') {
                return false;
            }
            $statement = self::$db->prepare(
                "INSERT INTO `musicbox`.`songs` "
                    . "(`id`, `title`, `filename`, `user_id`, `genre_id`) "
                    . "VALUES (NULL, '?', '?', '?', '?');");
            $statement->bind_param($title, $filename, $user_id, $genre_id);
            $statement->execute();
            return $statement->affected_rows > 0;
        }

        public function deleteAuthor($id) {
            $statement = self::$db->prepare(
                "DELETE FROM authors WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            return $statement->affected_rows > 0;
        }
        
    }
