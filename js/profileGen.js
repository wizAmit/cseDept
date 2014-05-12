var fillForm = function () {
	if (sessionStorage.getItem("univRoll")) {
		var profile = JSON.parse(localStorage.getItem("profile"));
		$("#fullName").append(profile["FirstName"] + " " + profile["SurName"]);
		$("#clgRoll").append(profile["CollegeRoll"]);
	}
};
	
var update = function() {
	var data = [];
	data.push(
		{id : $("#uid").attr("id") , 
		optionValue : $("#uid").val()}
		);
	data.push(
		{id : $("#father").attr("id") , 
		optionValue : $("#father").val()}
		);
	data.push(
		{id : $("#mother").attr("id") , 
		optionValue : $("#mother").val()}
		);
	data.push(
		{id : $("#Xpercent").attr("id") , 
		optionValue : $("#Xpercent").val()}
		);
	data.push(
		{id : $("#Xboard").attr("id") , 
		optionValue :  $("#Xboard").val()}
		);
	data.push(
		{id : $("#XpassingYr").attr("id") , 
		optionValue : $("#XpassingYr").val()}
		);
	data.push(
		{id : $("#XIIpercent").attr("id") , 
		optionValue : $("#XIIpercent").val()}
		);
	data.push(
		{id : $("#XIIboard").attr("id") , 
		optionValue : $("#XIIboard").val()}
		);
	data.push(
		{id : $("#XIIpassingYr").attr("id") , 
		optionValue : $("#XIIpassingYr").val()}
		);
	data.push(
		{id : $("#entranceExam").attr("id") , 
		optionValue : $("#entranceExam").val()}
		);
	data.push(
		{id : $("#rank").attr("id") , 
		optionValue : $("#rank").val()}
	);
	alert ("hello");
	$.post("./updateStudent.php", 
		   {"data" : data}, 
		   function(result){
				if(data.length)
					alert ("Successfully Uploaded!!");
				else		
					alert ("Something went Wrong!!");
	});
};