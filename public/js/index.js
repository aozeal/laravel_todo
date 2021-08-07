
$(".delete_btn").on('click', function(){
	const todo_id = $(this).data('id');
	if (confirm(todo_id + 'を削除しますか？')){
		$.ajaxSetup({
		 	headers: {
		    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url:'./todo/' + todo_id,
			type:'POST',
			data:{
				'_method':'DELETE'
			}
		})
		.done(function(data, textStatus, jqXHR){
			if (data.result === "error"){
				alert(data.error_msg);
			}
			else{
				location.href = "./todo";
			}
		})
		.fail(function(data, textStatus, jqXHR){
			if (data.error_msg){
				alert(data.error_msg);
			}
			else{
				alert("error");
			}
		});
	}
});
$(".done_btn").on('click', function(){
	const todo_id = $(this).data('id');
	if (confirm(todo_id + 'を達成にしますか？')){
		$.ajaxSetup({
		 	headers: {
		    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url:'./todo/' + todo_id + '/done',
			type:'POST',
			data:{
				'_method':'PUT'
			}
		})
		.done(function(data, textStatus, jqXHR){
			if (data.result === "error"){
				alert(data.error_msg);
			}
			else{
				location.href = "./todo";
			}
		})
		.fail(function(data, textStatus, jqXHR){
			if (data.error_msg){
				alert(data.error_msg);
			}
			else{
				alert("error");
			}
		});
	}
});

