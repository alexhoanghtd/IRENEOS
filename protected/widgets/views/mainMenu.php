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
                <?=($itemName=='login')?'class="dark-box-ajax"':""?>
                <?php echo ($itemName == $active)? 'class="active"' : ""; ?>
            >
            <?php echo $itemName; 
            if($itemName == 'bag' && CT::user()->bag()->countItems() > 0){
                echo '('.CT::user()->bag()->countItems().')';
            }?></a></li>
        
        <?php
        } 
       ?>
    </ul>
</nav>
<!-- end of file -->