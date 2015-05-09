    <?php

    class SongsModel extends BaseModel {
        public function getAll() {
            $statement = self::$db->query(
                "SELECT s.id, s.title, s.filename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '-') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                GROUP BY s.id
                ORDER BY  (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");

            return $statement->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getByUserId($userId){
            $statement = self::$db->query(
                "SELECT s.id, s.title, s.filename, u.username, g.name, IFNULL((sum(sr.rank_value)/count(sr.id)), '-') as rank, count(sr.id) as votes
                FROM `songs` as s
                LEFT JOIN users as u ON (s.user_id = u.id)
                LEFT JOIN genres as g ON (s.genre_id = g.id)
                LEFT JOIN song_rank as sr ON (sr.song_id = s.id)
                WHERE s.user_id = ?
                GROUP BY s.id
                ORDER BY  (sum(sr.rank_value)/count(sr.id)) DESC, s.title ASC");
            $statement->bind_param("i", $userId);
            return $statement->fetch_all(MYSQLI_ASSOC);
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
            return $statement->affected_rows > 0;
        }

        public function deleteSong($id, $user_id) {
            $statement = self::$db->prepare(
                "DELETE FROM `musicbox`.`songs` WHERE id = ? AND user_id = ?");
            $statement->bind_param("ii", $id, $user_id);
            $statement->execute();
            return $statement->affected_rows > 0;
        }
        
    }
