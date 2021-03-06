
<form id="create-product" class="l-2cols clearfix content-inner"
      method="POST"
      action="/collection/Create/"
      enctype="multipart/form-data">
    <!--2 colums layout left col -->
    <div class="col-left clearfix">
        <div class="product-pics">
            <div class="main-view shadow-box empty pic-input">
                <img height="100%"/>
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
            <input  type="text" class="col-right-header" placeholder="Collection name" name="collection[name]" required>
            <textarea  placeholder="Write the description here...." name="collection[description]"></textarea>
            <div>
                <input type="checkbox" name="collection[available]" value="1" /><label>active</label>
                <input type="checkbox" name="collection[is_new]" value="1" /><label>is new</label>
                <input type="hidden" name="collection[is_collection]" value="1">
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt" value="Create">
                <input type="reset" href="" class="check-out dark-bt" value="Reset">
            </div>

        </div>

    </div>

</form>
<!--end of layout $content -->