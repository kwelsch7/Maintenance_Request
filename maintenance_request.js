$(document).ready(start);

var dt; // date data type
var tenant; // varchar(60)
var apartmentNumber; // 3-digit int
var maintenanceDay; // boolean -- enum('true', 'false')
var immediately; // boolean
var whenever; // boolean
var permission; // boolean
var timeOfDay; //varchar(60)
var phoneContact; //boolean
var textContact; //boolean
var phoneNumber; // parse to char(9)
var description; // text data type

function start()
{
	// Display setup
	$("#receivedNote").hide();
	$("#adminPage").hide();
	$("#date").focus();
	
	// Click event listeners
	$("#submitButton").click(addRequest);
	$("#adminLogin").click(goAdminPage);
	$(".adminLogout").click(loggingOut);
	$("#returnButton").click(newRequest);
}

function validateForm()
{
	var dateParsed = parseDate();
	tenant = $("#tenant").val();
	apartmentNumber = $("#aptNo").val();
	maintenanceDay = $("#maintenanceDay").is(":checked");
	immediately = $("#immediately").is(":checked");
	whenever = $("#whenever").is(":checked");
	permission = $("#yesPerm").is(":checked");
	timeOfDay = $("#timeOfDay").val();
	phoneContact = $("#phoneContact").is(":checked");
	textContact = $("#textContact").is(":checked");
	var phoneParsed = parsePhone();
	description = $("#description").val();
	
	var message = "";
	var contactInfo = true;
	
	if(!dateParsed)
		message += "-Date not given/is invalid.\r\n";
	if(tenant == "")
		message += "-Name not given.\r\n";
	if(apartmentNumber > 114 && apartmentNumber < 201 || apartmentNumber > 214 && apartmentNumber < 301 || apartmentNumber < 101 || apartmentNumber > 314)
		message += "-Not a valid apartment number.\r\n";
	if(!maintenanceDay && !immediately && !whenever)
		message += "-No response time given.\r\n";
	if(timeOfDay == "")
		message += "-No time of day given.\r\n";
	if(!phoneContact && !textContact)
		contactInfo = window.confirm("No contact method was given.\r\nClick 'yes' if you have no working phone;\r\notherwise, choose 'cancel' and enter that information.");
	else if(phoneContact && textContact && phoneNumber == "")
		message += "-Contact method given but no phone number provided.\r\n";
	if(description == "")
		message += "-No description of the problem given."; // No description given
	
	if(message != "" || !contactInfo)
	{
		// Put focus at the earliest problem field
		if(message[1] == 'D')
			$("#date").focus();
		else if(message[3] == 'm')
			$("#tenant").focus();
		else if(message[7] == 'v')
			$("#aptNo").focus();
		else if(message[4] == 'r')
			$("#maintenanceDay").focus();
		else if(message[5] == 'i')
			$("#timeOfDay").focus();
		else if(!contactInfo)
			$("#phoneContact").focus();
		else if(message[1] == 'C')
			$("#phoneNumber").focus();
		else if(message[4] == 'd')
			$("#description").focus();
		
		if(message != "")
		{
			message = "Errors:\r\n" + message;
			alert(message);
		}
		return false;
	}
	return true;
}

function parseDate()
{
	// A helper function to validateForm
	dt = $("#date").val();
	var formattedDt = "";
	var count = 0;
	
	for(var x = 0; x < dt.length; x++)
	{
		if($.isNumeric(dt[x]))
		{
			if(count == 4 || count == 6)
				formattedDt += "-";
			formattedDt += dt[x];
			count++;
		}
	}
	date = formattedDt;
	
	if(count != 8)
		return false;
	return true;
}

