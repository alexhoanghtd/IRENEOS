<ul>
    <?php
    if (!empty($data)) {
        foreach ($data as $product) {
            
            $urls = Pictures::getProductPictures($product['rowid']);
            //print_r($urls);
            ?>
            <li>
                <a href="/product/View/<?=$product['rowid']?>">
                    <div class="result-thumb pic-cover"
                         style="background-image:
                         url('<?=(isset($urls[0]))? $urls[0] : "" ?>');
                         "
                         ></div>
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