<?php
class UserDB {
    public static function getUsersByCity($city_id) {
        $db = Database::getDB();

        $city = CityDB::getCity($city_id);

        $query = 'SELECT * FROM users u
           INNER JOIN cities c
           ON u.cityID = c.cityID
        WHERE u.city = :city_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":city_id", $city_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
        
            foreach ($rows as $row) {
                                $user = new User($city,
                                    $row['userEmail'],
                                    $row['password'],
                                    $row['firstName'],
                                    $row['lastName'],
                                    $row['telNumber'],
                                    $row['userAddress']);
                $user->setId($row['userID']);
                $users[] = $user;
            }
            return $users;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
    
    public static function getUser($user_jd) {
        $db = Database::getDB();
        $query = 'SELECT * 
                    FROM users u
                    INNER JOIN cities c
                        ON u.cityID = c.cityID
                    WHERE userID = :user_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":user_id", $user_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
        
            $city = CityDB::getCity($row['cityID']);
            $user = new User($city,
                                    $row['userEmail'],
                                    $row['password'],
                                    $row['firstName'],
                                    $row['lastName'],
                                    $row['telNumber'],
                                    $row['userAddress']);
            $user->setID($row['userID']);
            return $product;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>