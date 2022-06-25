<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Laundrover</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=laundry");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    background: #5bc0de;
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login{
		position: absolute;
		left:25%;
		width:50%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login .card{
		margin: auto
	}

</style>

<body>


  <main id="main" class=" bg-dark">
  		<div id="login">
			  <div class="card col-md-8">
				  <div class="card-body">
					  <h2>Laundry Management System</h2>
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">Admin Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-lg btn-wave col-md-4 btn-info">Login</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=laundry';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>