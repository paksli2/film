		<footer class = "footer" data-spy="affix" >
			<div class="container">Footer</div>
		</footer>
	</body>



	<script type="text/javascript">
		$(document).ready(function () {

			$(':file').on('fileselect', function(event, numFiles, label) {
				$('.brows').html(label);
			 });

			// $(document).on('click', '.remove a', function(event) {
			// 	// event.stopPropagation();
			// 	event.preventDefault();
			// 	var id = $(this).attr("data-id");
			// 	var path = $(this).parent().find('img').attr('src');
			// 	var lastThis = this;
			// 	$.ajax({
		 //            type:'POST',
		 //            url: '/film/delete/'+id,
		 //            data:'',
		 //            cache:false,
		 //            success:function(data){
		 //        		$(lastThis).parent().remove();
		 //        		$('.alert').html('<div class="alert alert-success alert-dismissible" id="myAlert"><a href="#" class="close">&times;</a><strong>Success!</strong> '+ data +'</div>');
			// 		},
			// 	});
			// });

			$('#search_form').on('submit',(function(e) {
		        e.preventDefault();
		        var formData = new FormData($(this)[0]);
		        window.FFF = formData;
		        $.ajax({
		            type:'POST',
		            url: '/film/sort',
		            data:formData,
		            cache:false,
		            contentType: false,
		            processData: false,
		            success:function(data){
		            	var filmContainer = $('.filmContainer');
		            	console.log(data);
		            	var film = JSON.parse(data);

		            	var str = '<h2>Result of search:</h2>';
		            	if(film[0] != false){
		            		for(i = 0; i < film['count']; i++){
			            	str += '<div class="col-md-12 film"><div class="row"><div class="col-md-1 film_id">'+film[i]['id']+'</div><div class="col-md-10 film_name"><a href = "/film/'+film[i]['id']+'">'+film[i]['title']+'</a></div><div class="col-md-1 remove"><a href="/film/delete/'+film[i]['id']+'"><span class="glyphicon glyphicon-remove-sign" title="remove"></span></a></div></div></div>';
			            	}
		            	}else{
		            		str += '<p>Ничего не найдено</p>';
		            	}

		            	filmContainer.html(str);

		           
		            },
		            error: function(data){
		                console.log("error");
		                console.log(data);
		            }
		        });
		    }));

			$('#sort').on('submit',(function(e) {
		        e.preventDefault();
		        var formData = new FormData($(this)[0]);
		        window.FFF = formData;
		        $.ajax({
		            type:'POST',
		            url: '/film/sorts',
		            data:formData,
		            cache:false,
		            contentType: false,
		            processData: false,
		            success:function(data){
		            	var filmContainer = $('.filmContainer');
		            	console.log(data);
		            	var film = JSON.parse(data);

		            	var str = '';
		            	if(film){
		            		for(i = 0; i < film['count']; i++){
			            	str += '<div class="col-md-12 film"><div class="row"><div class="col-md-1 film_id">'+film[i]['id']+'</div><div class="col-md-10 film_name"><a href = "/film/'+film[i]['id']+'">'+film[i]['title']+'</a></div><div class="col-md-1 remove"><a href="/film/delete/'+film[i]['id']+'"><span class="glyphicon glyphicon-remove-sign" title="remove"></span></a></div></div></div>';
			            	}
		            	}else{
		            		str += '<p>Ничего не найдено</p>';
		            	}

		            	filmContainer.html(str);

		           
		            },
		            error: function(data){
		                console.log("error");
		                console.log(data);
		            }
		        });
		    }));



		});

	</script>



</html>