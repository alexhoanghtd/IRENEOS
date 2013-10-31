function searchStyle() {
    $("input#search-input").focus(function() {
        $("div#search-box").addClass("input-focused");
    });
    $("input#search-input").blur(function() {
        $("div#search-box").removeClass("input-focused");
    });
}
function preview(input) {
    parent = input.parentNode
    var img = parent.firstElementChild;
    var fReader = new FileReader();
    fReader.readAsDataURL(input.files[0]);
    fReader.onloadend = function(event) {
        img.src = event.target.result;
        var css = parent.getAttribute("class");
        css = css.replace('empty','');
        parent.setAttribute("class",css);
    }
}

function viewOver(input){
    var url = input.getAttribute("style");
    alert(url);
}