
$(document).ready(function(){

	//On click signup, show register form and hide login form
	$("#signup").click(function(){
		$("#first").slideUp("slow", function(){
			$("#second").slideDown("slow");
		});
	});


	//On click signin, hide register form and show login form
	$("#signin").click(function(){
		$("#second").slideUp("slow", function(){
			$("#first").slideDown("slow");
		});
	});

});