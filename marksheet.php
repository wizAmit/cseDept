<?php
	//include "./header.php";
	//include './header-includes.php';
?>
<!--<div id="container" class="container">-->
		<input type="text" id="univRoll" placeholder="University Roll" class="form-control">
		<input type="text" id="sem" placeholder="Semester" class="form-control">
		<!--<select id="semester">
			<script>
				if ($("#univRoll").val()=="")
					$(this).attr('placeholder','Enter University Roll');
			</script>
		</select>-->
		<button id="submit" onclick="getMarks()" class="btn btn-default">Submit</button>
	<div id="ajaxRes" class="table-responsive">

	</div>
<!--</div>-->
<script>
	var getMarks = function() {
		var univRoll = $("#univRoll");
		var sem = $("#sem");
		$.post("getMarks.php", 
				   {"sem" : sem.val(), "univRoll" : univRoll.val() }, 
				   function(data){
					   if (data.length>0)
							$("#ajaxRes").html(data);
			  });
	}
</script>
<?php
	//include "./footer.php";
?>