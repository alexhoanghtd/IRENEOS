<<<<<<< HEAD
<!-- layout $content will be shown here -->
<form id="update-collection" class="l-2cols clearfix content-inner"
      method="POST"
      action="/collection/Update/"
      enctype="multipart/form-data">
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%" src='<?=isset($data['pictureUlrs'][0]) ? $data['pictureUlrs'][0] : "" ?>'/>
                <input type="file"
                       multiple accept='image/*'
                       name="cover" class="file"
                       onchange="preview(this)">
            </div>
        </div>
    </div>
         <div class="col-right">
        <div class="col-right-container pdetail-container">
            <input type="text" class="col-right-header" placeholder="Collection name" name="collection[name]" required>
            <textarea  placeholder="Write the description here...."
                       name="collection[description]"></textarea>
            <span class="">
                <input type="text"
                       placeholder="Vote"
                       name="collection[vote]"
                       required>
                <input type="text"
                       placeholder="Date"
                       name="collection[start_date]">
            </span>
            <div>
                <input type="checkbox"
                       name="collection[available]" value="1"><label>active</label>
                <input type="checkbox"
                       name="collection[is_new]"
                       value="1"><label>is new</label>
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt">
                <input type="reset" href="" class="check-out dark-bt">
            </div>
=======
<form id="create-product" class="l-2cols clearfix content-inner" method="POST" action="/Category/Create/" enctype="multipart/form-data">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%">
                <input type="file" multiple="" accept="image/*" name="cover" class="file" onchange="preview(this)">
            </div>
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div class="col-right-container pdetail-container">
            <input type="text" class="col-right-header" placeholder="Category name" name="category[name]" required="">
            <textarea placeholder="Write the description here...." name="category[description]"></textarea>
            <div>
                <input type="checkbox" name="category[available]" value="1"><label>active</label>
                <input type="checkbox" name="category[is_new]" value="1"><label>is new</label>
                <input type="hidden" name="category[is_collection]" value="0">
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt" value="Create">
                <input type="reset" href="" class="check-out dark-bt" value="Reset">
            </div>                                   
>>>>>>> 9b70cffc47e666e22889bc47936e25236f238dcc

        </div>

    </div>

<<<<<<< HEAD
</form>
<!--end of layout $content -->
=======
</form>
>>>>>>> 9b70cffc47e666e22889bc47936e25236f238dcc
