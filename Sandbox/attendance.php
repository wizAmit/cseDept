<?php
	//include "../header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance</title>
	<link rel="stylesheet" href="../resources/library/bootstrap-3.1.1-dist/btsp_css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/basic.css">
	<script src="../resources/library/jquery-1.11.0.min.js"></script>
	<style>
		#atnWindow {
			display:none;
		}
	</style>
</head>
<body>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<div class="container">
		<div id="option">
			<form method="post" id="frmSec">
				<div class="form-group">
					<span class="row">
						<label class="col-lg-4"><h3>Subject:</h3></label>
						<span class="col-lg-8">
							<input type="text" id="subCode" required placeholder="Enter Subject Code." onchange="setSubCode()">
						</span>
					</span>
					<span class="row">
						<label class="col-md-4"><h3>Semester: </h3></label>
						<label class="col-md-8">
							<select id="sem" class="form-control">
								<script src="../js/semOptionGen.js"></script>
							</select>
						</label>
					</span>
					<span id="sec" class="row">
						<label class="col-md-2">
							<h3>A: <input id = "chkA" name = "section" 
										  type = "checkbox" value = "A"> </h3>
						</label>
						<label class="col-md-2">
							<h3>B: <input id = "chkB" name = "section" 
										  type = "checkbox" value = "B"></h3>
						</label>
				
						<button type="button" onclick="displayRoll()" 
								class="col-md-4 btn btn-lg btn-primary">
							GO
						</button>
					</span>
					
				</div>
			</form>
		</div>
		<div id="atnWindow" class="col-lg-12">
			<div class="row">
				<button id="previous" onclick="previous()"
						class="col-lg-4 btn btn-lg btn-primary">
					Previous
				</button>
				
				<div class="col-lg-4">
					<h4><label id="rollNumber" class="col-md-6">
						Please Select a section or both.
					</label></h4>
					<input type="checkbox" name="present" 
							   id="present" hidden="true">
				</div>
				<button id="next" onclick="next()"
						class="col-lg-4 btn btn-lg btn-primary">Next</button>
			</div>
			<div id="ajaxRes" class="col-lg-6">Here comes the result.</div>
			<div id="numPresent" class="col-lg-6">Head Count: <label id="presentStudents"></label></div>
			<div id="uploadRec" class="row">
				<button id="rtvLocally" onclick="retrieveLocal()" class="col-lg-4 btn btn-lg btn-primary">Retrieve from Local Store</button>
				<button id="sync" onclick="synchronize()" class="col-lg-4 btn btn-lg btn-primary">Sync</button>
				<button id="stLocally" onclick="storeLocally()" class="col-lg-4 btn btn-lg btn-primary">Store Locally</button>
			</div>
		</div>
	</div>
	
	<script>
		var attendance = [];
		var record = new Object();
		var section;
		var loopIndex = 0;
		var num_present_students = 0;
		var datetime;
		var subCode;
		
		var showRegister = function() {
			var shown=false;
			if(!shown){
				$("#atnWindow").slideDown("slow");
				shown=true;
			}  else  {
				$("#atnWindow").slideUp("slow");
				shown=false;
			}
		}
	
		var setSubCode = function() {
			subCode = $('#subCode').val();
		}
		var displayRoll = function(){		
			section = "";
			$("input[name=section]:checked").each(function(){
					section += ($(this).val());
			});
			if (section === "") {
				alert("Please select a section.");
				return;
			}
			$('#ajaxRes').html("Sem: " + $("#sem").val() + "Sec: " + section);
			datetime = (((new Date()).toISOString()).replace('T',' ')).slice(0,-5);
			attendance = [];
			$.post("./queryExeAttn.php", 
				   {"sem" : $("#sem").val(), "sec" : section }, 
				   function(data){
						$("ajaxRes").html(data);
						$("#present").attr("hidden",false);
						for (loopIndex in data) {
							num_present_students = 0;
							record = new Object();
							record.rollNo = data[loopIndex][0];
							record.present = 0;
							attendance.push(record);
						}
					   /*$('#rollNumber').html(attendance[0].rollNo);*/
					   loopIndex = -1;
					   showRegister();
					   next();
			  });
  		}
		var next = function() {
			
			$("#present").attr("hidden",false);
			
			if(loopIndex < (attendance.length - 1) )
				loopIndex++;
			else
				loopIndex = 0;
			
			$("#rollNumber").html(attendance[loopIndex].rollNo);
			
			if(attendance[loopIndex].present)
				$('#present').prop('checked','true');
			else
				$('#present').removeAttr('checked');
			
			$("#presentStudents").html(num_present_students);
		}
		var previous = function(){
			
			$("#present").attr("hidden",false);
			
			if(loopIndex > 0)
				loopIndex--;
			else
				loopIndex = (attendance.length - 1);
				
			$("#rollNumber").html(attendance[loopIndex].rollNo);
			
			if(attendance[loopIndex].present)
				$('#present').prop('checked','true');
			else
				$('#present').removeAttr('checked');
		}
		$(function() {
			$('#present').change(function() {
				
				if($(this).is(':checked')) {
					attendance[loopIndex].present += 1;
					num_present_students++;
				} else {
					if(attendance[loopIndex].present > 0)
						attendance[loopIndex].present -= 1;
					num_present_students--;
				}
			})
		});
		
		var calcPresent = function(){
			num_present_students = 0;
			for(var i = 0; i < attendance.length; i++)
				if(attendance[i].present > 0)
					num_present_students++;
			$("#presentStudents").html(num_present_students);
		}
		
		var storeLocally = function(){
			if(num_present_students < 1)
				alert("Nothing to store.");
			else {
				var name = 'Attendance_'+section+''+subCode+''+datetime;
				localStorage.setItem(name, JSON.stringify(attendance));
				alert("Stored Successfully with key = " + name);
			}
		}
		
		var retrieveLocal = function(){
			if ((localStorage.length>1)&&($("#subCode").val()==='')) {
				$("#subCode").attr("placeholder", "Please enter SubCode.");
				$('#subCode').focus();
			}
			else {
				section = "";
				$("input[name=section]:checked").each(function(){
						section += ($(this).val());
				});
				for (var i=0; i<localStorage.length;i++) {
					var itemKey = localStorage.key(i);
					subCode = $('#subCode').val();
					if((itemKey.substr(11,1) === section) && (itemKey.substr(12,3) === subCode.substr(0,3))) {
						attendance = JSON.parse(localStorage.getItem(itemKey));
						calcPresent();
						next();
						break;
					}
					else
						alert("No Such Record in Local Store. Please check Subject Code and Section.");
				}
			}
		}
		
		var synchronize = function() {

			var data = attendance;
			var massBunk = 0;
			var sec_abs;
			if (section=='A')
				sec_abs = 'B';
			else if (section=='B')
				sec_abs='A';
			else
				sec_abs="none";
			if(num_present_students < 1) {
				var answer = confirm('Is this a MASS BUNK?');
				if (answer)
					massBunk = 1;
				else
					alert ('Nothing to upload.');
			}
				
			
			$.post ("./uploadAttn.php",
				{"value": JSON.stringify(data), "time" : datetime, "sec_Absent" : sec_abs, 
				 "sem" : $("#sem").val(), "subCode" : $("#subCode").val(), "massbunk" : massBunk},
				function(result){
					var res = (result);
					$('#ajaxRes').append('<p>'+res+'Rows updated.</p>');
					localStorage.clear();
				});
			alert ("Successfully Updated!!");
			window.reload();
		}
	</script>
<?php
	//include "../footer.php";
?>