// autocomplet : this function will be executed every time we change the text

$(document).ready(function(){
    
	$("#login_submit").click(function(){

		var username = $("#myusername").val();
		var password = $("#mypassword").val();
		if((username == "") || (password == "")) {
      		$("#message").html("<div>Please enter a username and a password</div>");
    	} else {
      		$.ajax({
        		type: "POST",
        		url: "checklogin.php",
        		data: "myusername="+username+"&mypassword="+password,
        		success: function(html){
          			if(html=='true') {
            			window.location="user_input.php";
          			} else {
            			$("#message").html(html);
          			}
        		}/*,
        		beforeSend:function(){
          			$("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>")
        		}*/
      		});
    	}
    	return false;
  	});
  $("#signup_button").click(function(){

    var password_1 = $("#s_password_1").val();
    var password_2 = $("#s_password_1").val();
    if(password_1 != password_2) {
          $("#message_2").html("<div>password not match</div>");
      } else {
          $.ajax({
            type: "POST",
            url: "signup.php",
            data: $("#sign_up_form").serialize(),
            success: function(html){
                if(html=='true') {
                  window.location="index.php";
                } else {
                  $("#message_2").html(html);
                }
            }/*,
            beforeSend:function(){
                $("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>")
            }*/
          });
      }
      return false;
    });
});
/*function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#movie_id_2').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#list_move_id_2').show();
				$('#list_move_id_2').html(data);
			}
		});
	} else {
		$('#list_move_id_2').hide();
	}
}*/

// set_item : this function will be executed when we select an item

