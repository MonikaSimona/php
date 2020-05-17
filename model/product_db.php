<?php
class ProductDB {
    public static function getProductsByCategory($category_id) {
        $db = Database::getDB();

        $category = CategoryDB::getCategory($category_id);

        $query = 'SELECT * FROM products p
           INNER JOIN categories c
           ON p.categoryID = c.categoryID
        WHERE p.categoryID = :category_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":category_id", $category_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
        
            foreach ($rows as $row) {
                                $product = new Product($category,
                                    $row['userID'],
                                    $row['productViews'],
                                    $row['productName'],
                                    $row['productDescription'],
                                    $row['productCode'],
                                    $row['productPrice'],
                                    $row['startDate'],
                                    $row['finishDate']);
                $product->setId($row['productID']);
                $products[] = $product;
            }
            return $products;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function getProductsByUser($user_id) {
        $db = Database::getDB();

        $user = UserDB::getUser($user_id);

        $query = 'SELECT * FROM products p
           INNER JOIN users u
           ON p.userID = u.userID
        WHERE p.userID = :user_id';
                  
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":user_id", $user_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
        
            foreach ($rows as $row) {
                                $product = new Product($row['categoryID'],
                                    $user,
                                    $row['productViews'],
                                    $row['productName'],
                                    $row['productDescription'],
                                    $row['productCode'],
                                    $row['productPrice'],
                                    $row['startDate'],
                                    $row['finishDate']);
                $product->setId($row['productID']);
                $products[] = $product;
            }
            return $products;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function getProductsByCity($city_id) {
        $db = Database::getDB();

        $users = UserDB::getUsersByCity($city_id);

        foreach ($users as $user) {
            $productsByUser = getProductsByUser($user.getID());
            foreach ($productsByUser as $productByUser) {
                    $product = new Product($productByUser['categoryID'],
                        $productByUser['userID'],
                        $productByUser['productViews'],
                        $productByUser['productName'],
                        $productByUser['productDescription'],
                        $productByUser['productCode'],
                        $productByUser['productPrice'],
                        $productByUser['startDate'],
                        $productByUser['finishDate']);
                $product->setId($row['productID']);
                $products[] = $product;
            }
        }
        return $products;
    }

    public static function getProduct($product_id) {
        $db = Database::getDB();
        $query = 'SELECT * 
                    FROM products p
                    INNER JOIN categories c
                        ON p.categoryID = c.categoryID
                    WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":product_id", $product_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
        
            $category = CategoryDB::getCategory($row['categoryID']);
            $product = new Product($category,
                $row['userID'],
                $row['productViews'],
                $row['productName'],
                $row['productDescription'],
                $row['productCode'],
                $row['productPrice'],
                $row['startDate'],
                $row['finishDate']);
            $product->setID($row['productID']);
            return $product;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function deleteProduct($product_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM products
                  WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':product_id', $product_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function addProduct($product) {
        $db = Database::getDB();

        $category_id = $product->getCategory()->getID();
        $user_id= = $product->getUser()->getID();
        $code = $product->getCode();
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $views = $product->getViews();
        $startDate = $product->getStartDate();
        $finishDate = $product->getFinishDate();

        $query = 'INSERT INTO products
                     (categoryID, userID, productViews, productName, productDescription, productCode, productPrice, startDate, finishDate)
                  VALUES
                     (:category_id, :user_id, :views, :name, :description, :code, :price, :startdate, :finishdate)';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':code', $code);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':views', $views);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':startdate', $startDate);
            $statement->bindValue(':finishdate', $finishDate);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function updateProduct($product) {
        $db = Database::getDB();

        $product_id = $product->getID();
        $category_id = $product->getCategory()->getID();
        $user_id= = $product->getUser()->getID();
        $code = $product->getCode();
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $views = $product->getViews();
        $startDate = $product->getStartDate();
        $finishDate = $product->getFinishDate();

        $query = 'UPDATE products
                    SET productName = :name,
                    productCode = :code,
                    productDescription = :description,
                    productPrice = :price,
                    categoryID = :category_id,
                    userID=:user_id,
                    productViews=:views,
                    startDate=:startdate,
                    finishDate=:finishdate
                    WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->bindValue(':product_id', $product_id);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':code', $code);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':views', $views);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':startdate', $startDate);
            $statement->bindValue(':finishdate', $finishDate);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>