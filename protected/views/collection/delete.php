<form id="delete-collection" class="l-2cols clearfix content-inner"
      method="POST"
      action="/collection/Delete/"
      enctype="multipart/form-data">
    <input type='hidden' value='<?=$data['id']?>' name ="collection[id]">
    <?php
        echo 'Delete success!!!';
    ?>
</form>
