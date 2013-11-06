<ul>
    <?php
    if (!empty($data)) {
        foreach ($data as $product) {
            ?>
            <li>
                <a href="/product/View/<?=$product['rowid']?>">
                    <div class="result-thumb pic-cover"></div>
                    <div class="result-detail">
                        <h3><?=$product['name']?></h3>
                    </div>
                </a> 	
            </li>	  


            <?php
        }
    }
    ?>					 
</ul>