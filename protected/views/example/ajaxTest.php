<script>
    function loadAjax(input) {
        //alert(input.value);
        //alert('loading');
        $("#ajax-content").load("http://irene.local/example/AjaxTest/"+input.value);
    }
</script>
<div class='content-inner'>
    <input type="text" onkeyup="loadAjax(this)">
    <div id="ajax-content">Ajax content here</div>
</div>