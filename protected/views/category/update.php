
<?php 
    $category = $data['model'];
    $pic = $data['pictureUrls']; 
    //print_r($pic['url']);
?>
<!-- layout $content will be shown here -->
<form id="create-product" class="l-2cols clearfix content-inner" 
      method="POST" 
      action="/Category/Update/<?=$category['id']?>"
      enctype="multipart/form-data">
    <input type='hidden' value='<?=$category['id']?>' name ="category[id]">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%" src="<?=isset($pic['url']) ? $pic['url'] : "" ?>"/>
                <input type="file"                        
                       multiple accept='image/*'
                       name="cover" class="file"
                       onchange="preview(this)">
            </div>
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div class="col-right-container pdetail-container">
            <input value="<?= $category['name']?>"  type="text" class="col-right-header" placeholder="Category name" name="category[name]" required>
            <textarea  placeholder="Write the description here...." name="category[description]"><?php echo $category['description']?></textarea>
            <div>
                <input type="checkbox" name="category[available]" value="1"><label>active</label>
                <input type="checkbox" name="category[is_new]" value="1"><label>is new</label>
                <input type="hidden" name="category[is_collection]" value="0">
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt" value="Update">
                <a href="../Delete/<?=$category['id']?>">Delete</a>
                <input type="reset" href="" class="check-out dark-bt" value="Reset">
                
            </div>                                   

        </div>

    </div>

</form>
<!--end of layout $content -->