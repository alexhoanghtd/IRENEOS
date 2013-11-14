
<?php
$collection = $data['model'];
$pic = $data['pictureUrls'];
//print_r($pic['url']);
?>
<!-- layout $content will be shown here -->
<form id="create-product" class="l-2cols clearfix content-inner"
      method="POST"
      action="/collection/Update/<?= $collection['id'] ?>"
      enctype="multipart/form-data">
    <input type='hidden' value='<?= $collection['id'] ?>' name ="collection[id]">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%" src="<?= isset($pic['url']) ? $pic['url'] : "" ?>"/>
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
            <input value="<?= $collection['name'] ?>"  type="text" class="col-right-header" placeholder="collection name" name="collection[name]" required>
            <textarea  placeholder="Write the description here...." name="collection[description]"><?php echo $collection['description'] ?></textarea>
            <div>
                <input type="checkbox"
                <?= ( $collection['available'] == '1' ) ? "checked" : "" ?>
                       name="collection[available]" value="1"><label>active</label>
                <input type="checkbox"
                <?= ( $collection['is_new'] == '1' ) ? "checked" : "" ?>
                       name="collection[is_new]"
                       value="1"><label>is new</label>
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt" value="Update">
                <a href="../Delete/<?= $collection['id'] ?>">Delete</a>
                <input type="reset" href="" class="check-out dark-bt" value="Reset">

            </div>

        </div>

    </div>

</form>
<!--end of layout $content -->