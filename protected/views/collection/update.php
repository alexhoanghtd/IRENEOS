<!-- layout $content will be shown here -->
<form id="update-collection"
      method="POST"
      action="/collection/Update/"
      enctype="multipart/form-data">
    <input type="text" name="collection[id]" placeholder="collection id"/><br>
    <input type="text" name="collection[name]" placeholder="name"/><br>
    <input type="text" name="collection[description]" placeholder="description"/><br>
    <!--<textarea name="collection[description]" placeholder="description"/></textarea><br>-->
    <!--<input type="checkbox" name="collection[available]" value='1'/>Available<br>-->
    <input type="text" name="collection[start_date]" placeholder="start date"/><br>
<!--    <input type="checkbox" name="collection[is_new]" value='1'/>Is New<br>
    <input type="checkbox" name="collection[is_collection]" value='1'/>Is Collection<br>-->
    <input type="text" name="collection[vote]" placeholder="vote"/><br>
    <input type="text" name="collection[view]" placeholder="view"/><br>
    <input type="text" name="collection[cover_id]" placeholder="cover id"/><br>
    <input type="submit" value="Update collection"/>
</form>
<!--end of layout $content -->