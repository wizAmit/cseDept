var univRoll = document.getElementById("UnivRoll");
var clgRoll = document.getElementById("clgRoll");
var name = document.getElementById("fullName");
var uid = document.getElementById("uid");
var father = document.getElementById("father");
var mother = document.getElementById("mother");
var aggrX = document.getElementById("Xpercent");
var boardX = document.getElementById("Xboard");
var yearX = document.getElementById("XpassingYr");
var aggrXII = document.getElementById("XIIpercent");
var boardXII = document.getElementById("XIIboard");
var yearXII = document.getElementById("XpassingYr");
//var entrance = document.getElementByName("entranceExam");
var rank = document.getElementById("rank");

function ajaxFunction() {
	"use strict";
	var ajaxRequest;  // The variable that makes Ajax possible!
			
	if (document.getElementById('UnivRoll').value < 9115001035) {
		return;
	}
	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				// Something went wrong
				console.log("Your browser broke!");
				return false;
			}
		}
	}
}