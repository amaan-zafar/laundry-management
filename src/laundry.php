<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12">	
			<div class="card">
				<div class="card-body">	
					<div class="row">
						<div class="col-md-12">		
							<table class="table" id="laundry-list">
								<thead>
									<tr>
										<th class="text-center">Customer Name</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
										<th class="text-center">Queue</th>
										<th class="text-center">Date</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $conn->query("SELECT * FROM laundry_list order by status asc, id asc ");
									while($row=$list->fetch_assoc()):
									?>
									<tr>
										<td class=""><?php echo ucwords($row['customer_name']) ?></td>
										<?php if($row['status'] == 0): ?>
											<td class="text-center"><span class="badge badge-secondary">In Queue</span></td>
										<?php elseif($row['status'] == 1): ?>
											<td class="text-center"><span class="badge badge-primary">Washing</span></td>
										<?php elseif($row['status'] == 2): ?>
											<td class="text-center"><span class="badge badge-info">Washed</span></td>
										<?php elseif($row['status'] == 3): ?>
											<td class="text-center"><span class="badge badge-success">Delivered</span></td>
										<?php endif; ?>
										<td class="text-center">
											<button type="button" class="btn btn-sm btn-info edit_laundry" data-id="<?php echo $row['id'] ?>">Update</button>
											<button type="button" class="btn btn-sm btn-danger delete_laundry" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
										<td class="text-right"><?php echo $row['queue'] ?></td>
										<td class=""><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>

									</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">		
							<button class="col-sm-3 float-left btn btn-info btn-sm" type="button" id="new_laundry"><i class="fa fa-plus"></i> Add Laundry</button>
						</div>
					</div>
				</div>
			</div>	
	</div>	
</div>
<script>
	$('#new_laundry').click(function(){
		uni_modal('Add Laundry','manage_laundry.php','mid-large')
	})
	$('.edit_laundry').click(function(){
		uni_modal('Update Laundry','manage_laundry.php?id='+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_laundry').click(function(){
		_conf("Are you sure you want to delete this laundry?","delete_laundry",[$(this).attr('data-id')])
	})
	$('#laundry-list').dataTable()
	function delete_laundry($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_laundry',
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