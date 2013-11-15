function searchStyle() {
    $("input#search-input").focus(function() {
        $("div#search-box").addClass("input-focused");
    });
    $("#search-close").click(function(){
        $("div#search-box").removeClass("input-focused");
        document.getElementById("user-search-output").innerHTML = "";
    });
}
function ajaxSearch(input) {
    $("#user-search-output").load("http://irene.local/product/AjaxSearch/", {"name": input.value});
}
function preview(input) {
    parent = input.parentNode
    var img = parent.firstElementChild;
    var fReader = new FileReader();
    fReader.readAsDataURL(input.files[0]);
    fReader.onloadend = function(event) {
        img.src = event.target.result;
        var css = parent.getAttribute("class");
        css = css.replace('empty', '');
        parent.setAttribute("class", css);
    }
}

function viewOver(input, productId) {
    var url = $(input).css('background-image');
    darkBoxOpen();
    $(".dark-box-container").load('http://irene.local/picture/Slide/' + productId, function() {
        $(".slide-view").css("background-image", url);
    });


}

function darkBoxClose() {
    $(".dark-box").fadeOut(200);
    $(".dark-box-container").html("");
}
function darkBoxOpen() {
    $(".dark-box").fadeIn(200);
}

function ajaxBootstrap() {
    //darkBox = $(".dark-box-ajax");
    $(".dark-box-ajax").click(function(e) {
        e.preventDefault();
        darkBoxOpen();
        var url = $(e.target).attr('href');
        //alert(url);
        $(".dark-box-container").load('http://irene.local' + url);
    });
}