function parsePhone()
{
	// A helper function to validateForm
	phoneNumber = $("#phoneNumber").val();
	var formattedPhone = "";
	var count = 0;
	
	for(var x = 0; x < phoneNumber.length; x++)
	{
		if($.isNumeric(phoneNumber[x]))
		{
			if(!(count == 0 && phoneNumber[x] == 1)) //ignore country code
			{
				if(count == 3 || count == 6)
					formattedPhone += "-";
				formattedPhone += phoneNumber[x];
				count++;
			}
		}
	}
	phoneNumber = formattedPhone;
	
	if(count != 9)
		return false;
	return true;
}

function addRequest()
{
	// Global variables are assigned in validateForm()
	if(validateForm())
	{
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
		
		$.post("maintenance_request.php", json, successfulSubmission);
	}
}

function successfulSubmission(result)
{
	console.log(result);
	//Should I give the key for that maintenance request so the user can access and edit it?
	
	$("#requestNote").hide(); // Same page/html file
	$("#receivedNote").fadeIn(500);
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
	$("#receivedNote").hide();
	$("#requestNote").fadeIn(500);
	$("#date").focus();
	
	
}

function goAdminPage()
{
	// Fill the table with the recent requests
	$.getJSON("maintenance_request.php", function(requests) {
		console.log(requests);
		for(var r = 0; r < requests.length; ++r)
		{
			var appStr = "<tr class='adminRows' id='" + r + "' style='display: table-row; border: 1px;";
			if(requests[r]["done"] == "true")
				appStr += " background: grey; color: white;";
			appStr += "'><td>";
			if(requests[r]["done"] == "true")
				appStr += "&nbsp&nbsp&nbsp &#x2714";
			appStr += "</td><td>"
			appStr += requests[r]["description"];
			appStr += "</td><td>";
			appStr += requests[r]["dt"];
			appStr += "</td></tr></div>";
			
			$("#requestList").append(appStr);
		}
		
		$(".adminRows").click({param: requests}, adminOnNote);
	});
	
	// Ready the display
	$("#requestNote").hide();
	$("#adminPage").fadeIn(500);
}

function adminOnNote(event)
{
	var requests = event.data.param;
	console.log(requests);
	// An "id" was given to each row (in the tr tag) in the for loop, which was "r" or the row number.
	//   This is also its index in the Object "requests" (which is why it's used here)
	var i = $(this).attr("id");
	
	// Pre-populates the form with the info from the Request
	$("#date").val(requests[i]["date"]);
	$("#tenant").val(requests[i]["tenant"]);
	$("#aptNo").val(requests[i]["apartmentNumber"]);
	if(requests[i]["maintenanceDay"] == "true")
		; //$("#maintenanceDay").is(":checked"); // How to uncheck?
	if(requests[i]["immediately"] == "true")
		; //$("#immediately").is(":checked");
	if(requests[i]["whenever"] == "true")
		; //$("#whenever").is(":checked");
	if(requests[i]["yesPerm"] == "true")
		; //$("#yesPerm").is(":checked"); // How to check?
	$("#timeOfDay").val(requests[i]["timeOfDay"]);
	if(requests[i]["phoneContact"] == "true")
		; //$("#phoneContact").is(":checked");
	if(requests[i]["textContact"] == "true")
		; //$("#textContact").is(":checked");
	$("#phoneNumber").val(requests[i]["phoneNumber"]);
	$("#description").val(requests[i]["description"]);
	
	// Ready the display
	$("#line6").css("display", "table-row");
	$("#line7").css("display", "table-row");
	$("#adminPage").hide();
	$("#requestNote").fadeIn(500);
	$("#assessment").focus();
}

function loggingOut()
{
	// Clear Info, give logout message, pause, then go back to New Note page
	//Clear info
	$("#adminPage").hide();
	var oldTable = document.getElementById("#requestList");
	if(oldTable != null)
	{
		var rows = oldTable.rows;
		var i = rows.length;
		while(--i)
			oldTable.deleteRow(i); //technically clearing all but the first(header) row
	}
	
	//Message and Pause
	alert("Thanks for checking in!\r\nLogging out now...");
	
	//Go back to New Note page
	$("#requestNote").fadeIn(500);
	$("#date").focus();
}