$(document).ready(start);

var dt; // date data type?
var tenant; // name (keep)
var apartmentNumber; // 3-digit int
var maintenanceDay; // boolean
var immediately; //boolean
var whenever; //boolean
var permission; // to enter (keep)
var timeOfDay; //string
var phoneContact; //boolean
var textContact; //boolean
var phoneNumber; // phone number data type?
var description; //big string

function start()
{
	// Display setup
	$("#received").hide();
	$("#adminPage").hide();
	
	// Click event listeners
	$("#submitButton").click(addRequest);
}

function addRequest()
{
	// Get info from form
	dt = $("#date").val(); // May want to throw in a formatting function
	tenant = $("#tenant").val();
	apartmentNumber = $("#aptNo").val();
	maintenanceDay = $("#maintenanceDay").is(":checked");
	immediately = $("#immediately").is(":checked");
	whenever = $("#whenever").is(":checked");
	permission = $("#yesPerm").is(":checked");
	timeOfDay = $("#timeOfDay").val();
	phoneContact = $("#phoneContact").is(":checked");
	textContact = $("#textContact").is(":checked");
	phoneNumber = $("#phoneNumber").val(); // May want to throw in a formatting function
	description = $("#description").val();
	
	// Do PHP
	var json = 
	{
		"dt":dt,
		"tenant":tenant,
		"apartmentNumber":apartmentNumber,
		"maintenanceDay":maintenanceDay,
		"immediately":immediately,
		"whenever":whenever,
		"permission":permission,
		"timeOfDay":timeOfDay,
		"phoneContact":phoneContact,
		"textContact":textContact,
		"phoneNumber":phoneNumber,
		"description":description
	}
	$.post("mr_main.php", json, successfulSubmission);
}

function successfulSubmission(result)
{
	console.log(result);
	
	$("#requestNote").hide(); // Same page/html file
	$("#received").fadein(500);
}