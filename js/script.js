// autocomplet : this function will be executed every time we change the text

$(document).ready(function(){
    
	$('#movie_id_1, #movie_id_2, #movie_id_3, #movie_id_4, #movie_id_5').keyup(function(){
		var min_length = 0; // min caracters to display the autocomplete
		var keyword = $(this).val();
		var movie_id = jQuery(this).attr("id");
		var list_id = "#list_" + movie_id;
	//alert(list_id);
		if (keyword.length >= min_length) {
			$.ajax({
				url: 'ajax_refresh.php',
				type: 'POST',
				data: {keyword:keyword, movie_id:movie_id},
				success:function(data){
					$(list_id).show();
					$(list_id).html(data);
				}
			});
		} else {
			$(list_id).hide();
		}
	});
	/*$('#submit_btn').click(function() {
		// body...
		var url = "welcome.php";
		//alert("2");
		$.ajax({
           type: "POST",
           url: url,
           data: $("#user_rating_form").serialize(), // serializes the form's elements.
           success: function(data)
           {
           		$('#ranks').show();
                $('#ranks').html(data); // show response from the php script.
           }
         });

    	return false; 
	});*/
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
function set_item(item, id1) {
	// change input value
	var set_movie_id = "#" + id1;
	var set_list_movie_id = "#list_" + id1;
	$(set_movie_id).val(item);
	//alert(movie_id_set);
	// hide proposition list
	$(set_list_movie_id).hide();
}
