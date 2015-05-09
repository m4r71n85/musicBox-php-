<?php

class GenresModel extends BaseModel {
    public function getAll() {
        $statement = self::$db->query(
            "SELECT * FROM `genres` ORDER BY name");
        return $statement->fetch_all(MYSQLI_ASSOC);
    }
}
