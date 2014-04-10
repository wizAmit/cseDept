<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance</title>
	<link rel="stylesheet" href="../css/btsp_css/bootstrap.css">
	<link rel="stylesheet" href="../css/btsp_fonts/glyphicons-halflings-regular.svg">
	<script src="../js/btsp_js/"></script>
	<script src="../resources/library/jquery-1.11.0.min.js"></script>
</head>
<body>
	<div class="container">
		<div id="option">
			<form method="post" id="frmSec" class="">
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
					A: <input id = "chkA" name = "a" type = "checkbox" value = "A" onclick="changeLbl()"  /> 
					B: <input id = "chkB" name = "b" type = "checkbox" value = "B" onclick="changeLbl()" />
				</section>
				<button onclick="displayRoll()">GO</button>
			</form>
		</div>
		<div>
			<button id="previous" onclick="previous()" style="display:inline-block;">Previous</button>
			<div>
				<form>
					<label id="rollNumber">
						Please Select a section or both.
					</label>
				</form>
			</div>
			<button id="next" onclick="next()" style="display:inline-block;">Next</button>
		</div>
		<div id="ajaxRes">Here comes the result.</div>	
	</div>
	
	<script>
		var chkA = document.getElementById("chkA");
		var chkB = document.getElementById("chkB");
		var lblRoll = document.getElementById("rollNumber");
		var sem = document.getElementById("sem");
		function changeLbl(){
			if(chkA.checked || chkB.checked){
				lblRoll.innerHTML = "You selected Sem: " + sem.value + " and Section: " + ((chkA.checked)? ((chkB.checked)? "A&B" : "A") : "B");
			} else {
				lblRoll.innerHTML = "Please Select a Section.";
			}

		}
		var displayRoll = function(){
			var xhr = new XMLHttpRequest();  
			 if (window.XMLHttpRequest) { // Mozilla, Safari,
				  xhr = new XMLHttpRequest();
				} else if (window.ActiveXObject) { // IE
				  try {
					xhr = new ActiveXObject("Msxml2.XMLHTTP");
				  } 
				  catch (e) {
					try {
					  xhr = new ActiveXObject("Microsoft.XMLHTTP");
					} 
					catch (e) {}
				  }
				} 
			//var data = 'sem=' + sem.value + '&sec=' + ((chkA.checked)? ((chkB.checked)? "" : "A") : "B");
			xhr.onreadystatechange = displayResponse; 
			xhr.open("POST", "queryExeAttn.php");   
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
			xhr.send('sem='+ encodeURIComponent(sem.value) + '&sec=' + encodeURIComponent((chkA.checked)? ((chkB.checked)? "" : "A") : "B"));

			 function displayResponse(){
				if(xhr.readyState == 4){
				   if (xhr.status === 200){
					var ajaxDisplay = document.getElementById('ajaxRes');
					var result = JSON.parse(xhr.responseText);
					ajaxDisplay.innerHTML = xhr.responseText;
				} else {  
					alert('There was a problem with the request.');  
				}  
			}
		}
	}
	</script>

</body>
</html>