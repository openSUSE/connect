<?php ?>

function advanced_comments_load(comments_offset, save_settings){
	
	$load_form = $("#advanced-comments-form");
	
	if(save_settings !== ""){
		$load_form.find("input[name='save_settings']").val(save_settings);
	}
	
	$load_form.find("input[name='comments_offset']").val(comments_offset);
	var post_data = $load_form.serialize();
	$("#advanced-comments-more").find("span, div").toggle();
	$.post($load_form.attr("action"), post_data, function(return_data){
		if(return_data){
			if(save_settings == "yes"){
				$("#advanced-comments-container").html(return_data);
			} else {
				$("#advanced-comments-more").before(return_data).remove();
			}
		}
	}); 
}

function advanced_comments_is_scrolled_into_view(elem){
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
}

function advanced_comments_bind_auto_load(){
	$(window).unbind('scroll.advanced_comments').bind('scroll.advanced_comments', function(){
		if(advanced_comments_is_scrolled_into_view($("#advanced-comments-more > span:visible"))){
			$("#advanced-comments-more").click();
		}
	});
}

function advanced_comments_unbind_auto_load(){
	$(window).unbind('scroll.advanced_comments');
}

$(document).ready(function(){
	$("#advanced-comments-form select").live("change", function(){
		advanced_comments_load(0, "yes");
	});
	
	$("#advanced-comments-more").live("click", function(){
		var comments_offset = $(this).find("#comments_offset").val(); 
		advanced_comments_load(comments_offset,"no");
	});
});