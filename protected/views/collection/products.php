<div class="content-inner l-2cols">
    <link rel="stylesheet" type="text/css" href="http://irene.local/css/product-attribute.css">
    <div class="col-left clearfix">
        <div class="pic-cover shadow-box patt-cover" style="background-image: 
             url('/images/products/miss-universe/cover.jpg')">

        </div>
    </div>
    <div class="col-right clearfix">
        <div class="product-basic col-right-container">
            <h1 class="col-right-header">
                Miss Universe            </h1>
            <blockquote>
                Irene's colo loran isup erine sora piewso nott. Dusch.            </blockquote>
            <a href="/product/Update/2" class="pupdate block-link">edit basic info of this product</a>
            <a href="/product/Delete/2" class="pdelete block-link">delete this product </a>
            <hr>
            <h2>Product Attributes</h2>
            <div class="pattr-header">
                <ul class="tbl-4cols clearfix">
                    <li>Size</li>
                    <li>Color</li>
                    <li>Quantity</li>   
                    <li>Actions</li>
                </ul>
            </div>
            <!--list all the attribute that already existed -->
                            <form class="update-pattr" action="/attribute/Update" method="POST">
                    <input type="hidden" value="3" name="id">
                    <ul class="tbl-4cols clearfix">
                        <li>S</li>
                        <li>Grey</li>
                        <li><input name="quantity" type="text" value="46"></li>
                        <li>
                            <input type="submit" value="Update">
                            <a href="/attribute/Delete/3">delete</a>
                        </li>
                    </ul>
                </form>
                            <form class="update-pattr" action="/attribute/Update" method="POST">
                    <input type="hidden" value="4" name="id">
                    <ul class="tbl-4cols clearfix">
                        <li>XL</li>
                        <li>Grey</li>
                        <li><input name="quantity" type="text" value="49"></li>
                        <li>
                            <input type="submit" value="Update">
                            <a href="/attribute/Delete/4">delete</a>
                        </li>
                    </ul>
                </form>
            
                        <form class="add-pattr" method="POST" action="/Attribute/Add">
                <input type="hidden" value="2" name="product_id">
                <ul class="tbl-4cols clearfix" style="background-color: #eee;
                                                      height: 40px;
                                                      line-height: 40px;">
                    <li>
                        <select name="size_id">
                            <option value="-1" selected="">Size</option>
                             
                            <option value="1">XL</option>
                                 
                            <option value="2">S</option>
                                                        </select>
                    </li>
                    <li>
                        <select name="color_id">
                            <option value="-1" selected="">Color</option>
                             
                            <option value="1">red</option>
                                 
                            <option value="2">Green</option>
                                 
                            <option value="3">Grey</option>
                                 
                            <option value="4">Pink</option>
                                 
                            <option value="5">Purple</option>
                                 
                            <option value="6">Blue</option>
                                                        </select>
                    </li>
                    <li>
                        <input type="text" placeholder="quantity" name="quantity">
                    </li>
                    <li>
                        <input type="submit" value="Add">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>