jQuery(function($){
	$("#nvk-update-list-btn").click(function(event){
		event.preventDefault();
		$("#nvk-update-loader").css({"display":"inline-block"});
		$(this).prop('disabled', true);
		$.post(ajaxurl, $("#nvk-list-form").serialize(), function(response){
			$("#nvk-list-wrapper").html(response);
			$("#nvk-update-loader").css({"display":"none"});
			$("#nvk-update-list-btn").prop('disabled', false);
			$("#nvk-new-table input").val("");
		}, "html");
	});
});
