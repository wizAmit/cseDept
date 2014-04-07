function ajaxReq(args) {
	
	try {
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		} catch (e){
		// Internet Explorer Browsers
			try {
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){
					// Something went wrong
					console.log("Your browser broke!");
					return false;
				}
			}
		}

	//var data = key + getElementById(eleId).value;
	ajaxRequest.open("POST","../queryExe.php",true);
	ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajaxRequest.send(args);
	
}