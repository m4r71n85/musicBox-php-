<?php

class PlaylistModel extends BaseModel {
    public function create($name, $creator_Id){
        if ($name == '') {
            return false;
        }
        $statement = self::$db->prepare(
            "INSERT INTO `musicbox`.`playlist` (`id`, `name`, `creator_id`) 
            VALUES (NULL, ?, ?);");
        $statement->bind_param("si", $name, $creator_Id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
    
    public function getAll() {
        $statement = self::$db->query(
                "SELECT p.id, p.name, u.username, count(ps.id) as soungs_amount, IFNULL((sum(pr.rank_value)/count(pr.id)), "-") as rank
                FROM `playlist` as p
                left join users as u ON (p.creator_id = u.id)
                left join playlist_songs as ps ON (p.id = ps.playlist_id)
                left join playlist_rank as pr ON (p.id = pr.playlist_id)
                GROUP BY p.id
                ORDER BY id");
        return $statement->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getDetails($id) {
        $statement = self::$db->query(
                "SELECT p.id, p.name, u.username, IFNULL((sum(pr.rank_value)/count(pr.id)), "-") as rank
                FROM `playlist` as p
                left join users as u ON (p.creator_id = u.id)
                left join playlist_rank as pr ON (p.id = pr.playlist_id)
                WHERE p.Id = ?
                ORDER BY p.Id");
        $statement->bind_param("i", $id);
        
        return $statement->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getSongs($id) {
        $statement = self::$db->query(
                "SELECT s.id, s.title, s.filename, g.name as 'genre-name', u.username, IFNULL((sum(sr.rank_value)/count(sr.id)), "-") as rank
                FROM `playlist` as p
                LEFT JOIN playlist_songs as ps ON (ps.playlist_id = p.id)
                LEFT JOIN songs as s ON (ps.song_id = s.id)
                LEFT JOIN genres as g ON (s.genre_id = s.genre_id)
                LEFT JOIN song_rank as sr ON (s.Id = sr.song_id)
                LEFT JOIN users as u ON (s.user_id = u.id)
                WHERE p.id = ?
                GROUP BY s.id
                ORDER BY s.title");
        $statement->bind_param("i", $id);
        
        return $statement->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getComments($id) {
        $statement = self::$db->query(
                "SELECT pc.text, pc.date_created, u.username
                FROM `playlist` as p
                INNER JOIN playlist_comments as pc ON (pc.playlist_id = p.Id)
                LEFT JOIN users as u ON (pc.user_id = u.id)
                WHERE p.id = ?
                ORDER BY pc.date_created");
        $statement->bind_param("i", $id);
        
        return $statement->fetch_all(MYSQLI_ASSOC);
    }
    
    public function addComment($playlist_id, $user_id, $text){
        if ($text == '') {
            return false;
        }
        $statement = self::$db->prepare(
            "INSERT INTO `musicbox`.`playlist_comments` 
            (`id`, `playlist_id`, `user_id`, `text`, `date_created`) 
            VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP);");
        $statement->bind_param("iis", $playlist_id, $user_id, $text);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
    
    public function addRank($userId, $playlistId, $ratingValue){
        if ($ratingValue == null || $playlistId == null || $ratingValue == null) {
                return false;
            }
            $statement = self::$db->prepare(
                "INSERT INTO `musicbox`.`playlist_rank` 
                (`id`, `playlist_id`, `user_id`, `rank_value`) 
                VALUES (NULL, '1', '5', '3')");
            $statement->bind_param("iii", $playlistId, $userId, $ratingValue);
            $statement->execute();
            return $statement->affected_rows > 0;
    }
    
    public function delete($id) {
        $statement = self::$db->prepare(
            "DELETE FROM `musicbox`.`playlist_rank` WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}