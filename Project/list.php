<?php session_start();?>
<html>
	<head>
		<title>Product List</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="header.css">
		<link rel="stylesheet" href="footer.css">
		<link rel="stylesheet" href="list.css">
		<link rel="stylesheet" href="Signup.css">
		<script>
			$(document).ready(function(){
				$(".type").click(function(){
					var type = $(this).text();
					window.location = "list.php?type=" + type[0];
				});
			});
		</script>
	</head>
	<body>
		<?php
			if(isset($_GET['type']))
			{
				$fileter_type = "Type";
				$filter_value = $_GET['type'];
				}
			if(isset($_GET['brand']))
			{
				$fileter_type = "Brand";
				$filter_value = $_GET['brand'];
				}	
			$servername = "localhost";
			$username = "root";
			$password = "1234";
			$conn = new mysqli($servername, $username, $password);
			$use = "use project";	
			$conn->query($use);
			$select = "Select PID,Name,Avg_Rating from general where $fileter_type = '$filter_value'";
			$result = $conn->query($select);
			$i = -1;
			while($row = $result->fetch_assoc())
			{
				$i++;
				$PID[$i] = $row['PID'];
				$Name[$i] = $row['Name'];
				$Rating[$i] = $row['Avg_Rating']."/5";
				$select_path = "Select Pic_Link from pic where PID = $PID[$i] limit 1";
				$retrieve = $conn->query($select_path);
				$fetch = $retrieve->fetch_assoc();
				$Pic_Link[$i] = $fetch['Pic_Link'];
				$select_price = "Select least(A_Price,F_Price,S_Price) as Price from shop where PID = $PID[$i]";
				$retrieve = $conn->query($select_price);
				$fetch = $retrieve->fetch_assoc();
				$Price[$i] = "Rs ".$fetch['Price'];
				}
		?>
		<div class="header">
			<h1 id="webname" style="cursor:pointer;" onclick="window.location='index.php'"><span style="color:yellow; ">&nbsp Zen</span><span style="color:white;">Tel</span></h1>
			<div class="nav-bar">
				<ul class="menu">
					<li style="margin-left:-25px;"><a class="type">Smartphones</a></li
					><li><a class="type">Tablets</a></li
					><li><a onclick="window.location='index.php#brands'">Brands</a></li
					><li><a onclick="window.location='bloglist.php'">Posts</a></li>
				</ul>
				<ul class="signin">
					<?php 
					if(!(isset($_SESSION["Flag"])) || $_SESSION["Flag"]==0)
						echo '<li style="margin-right:30;cursor:pointer"><a data-toggle="modal" data-target="#sign">Sign In</a></li>';
					else
						echo '<li style="margin-right:30;cursor:pointer"><a onclick="window.location = \'logout.php\'">Sign Out</a></li>';
					?>
				</ul>
			</div>
		</div>
		<div class="content">
			<?php
				$j = 0;	
				while($i != -1)
				{
					$print = "
					<div class=\"product\" onclick=\"window.location='product.php?PID=$PID[$j]'\">
						<div class=\"pic\">
							<img src=\"$Pic_Link[$j]\" alt=\"Pic\" />
						</div>
						<div class=\"info\">
							<div class=\"title\">
								<p>$Name[$j]</p>
							</div>
							<p>$Rating[$j]</p>
							<p>$Price[$j]</p>
						</div>
					</div>";
					echo $print;
					$j++;
					$i--;
					}
			?>	
		</div>
		<div class="footer row" style="width:101.2%;">
			<div class="container">
			<div class="col-md-6">
			<br>
				<h3>Explore/Connect</h3>
				<br>
				<p><a href="">Sign In</a></p>
				<p><a href="">Smartphones</a></p>
				<p><a href="">Tablets</a></p>
			</div>
			<div class="col-md-6">
				<br>
				<h3>About Us</h3>
				<br>
				<p>Abhishek Jain</p>
				<p>Ankita Khurrana</p>
				<p>Nihal Chauhan</p>
				<p>Kavya Sharma</p>
			</div>
			</div>
		</div>
		
		<div class="modal fade" id="sign" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="row"  style="margin-top:15px">
						<div class="col-md-12" style="height:auto">
							<div class="panel panel-login">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-6">
											<a href="#" class="active" id="login-form-link">Login</a>
										</div>
										<div class="col-xs-6">
											<a href="#" id="register-form-link">Register</a>
										</div>
									</div>
									<hr>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12">
											<form id="login-form" action="login.php" method="post" role="form" style="display: block;">
											<br>
											<?php
												if(isset($_GET['login']) && $_GET['login']==0)
													echo '  
														<div class="alert alert-danger">
															<strong>Wrong Username or Password</strong>
														</div>
														';
											?>
												<div class="form-group">
													<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Username" value="" required>
												</div>
												<div class="form-group">
													<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
												</div>
											<!-- <div class="form-group text-center">
													<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
													<label for="remember"> Remember Me</label>
												</div> -->
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3">
															<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
														</div>
													</div>
												</div>
											<!-- <div class="form-group">
													<div class="row">
														<div class="col-lg-12">
															<div class="text-center">
																<a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
															</div>
														</div>
													</div>
												</div>-->
											</form>
											<form id="register-form" action="register.php" method="post" role="form" style="display: none;">
												<div class="form-group">
													<input type="text" name="Name" id="name" tabindex="1" class="form-control" placeholder="Username" value="" required>
												</div>
												<div class="form-group">
													<input type="email" name="Email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" required>
												</div>
												<div class="form-group">
													<input type="password" name="Pass" id="pass" tabindex="2" class="form-control" placeholder="Password" required>
												</div>
												<div class="form-group text-center">
													<input type="checkbox" tabindex="3" class="" name="Subscribe" id="subs">
													<label for="remember"> Subscribe</label>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6 col-sm-offset-3">
														<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
														<!--<button name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register">Register Now</button>-->
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		
		if(isset($_GET["login"]))
		{echo '
				<script type="text/javascript">
					$(document).ready(function () {
						$("#sign").modal("show");
					});
				</script>
				';		}
		?><!--
		<script type="text/javascript">
			$(document).ready(function () {
				$("#sign").modal("show");
					}
					});
		</script>-->
		<!--
		<script>
			$(document).ready(function(){
				$("#register-submit").click(function(){	
					var name = $("#name");
					var email = $("#email");
					var pass = $("#pass");
					var subs = $("#subs");
					$.post("register.php",{Name:name,Email:email,Pass:pass,Subscribe:subs},function(){alert("success");});
					});
				});
		</script>-->
		<script>
			$('#login-form-link').click(function(e) {
				$("#login-form").delay(100).fadeIn(100);
				$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
				});
			$('#register-form-link').click(function(e) {
				$("#register-form").delay(100).fadeIn(100);
				$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
		</script>
	</body>
</html>