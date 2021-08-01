
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

		.done(function(){

		})

		.fail(function(){
			alert('error');
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

		.done(function(){

		})

		.fail(function(){
			alert('error');
		});

	}
});

