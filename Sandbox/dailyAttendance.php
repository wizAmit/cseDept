<!DOCTYPE html>
<html lang="en">
	<head>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<style type="text/css"> 
			#atnWindow,#takeAttendance,#sync
			{
				padding:5px;
				text-align:center;
				background-color:#e5eecc;		
				border:solid 1px #c3c3c3;
			}
			#atnWindow
			{
				padding:50px;	
				display:none;
			}
		</style>
	</head>
	<body>
		<div id="takeAttendance" >Take Attendance</div>
		<div id="atnWindow">
				<div id="rollNo"></div><nobr />
				<form id="respone">
					<input type="radio" name="present" value=1>Present</input>
					<input type="radio" name="present" value=0>Absent</input>
					<input type="button" id="btnSubmit" value="&gt&gt"></input>
				</form>
			</div>
		<div id="sync" onclick="synchronize()">Synchronize</div>
	</body>
	<script>
		$(document).ready(function(){
			$shown=false;
			$("#takeAttendance").click(function(){
				if(!$shown){
					$("#atnWindow").slideDown("slow");
					$shown=true;
				}  else  {
					$("#atnWindow").slideUp("slow");
					$shown=false;
				}
			});
			if($shown){
				$i=123;
				$("#atnWindow #rollNo").html("NOW");	
			}	
		});
	</script>
</html>