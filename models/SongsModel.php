    <?php

    class SongsModel extends BaseModel {
        public function getAll() {
            $statement = self::$db->query(
                "SELECT s.id, s.title, s.filename, s.imagename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                GROUP BY s.id
                ORDER BY  (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");

            return $statement->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getById($songId) {
            $statement = self::$db->prepare(
                "SELECT s.id, s.title, s.filename, s.imagename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                WHERE s.Id = ?
                GROUP BY s.id
                ORDER BY (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");
            
            $statement->bind_param("i", $songId);
            $statement->execute();
            return $statement->get_result()->fetch_assoc();
        }
        
        public function getByUserId($userId){
            $statement = self::$db->prepare(
                "SELECT s.id, s.title, s.filename, s.imagename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                WHERE s.user_id = ?
                GROUP BY s.id
                ORDER BY  (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");
            $statement->bind_param("i", $userId);
            $statement->execute();
            return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getGenre($genreId) {
            $statement = self::$db->query(
                "SELECT s.id, s.title, s.filename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '-') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                WHERE s.genre_id = ?
                GROUP BY s.id
                ORDER BY  (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");
            $statement->bind_param("i", $genreId);
            return $statement->fetch_all(MYSQLI_ASSOC);
        }

        public function uploadSong($title, $filename, $user_id, $genre_id) {
            if (!$title || !$filename || !$user_id || !$genre_id) {
                return false;
            }

            $statement = self::$db->prepare(
                "INSERT INTO `musicbox`.`songs`
                (`id`, `title`, `filename`, `user_id`, `genre_id`)
                VALUES (NULL, ?, ?, ?, ?);");
            $statement->bind_param("ssii", $title, $filename, $user_id, $genre_id);
            $statement->execute();
            return $statement->insert_id;
        }
        
         public function updateImage($rowId, $userId, $imagename) {
             
            if (!$rowId || !$userId || !$imagename) {
                return false;
            }
            $statement = self::$db->prepare(
                "UPDATE songs SET imagename = ?
                WHERE id = ? AND user_id = ?;");
            $statement->bind_param("sii", $imagename, $rowId, $userId);
            $statement->execute();
            return $statement->affected_rows > 0;
        }

        public function deleteSong($id, $user_id) {
            $statement = self::$db->prepare(
                "DELETE FROM `musicbox`.`songs` WHERE id = ? AND user_id = ?");
            $statement->bind_param("ii", $id, $user_id);
            $statement->execute();
            return $statement->affected_rows > 0;
        }
        
        public function vote($songId, $userId, $ratingValue) {
            if (!$songId || !$userId || !$ratingValue) {
                return false;
            }
            $statement = self::$db->prepare(
                "INSERT INTO `musicbox`.`song_rank`
                (`id`, `song_id`, `user_id`, `rank_value`)
                VALUES (NULL, ?, ?, ?);");
            $statement->bind_param("iii", $songId, $userId, $ratingValue);
            $statement->execute();
            return $statement->affected_rows > 0;
        }
        
        public function getComments($songId) {
            $statement = self::$db->prepare(
                "SELECT sc.text, sc.date_created, u.username
                FROM `songs_comments` as sc
                LEFT JOIN users as u ON (sc.user_id = u.id)
                where song_id = ?
                ORDER BY sc.date_created DESC");
            
            $statement->bind_param("i", $songId);
            $statement->execute();
            return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        
        public function addComment($songId, $userId, $comment) {
            if (!$songId || !$userId || !$comment) {
                return false;
            }
            $statement = self::$db->prepare(
                "INSERT INTO `musicbox`.`songs_comments`
                (`id`, `song_id`, `user_id`, `text`, `date_created`)
                VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP);");
            $statement->bind_param("iis", $songId, $userId, $comment);
            $statement->execute();
            return $statement->affected_rows > 0;
        }
    }
