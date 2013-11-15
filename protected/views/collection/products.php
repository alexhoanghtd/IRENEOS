<?php 
 $collection = $data['collectionData'];
 $collection_cover = new Pictures();
 $collection_cover_url = "";
 $collection_cover->setVal('collection_id',$collection['id']);
 $covers = $collection_cover->select();
 if($covers){
     $collection_cover_url = $covers[0]->getVal('url');
 }
?>
<div class="content-inner single-col">
    <div class="collection-header clearfix">
        <div class="shadow-box header-cover pic-cover"
             style="background-image:
             url('<?= $collection_cover_url?>')"></div>
        <div class="collection-details">
            <h1><?=$collection['name']?></h1>
            <blockquote><?=$collection['description']?></blockquote>
        </div>
        
</div>
    <hr>
    <div class="collection-product-list">
        <ul>
            <li>
                <form class="clearfix collection-product-box">
                    <div class="collection-product-cover">
                        <div class="shadow-box empty pic-input">
                            <img height="100%">
                            <input type="file" accept="image/*" name="cover" class="file" onchange="preview(this)">
                        </div>
                    </div>
                    <div class="selected-product">
                        <h2>Product Name</h2>
                    </div>
                    <div class="item-actions">
                        <input type="submit" value="Update">
                        <a href="#" class="delete-link">delete</a>
                    </div>
                </form>
            </li>
            <hr/>
            <li>
                <form class="clearfix collection-product-box add-item">
                    <div class="collection-product-cover">
                        <div class="shadow-box empty pic-input">
                            <img height="100%">
                            <input type="file" accept="image/*" name="cover" class="file" onchange="preview(this)">
                        </div>
                    </div>
                    <div class="selected-product">
                        <h2>Product Name</h2>
                    </div>
                    <div class="item-actions">
                        <input type="submit" value="Add Product">
                        <a href="#" class="delete-link">delete</a>
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>