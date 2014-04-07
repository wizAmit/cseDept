<?php
session_start();
if (!isset($_SESSION['gplusdata']))
{
// Redirection to home page
header("location: index.php");
}
else
{
$me=$_SESSION['gplusdata'];
echo "<img src='".$me['image']['url']."' />";
echo "Name: ".$me['displayName'];
echo "Gplus Id:  ".$me['id'];
echo "Male: ".$me['gender'];
echo "Relationship: ".$me['relationshipStatus'];
echo "Location: ".$me['placesLived'][0]['value'];
echo "Tagline: ".$me['tagline'];
print "<a class='logout' href='index.php?logout'>Logout</a> ";
}
?>
<meta name="viewport" content="width=device-width">
<style type="text/css">
	*{
		padding: 2px;
		margin: 1px;
		border-radius:5px;
		/*text-align: center;*/
	}
	input:invalid{
		border: 2px solid red;
	}
	input:focus:invalid {
		color: red;
	}
	input:valid {
		border: 2px solid green;
	}
	input:not(:focus):invalid {
  		border: 2px solid red;
	}
	input:focus:invalid {
  		border: 2px solid red;
	}
	form{
		text-align: left;
	}
</style>
<script language="javascript" type="text/javascript">
	<!-- 
	
	//Browser Support Code
	function ajaxFunction(){
		var ajaxRequest;  // The variable that makes Ajax possible!
			
		if (document.getElementById('UnivRoll').value < 9115001035){
			return;
		}
		try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		}catch (e){
		// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (e) {
				try{
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				}catch (e){
					// Something went wrong
					console.log("Your browser broke!");
					return false;
				}
			}
		}
		/* Create a function that will receive data 
		sent from the server and will update
		div section in the same page. */
		var fullName = document.getElementById('fullName');
		var clgRoll = document.getElementById('clgRoll');
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200){
				var ajaxDisplay = document.getElementById('res');
				var result = JSON.parse(ajaxRequest.responseText);
				ajaxDisplay.innerHTML = ajaxRequest.responseText;
				//alert (result.length);
				if (result.length == 0){
					alert ("No Such Data. Contact CSE Department.");
					location.reload(true);
				}
				else{
					for (var i=0;i<result.length;i++)
					{  
						var name = result[i].FirstName + " " + result[i].SurName;
						fullName.innerHTML = "Full Name: " + (name);
						clgRoll.innerHTML = "College Roll No.: " + result[i].CollegeRoll;
					}
				}
				
			}
		}
		// Now get the value from user and pass it to
		// server script.
		var univRoll = document.getElementById('UnivRoll').value;
		var queryString = "?univRoll=" + univRoll ;
		ajaxRequest.open("GET", "../queryExe.php" + queryString, true);
		ajaxRequest.send(null); 
		}
	function keyCheck(e){
		var code = (e.keyCode ? e.keyCode : e.keyCode);
		if ( ((code == 13) ||(code == 9)) ){
			ajaxFunction();
			//print (detailArr.toString());
			//document.getElementById('res').innerHtml = result;
		}
	}
	//-->
</script>	
<div>
	<h1>Student Detail form</h1>
	
	<p><strong>Note:</strong>If any of you detail is incorrect then please fill the Text Area given at the bottom with the field and its correct value. Appropriate measures will be taken after inspecting the same.</p>
	<form>
		<label>University Roll No.: </label>
		<input type="number" min="11500110000" step="1" id="UnivRoll" name="UniversityRollNo" pattern="\d{10,11}" 
			   title="Your 11 digit University Roll Number" onkeypress="keyCheck(event)" placeholder="University Roll Number" maxlength="11" required 
			   onblur="ajaxFunction()" autofocus> 
		<div id="subForms" style="text-align:center;">
			<button id="prevFormBtn" style="z-index:10000; display: inline; allign: left; left: 0px;">PREVIOUS</button>
			<button id="nxtFormBtn" style="z-index:10000; display: inline; allign: right;">NEXT</button>
			<div id="showFrm">
				<?php 
						
				?>
			</div>			
		</div>
	</form>
</div>
<div id="res"></div>