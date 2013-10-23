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
	//GRID VIEW CONTROLLER
	var gridWrapper = $("#grid-view-wrapper");
	var wrapperWidth = gridWrapper.css("width").replace("px","");
	if(wrapperWidth > 850){
		gridWrapper.removeClass("grid-2-cols").addClass("grid-3-cols");
	}
	if( 480 < wrapperWidth && wrapperWidth <= 850){
		gridWrapper.removeClass("grid-3-cols").addClass("grid-2-cols");
	}
	if( wrapperWidth <= 480){
		gridWrapper.removeClass("grid-3-cols grid-2-cols");
	}
}