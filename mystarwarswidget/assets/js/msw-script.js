jQuery(document).ready(function($) {
	console.log("Hello from msw-script.js!");
});

function msw_get_people() {
	var $ = jQuery;

	$.post(msw_script_obj.ajax_url, {
		action: 'msw_get_people',
	})
	.done(function(data) {
		$('.msw_people').html(data);
	})
	.fail(function(error) {
		console.error("msw_get_people error", error);
	});
}
