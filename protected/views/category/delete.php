<!-- layout $content will be shown here -->
<form id="delete-category" class="l-2cols clearfix content-inner" 
      method="POST" 
      action="/category/Delete/"
      enctype="multipart/form-data">
    <input type="text" name="category[id]" placeholder="Category id"/></br>
    <input type="submit" value="Delete"/>
</form>
<!--end of layout $content -->