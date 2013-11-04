<!-- layout $content will be shown here -->
<form id="update-category"  
      method="POST" 
      action="/category/Update/"
      enctype="multipart/form-data">
    <input type="text" name="category[id]" placeholder="Category id"/></br>
    <input type="text" name="category[name]" placeholder="name"/></br>
    <input type="text" name="category[description]" placeholder="description"/></br>
    <!--<textarea name="category[description]" placeholder="description"/></textarea></br>-->
    <!--<input type="checkbox" name="category[available]" value='1'/>Available</br>-->
    <input type="text" name="category[start_date]" placeholder="start date"/></br>
<!--    <input type="checkbox" name="category[is_new]" value='1'/>Is New</br>
    <input type="checkbox" name="category[is_collection]" value='1'/>Is Collection</br>-->
    <input type="text" name="category[vote]" placeholder="vote"/></br>
    <input type="text" name="category[view]" placeholder="view"/></br>
    <input type="text" name="category[cover_id]" placeholder="cover id"/></br>
    <input type="submit" value="Update Category"/>
</form>
<!--end of layout $content -->