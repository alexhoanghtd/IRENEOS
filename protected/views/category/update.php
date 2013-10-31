<!-- layout $content will be shown here -->
<form id="update-category"  
      method="POST" 
      action="/category/Update/"
      enctype="multipart/form-data">
    <input type="text" name="category[id]" placeholder="Category id"/></br>
    <input type="text" name="category[name]" placeholder="name"/></br>
    <input type="text" name="category[description]" placeholder="description"/></br>
    <input type="text" name="category[available]" placeholder="available"/></br>
    <input type="text" name="category[start_date]" placeholder="start date"/></br>
    <input type="text" name="category[is_new]" placeholder="is new"/></br>
    <input type="text" name="category[is_collection]" placeholder="is collection"/></br>
    <input type="text" name="category[vote]" placeholder="is new"/></br>
    <input type="text" name="category[view]" placeholder="is new"/></br>
    <input type="text" name="category[cover_id]" placeholder="cover id"/></br>
    <input type="submit" value="Update Category"/>
</form>
<!--end of layout $content -->