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
	
	var fnHandler = GetAjaxResponseHandler(function(oTarget) {
		oTarget.dialog("open");
	});
	
	$.ajax({
		url: sUrl,
		method: "GET",
	}).done(function (data, textStatus, jqXHR) {
		fnHandler(oDialog, data, textStatus, jqXHR);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		fnHandler(oDialog, textStatus + " " + errorThrown, textStatus, jqXHR);
	});
	return false;
}

var oDialogSource = undefined;

function InitiateButtons(oContext) {
	oContext = setOrDefault(oContext, undefined);
	$(".confirm, .dialog", oContext).off("click");
	$(".confirm", oContext).click(function () {
		return confirm("Are you sure?");
	});

	$(".dialog", oContext).click(function () {
		loadDialog($(this).prop("href"));
		oDialogSource = $(this);
		return false;
	});
	
	
	$(".ui-dialog form").submit(function () {
		var fnHandler = GetAjaxResponseHandler(function(oTarget) {
			oTarget.dialog("open");
		});
		var oDialog = $(this).closest(".ui-dialog-content").dialog();
		var sUrl = $(this).prop("action");
		var sMethod = $(this).prop("method");
		$.ajax({
			url: sUrl,
			type: sMethod,
			data: $(this).serialize()
		}).done(function (data, textStatus, jqXHR) {
			fnHandler(oDialog, data, textStatus, jqXHR);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			fnHandler(oDialog, textStatus + " " + errorThrown, textStatus, jqXHR);
		});
		return false;
	});
	
	$(".widget form").submit(function () {
		var fnHandler = GetAjaxResponseHandler();
		var oWidget = $(this).closest(".widget");
		var sUrl = $(this).prop("action");
		var sMethod = $(this).prop("method");
		$.ajax({
			url: sUrl,
			type: sMethod,
			data: $(this).serialize()
		}).done(function (data, textStatus, jqXHR) {
			fnHandler(oWidget, data, textStatus, jqXHR);
		}).fail(function (jqXHR, textStatus, errorThrown) {
			fnHandler(oWidget, textStatus + " " + errorThrown, textStatus, jqXHR);
		});
		return false;
	})
}

function GetAjaxResponseHandler(fnNonRedirectExtra) {
	fnNonRedirectExtra = setOrDefault(fnNonRedirectExtra, function(){});
	var handler = function (oTarget, data, textStatus, jqXHR) {
		var sAction = jqXHR.getResponseHeader("X-Action");
		switch(sAction) {
			case "redirect": {
				var sRedirect = jqXHR.getResponseHeader("X-Target");
				window.location = sRedirect;
				break;
			}
			case "widget": {
				var fnHandler = GetAjaxResponseHandler();
				var oWidget = $(oDialogSource).closest(".widget");
				$.ajax({
					url: jqXHR.getResponseHeader("X-Target"),
					type: "GET",
				}).done(function (data, textStatus, jqXHR) {
					fnHandler(oWidget, data, textStatus, jqXHR);
				}).fail(function (jqXHR, textStatus, errorThrown) {
					fnHandler(oWidget, textStatus + " " + errorThrown, textStatus, jqXHR);
				});
				oTarget.dialog("close");
				break;
			}
			default: {
				oTarget.html(data);
				fnNonRedirectExtra(oTarget);
			}
		}
	};
	return handler;
}