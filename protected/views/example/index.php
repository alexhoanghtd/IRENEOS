<?php 
    CT::widgets('CTList')->setModel($product = new Product());
    echo CT::widgets('CTList')->render();
?>