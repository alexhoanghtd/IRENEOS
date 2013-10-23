function searchStyle(){
	$("input#search-input").focus(function(){
		$("div#search-box").addClass("input-focused");
	});	
	$("input#search-input").blur(function(){
		$("div#search-box").removeClass("input-focused");
	});	
}
