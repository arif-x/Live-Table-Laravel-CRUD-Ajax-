<!DOCTYPE html>
<html>
<head>
	<title>LIVE CRUD LARAVEL TABLE WITH AJAX</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<br />
	<div class="container box">
		<h3 align="center">LIVE CRUD LARAVEL TABLE WITH AJAX</h3><br />
		<div class="panel panel-default">
			<div class="panel-heading">Data</div>
			<div class="panel-body">
				<div id="message"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Hapus</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
					@csrf
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){

			fetch_data();

			function fetch_data()
			{
				$.ajax({
					url:"/test/fetch-data",
					dataType:"json",
					success:function(data){
						var html = '';
						html += '<tr>';
						html += '<td contenteditable id="nama"></td>';
						html += '<td contenteditable id="alamat"></td>';
						html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
						for(var count=0; count < data.length; count++){
							html +='<tr>';
							html +='<td contenteditable class="biodata" data-biodata="nama" data-id="'+data[count].id+'">'+data[count].nama+'</td>';
							html += '<td contenteditable class="biodata" data-biodata="alamat" data-id="'+data[count].id+'">'+data[count].alamat+'</td>';
							html += '<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
						} $('tbody').html(html);
					}
				});
			}

			var _token = $('input[name="_token"]').val();

			$(document).on('click', '#add', function(){
				var nama = $('#nama').text();
				var alamat = $('#alamat').text();
				if(nama != '' && alamat != ''){
					$.ajax({
						url:"{{ route('test.add-data') }}",
						method:"POST",
						data:{nama:nama, alamat:alamat, _token:_token},
						success:function(data)
						{
							$('#message').html(data);
							fetch_data();
						}
					});
				}
				else
				{
					$('#message').html("<div class='alert alert-danger'>Both Fields are required</div>");
				}
			});

			$(document).on('blur', '.biodata', function(){
				var biodata = $(this).data("biodata");
				var val = $(this).text();
				var id = $(this).data("id");
				if(val != ''){
					$.ajax({
						url:"{{ route('test.update-data') }}",
						method:"POST",
						data:{biodata:biodata, val:val, id:id, _token:_token},
						success:function(data)
						{
							$('#message').html(data);
						}
					})
				}
				else{
					$('#message').html("<div class='alert alert-danger'>Enter some value</div>");
				}
			});

			$(document).on('click', '.delete', function(){
				var id = $(this).attr("id");
				if(confirm("Are you sure you want to delete this records?")){
					$.ajax({
						url:"{{ route('test.delete-data') }}",
						method:"POST",
						data:{id:id, _token:_token},
						success:function(data){
							$('#message').html(data);
							fetch_data();
						}
					});
				}
			});
		});
	</script>
</body>
</html>