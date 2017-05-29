$(document).ready(function(){
	$("#new_message_title,#new_message_content").keyup(function(){
		var new_post_title=$("#new_message_title").val();
		var new_post_content=$("#new_message_content").val();
		console.log(new_post_title+"aaa");
		if(
			(new_post_title.trim()=="" && new_post_title.length!=0 ||
			new_post_title.trim()=="" && new_post_title.length==0) &&
			(new_post_content.trim()=="" && new_post_content.length!=0 ||
			new_post_content.trim()=="" && new_post_content.length==0)
			)
		{
			$("#post_msg").attr("disabled",true);
		}
		if(new_post_title.trim()!="" && new_post_title.length!=0 && new_post_content.trim()!="" && new_post_content.length!=0)
			$("#post_msg").attr("disabled",false);
		else
			$("#post_msg").attr("disabled",true);
		if(new_post_title.trim()=="" && new_post_title.length!=0)
			$("#alert_title").fadeIn("slow");
		else
			$("#alert_title").fadeOut("slow");
		if(new_post_content.trim()=="" && new_post_content.length!=0)
			$("#alert_content").fadeIn("slow");
		else
			$("#alert_content").fadeOut("slow");
	});
});