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
	var oTarget = undefined;
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
	}).done(function (data, textStatus, jqXHR) {
		AjaxDialogHandler(oDialog, data, textStatus, jqXHR);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		AjaxDialogHandler(oDialog, textStatus + " " + errorThrown, textStatus, jqXHR);
	});
	return false;
}

function InitiateButtons(oContext) {
	oContext = setOrDefault(oContext, undefined);
	$(".confirm, .dialog", oContext).off("click");
	$(".confirm", oContext).click(function () {
		return confirm("Are you sure?");
	});

	$(".dialog", oContext).click(function () {
		loadDialog($(this).prop("href"));
		return false;
	});
	
	$(".ui-dialog form").submit(function () {
		var oDialog = $(this).closest(".ui-dialog-content").dialog();
		var sUrl = $(this).prop("action");
		var sMethod = $(this).prop("method");
		$.ajax({
			url: sUrl,
			type: sMethod,
			data: $(this).serialize()
		}).done(function (data, textStatus, jqXHR) {
			AjaxDialogHandler(oDialog, data, textStatus, jqXHR);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			AjaxDialogHandler(oDialog, textStatus + " " + errorThrown, textStatus, jqXHR);
		});
		return false;
	});
}

function AjaxDialogHandler (oDialog, data, textStatus, jqXHR) {
	var bRedirect = jqXHR.getResponseHeader("X-Action") == "redirect";
	if (bRedirect) {
		var sRedirect = jqXHR.getResponseHeader("X-Target");
		window.location = sRedirect;
		oDialog.dialog("close");
	} else {
		oDialog.html(data);
		oDialog.dialog("open");
	}
};