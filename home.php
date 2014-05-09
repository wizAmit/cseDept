<?php
	include "./header.php";
?>
		<header>
			CSE Department
		</header>
		<div id="left-pane">
			<div id="feature1" class="feature left">
				<button class="feature-name" id="login_btn">Login</button>
			</div>
			<div id="feature3" class="feature left">
				<button class="feature-name">Attendance</button>
			</div>
		</div>
		<div id="content">
			<iframe src="" id="content-iframe" frameborder="0" name="content-iframe"></iframe>
		</div>
		<div id="right-pane">
			<div id="feature2" class="feature right">
				<button class="feature-name">Search</button>
			</div>
			<div id="feature4" class="feature right">
				<button class="feature-name">Marksheet</button>
			</div>
		</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#login_btn").click(function(){
				$("#content-iframe").attr("src","./signup.php");
			});
		});
	</script>
<?php
	include "./footer.php";
?>