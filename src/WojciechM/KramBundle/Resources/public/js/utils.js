function setOrDefault(oValue, oDefault) {
	return oValue === undefined ? oDefault : oValue;
}

function DialogConfirm(sTarget, fnTrue, fnFalse) {
	sTarget = setOrDefault(sTarget, "#dialog-confirm");
	fnTrue = setOrDefault(fnTrue, function() {
		alert("True");
	});
	fnFalse = setOrDefault(fnFalse, function() {
	});
	$(sTarget).dialog({
		resizable : false,
		height : 140,
		modal : true,
		buttons : {
			"Yes" : function() {
				fnTrue();
				$(this).dialog("close");
			},
			"No" : function() {
				fnFalse();
				$(this).dialog("close");
			}
		}
	});
}

function loadDialog(sUrl, sTarget) {
	var oTarget = undefined
	if (sTarget === undefined) {
		sTarget = "default-dialog-target";
		oTarget = $("#"+sTarget);
		if (oTarget.length == 0) {
			oTarget = $("<div></div>");
			$("body").append(oTarget);
			oTarget.prop("id", sTarget);
		}
	} else {
		oTarget = $(sTarget);
	}
	
	var oDialog = oTarget.dialog({
		resizable : false,
		width:'auto',
		height:'auto',
		autoOpen: false,
		modal:true,
	});
	
	oDialog.dialog("close");
	
	$.ajax({
		url: sUrl,
		method: "GET",
		success: function(data) {
			oTarget.html(data);
			oTarget.dialog("open");
		}
	});
}

function DialogForm(oOptions) {
	oOptions = setOrDefault(oOptions, {});
	sTarget = setOrDefault(oOptions.sTarget, "#dialog-form");
	sActio = setOrDefault(oOptions.sTarget, "#dialog-form");
	
	fnTrue = setOrDefault(fnTrue, function() {
		alert("True");
	});
	fnFalse = setOrDefault(fnFalse, function() {
	});
	$(sTarget).dialog({
		resizable : false,
		height : 140,
		modal : true,
		buttons : {
			"Yes" : function() {
				fnTrue();
				$(this).dialog("close");
			},
			"No" : function() {
				fnFalse();
				$(this).dialog("close");
			}
		}
	});
}
