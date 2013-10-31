window.onresize = responsive;	

function responsive(){
	mainLayoutControl();
	gridController();
}
function mainLayoutControl(){
	//PAGE CONTROL
	if(window.innerWidth <= 960){
		$("div#container").removeClass("desktop-view").addClass("mobile-view");
	}else{
		$("div#container").removeClass("mobile-view").addClass("desktop-view");
	}
}
function gridController(){
	var container = $("#content-inner.grid-layout");
	var width = parseInt(container.css("width"));
	if(width <= 480){
		container.removeClass("gl-2cols");
		container.removeClass("gl-3cols");
		container.addClass("gl-1col");
	}
	if(480 < width && width <= 640){
		container.removeClass("gl-1col");
		container.removeClass("gl-3cols");
		container.addClass("gl-2cols");
	}
	if( width > 640){
		container.removeClass("gl-2cols");
		container.removeClass("gl-1col");
		container.addClass("gl-3cols");
	}
}