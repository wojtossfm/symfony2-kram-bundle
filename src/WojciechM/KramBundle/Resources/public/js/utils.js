function setOrDefault(oValue, oDefault)
{
	return oValue === undefined ? oDefault : oValue;
}

function DialogConfirm(sTarget, fnTrue, fnFalse)
{
	var sTarget = setOrDefault(sTarget, "#dialog-confirm");
	var fnTrue = setOrDefault(fnTrue, function() {
		alert("True");
	});
	var fnFalse = setOrDefault(fnFalse, function() {
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
