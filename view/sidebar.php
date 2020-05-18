<aside>
<h2>Categories</h2>
    <ul>
        <!-- display links for all categories -->
        <?php
            require_once('model/database.php');
            require_once('model/category.php');
            require_once('model/category_db.php');
            
            $categories = CategoryDB::getCategories();
            foreach($categories as $category) :
                $name = $category->getName();
                $id = $category->getID();
                $url = $app_path . 'catalog?category_id=' . $id;
        ?>
        <li>
            <a href="<?php echo $url; ?>">
               <?php echo htmlspecialchars($name); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</aside>