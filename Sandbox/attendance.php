<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance</title>
	<script src="../resources/library/jquery-1.11.0.min.js"></script>
</head>
<body>
	<div id="option">
		<form method="post" id="frmSec">
			<label>Semester: </label>
			<select id="sem">
				<script>
					var mon = (new Date()).getMonth();
					if (mon>1 && mon<8)
						for ( var i=2; i<9; i=i+2)
							document.write( "<option name='sem' value='"+i+"'>" + i + "</option>");
					else
						for( var i=1; i<9; i=i+2)
							document.write( "<option name='sem' value='"+i+"'>" + i + "</option>");
				</script>
			</select>
			<section id="sec">
				A: <input id = "chkA" name = "section" type = "checkbox" value = "A" /> 
				B: <input id = "chkB" name = "section" type = "checkbox" value = "B" />
			</section>
			<button type="button" onclick="displayRoll">GO</button>
		</form>
	</div>
	<div id="container" class="center-window">
		<button id="previous" onclick="previous()" style="display:inline-block;">Previous</button>
		<div>
			<form>
				<label id="rollNumber">
					Please Select a section or both.
				</label>
				<input type="checkbox" id="present" hidden="true" />
			</form>
		</div>
		<button id="next" onclick="next()" style="display:inline-block;">Next</button>
	</div>
	<div id="ajaxRes">Here comes the result.</div>	
	<script>
		var attendance = new Object();
		var section;
		var loopIndex = 0;
		var displayRoll = function(){		
			section = "";
			$("input[name=section]:checked").each(function(){
					section += ($(this).val());
			});
			$('#ajaxRes').html("Sem: " + $("#sem").val() + "Sec: " + section);
			$.post("queryExeAttn.php", {"sem" : $("#sem").val(), "sec" : section }, function(data){
				$("#present").data("hidden",false);
				takeAttendance();
  				var takeAttendance = function(){
					var roll = data[loopIndex];
					$('#rollNumber').html(roll);
					if(attendance[roll])
						$('#present').checked= true;
					else {
						$('#present').onclick = fuction(){
							attendance[roll]=1;
						}
					}
				}
			  });
  		}
		
		var next = function(){
			loopIndex++;
			takeAttendance();
		}
		var previous = function(){
			loopIndex--;
			takeAttendance();
		}
	</script>
	
</body>
</html>