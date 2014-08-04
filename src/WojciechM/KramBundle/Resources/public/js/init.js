$(function() {
	
	function InitiateButtons(oContext)
	{
		oContext = setOrDefault(oContext, undefined)
//		$(".button", oContext).button({
//
//		});
		$(".confirm", oContext).click(function () {
			return confirm("Are you sure?");
		});

		$(".dialog", oContext).click(function () {
			loadDialog($(this).prop("href"));
			return false;
		});
	}
	
	InitiateButtons();
});