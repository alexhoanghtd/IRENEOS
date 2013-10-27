<nav>
    <ul id="main-menu-items">   
        <?php
        $menu = $this->items;
        $active = $this->active;
        $itemNames = array_keys($menu);
        foreach($itemNames as $itemName){
        ?>
        <li><a 
                href="<?php echo"$menu[$itemName]"?>"
                <?php echo ($itemName == $active)? 'class="active"' : ""; ?>
            ><?php echo $itemName ?></a></li>
        
        <?php
        } 
       ?>
    </ul>
</nav>
<!-- end of file -->