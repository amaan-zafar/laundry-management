<?php 

?>

<div class="container-fluid">
	
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">Customer ID</th>
					<th class="text-center">Customer Name</th>
					<th class="text-center">Contact</th>
					<th class="text-center">Email</th>
					<th class="text-center">Clothes Washed</th>
					<th class="text-center">Total Paid</th>
					<th class="text-center">Update</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM customers order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td>
				 		<?php echo $row['id'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['name'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['contact'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['email'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['tot_clothes'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['tot_paid'] ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <!-- <button type="button" class="btn btn-primary">Update</button> -->
								  <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
			<div class="row">
			<div class="col-lg-12">
					<button class="btn btn-info float-left btn-sm" id="new_user"><i class="fa fa-plus"></i> Register a Customer</button>
			</div>
			</div>
			<br>
		</div>
	</div>

</div>
<script>
	
$('#new_user').click(function(){
	uni_modal('Register a customer','manage_customer.php')
})
$('.edit_user').click(function(){
	uni_modal('Update customer details','manage_customer.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this admin?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>