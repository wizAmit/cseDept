<?php
	//include "./header.php";
	//include './header-includes.php';
	include './getMarks.php';
?>
	<link rel="stylesheet" href="./css/basic.css" >
<!--<div id="container" class="container">-->
		<!--<input type="text" id="univRoll" placeholder="University Roll" class="form-control">-->
		<!--<input type="text" id="sem" placeholder="Semester" class="form-control">-->
		<select id="semester">
			<?php
				for ($i = 1; $i < $_COOKIE['sem']; $i++)
					echo ("<option name='sem' value='".$i."'>" . $i . "</option>");
			?>
		</select>
		<button id="submit" onclick="getMarks()" class="btn btn-default">Submit</button>
	<div id="ajaxRes" class="table-responsive">

	</div>
<!--</div>-->
<script>
	var getMarks = function() {
		//var univRoll = $("#univRoll");
		var sem = $("#semester");
		$.post("getMarks.php", 
				   {"semester" : sem.val() }, 
				   function(data){
					   if (data.length>0)
							$("#ajaxRes").html(data);
			  });
	}
</script>
<?php
	//include "./footer.php";
?>