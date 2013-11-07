<!-- layout $content will be shown here -->
<form id="create-product" class="l-2cols clearfix content-inner" 
      method="POST" 
      action="/product/Create/"
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
            <div class="more-view">
                <ul>
                    <li class="empty pic-input">
                        <img height="100%"/>
                        <input type="file" name="preview1" 
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">
                    </li>
                    <li class="empty pic-input">
                        <img height="100%"/>
                        <input type="file" name="preview2"
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">

                    </li>
                    <li class="empty pic-input">
                        <img height="100%"/>
                        <input type="file" name="preview3" 
                               multiple accept='image/*'
                               class="file" onchange="preview(this)">
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2 colums layout right col-->
    <div class="col-right">
        <div class="col-right-container pdetail-container">
            <input value="Irene's" type="text" class="col-right-header" placeholder="Product name" name="product[product_name]" >
            <textarea  placeholder="Write the description here...." name="product[product_description]">Irene's colo loran isup erine sora piewso nott. Dusch.</textarea>
            <span class="product-price">
                <input value ="220" type="text" placeholder="Price" name="product[price]" > $ <br/>
                <input type="text" placeholder="Sale" name="product[sale]"> %
            </span>
            <div>
                <input type="checkbox" name="product[available]" value="1"><label>active</label>
                <input type="checkbox" name="product[is_new]" value="1"><label>is new</label>
            </div>
            <div class="button-group">
                <input type="submit" class="add-to-bag dark-bt">
                <input type="reset" href="" class="check-out dark-bt">
            </div>                                   

        </div>

    </div>

</form>
<!--end of layout $content -->