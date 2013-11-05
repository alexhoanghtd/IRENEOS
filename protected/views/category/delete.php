

<!-- layout $content will be shown here -->
<form id="delete-category" class="l-2cols clearfix content-inner" 
      method="POST" 
      action="/category/Delete/"
      enctype="multipart/form-data">
    <input type='hidden' value='<?=$data['id']?>' name ="category[id]">
    <?php
        echo 'Delete success!!!';
    ?>
</form>
<!--end of layout $content -->