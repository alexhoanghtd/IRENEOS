<?php
$categories = Category::getCategory();
?>
<div id="categories-menu">
    <nav>
        <ul>
            <?php foreach ($categories as $category) { ?>
            <li>
                <a href="/category/View/<?=$category['id']?>">
                    <?=$category['name']?>
                </a>
            </li>

            <?php }
            ?>
        </ul>
    </nav>
</div>