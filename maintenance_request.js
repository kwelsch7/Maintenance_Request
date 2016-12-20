$(document).ready(start);

var dt; // date data type
var tenant; // varchar(80)
var apartmentNumber; // 3-digit int
var maintenanceDay; // boolean
var immediately; // boolean
var whenever; // boolean
var permission; // boolean
var timeOfDay; //varchar(40)
var phoneContact; //boolean
var textContact; //boolean
var phoneNumber; // parse to char(9)
var description; // text data type

function start()
{
	// Display setup
	$("#received").hide();
	$("#adminPage").hide();
	$("#date").focus();
	
	// Click event listeners
	$("#submitButton").click(addRequest);
	$("#returnButton").click(newRequest);
}

function validateForm()
{
	parseDate();
	tenant = $("#tenant").val();
	apartmentNumber = $("#aptNo").val();
	maintenanceDay = $("#maintenanceDay").is(":checked");
	immediately = $("#immediately").is(":checked");
	whenever = $("#whenever").is(":checked");
	permission = $("#yesPerm").is(":checked");
	timeOfDay = $("#timeOfDay").val();
	phoneContact = $("#phoneContact").is(":checked");
	textContact = $("#textContact").is(":checked");
	parsePhone();
	description = $("#description").val();
	
	if(apartmentNumber > 114 && apartmentNumber < 201 || apartmentNumber > 214 && apartmentNumber < 301)
		; // Not a validate apartment number (outer ends are validated in the HTML)
	if(!maintenanceDay && !immediately && !whenever)
		; // No urgency given
	if(timeOfDay == "")
		; // No timeframe given
	if(!phoneContact && !textContact && phoneNumber == "")
		; // Warn of no contact info given, but allow them to leave blank if they have none
	if(description == "")
		; // No descrption given
	
	
}

function parseDate()
{
	// A helper function to validateForm
	dt = $("#date").val();
	//get 8 digits out of whatever they put and turn it into a YYYY-MM-DD format
	
}

function parsePhone()
{
	// A helper function to validateForm
	phoneNumber = $("#phoneNumber").val();
	//get nine digits out of whatever they put (ignore country code)
	
}

function addRequest()
{
	// Get info from form (prevent submission if not corredct format)
	validateForm();
	
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
	//Should I give the key for that maintenance request so the user can access and edit it?
	
	$("#requestNote").hide(); // Same page/html file
	$("#received").fadeIn(500);
	$("#returnButton").focus();
}

function newRequest()
{
	// Clears form in preparation for a new entry
	$("#date").val("");
	$("#tenant").val("");
	$("#aptNo").val("");
	$("#maintenanceDay").is(":checked"); // How to uncheck?
	$("#immediately").is(":checked");
	$("#whenever").is(":checked");
	$("#yesPerm").is(":checked"); // How to check?
	$("#timeOfDay").val("");
	$("#phoneContact").is(":checked");
	$("#textContact").is(":checked");
	$("#phoneNumber").val("");
	$("#description").val("");
	
	// Ready the display
	$("#receieved").hide();
	$("#requestNote").fadeIn(500);
	$("#date").focus();
	
	
}