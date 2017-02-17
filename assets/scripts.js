$(function() {
	'use strict';

	function appointmentAction() {
		let $link = $(this),
			url = 'appointment.php',
			data = {
				'appt': $link.data('appt-ts'),
				'action': $link.data('action')
			},
			callback = (data) => {
				console.debug(data);
				let $link = $('li[data-appt-ts=' + data.appt + ']'),
					$cell = $link.closest('div.cell'),
					appts;
				$link.data('action', data.action === 'add' ? 'remove' : 'add');
				$link.toggleClass('appt-add appt-remove');

				// check cell for appointments and toggle highlight if necessary
				appts = $cell.find('li.appt-remove').length;
				if (appts > 0) {
					$cell.addClass('has-appt');
				} else {
					$cell.removeClass('has-appt');
				}
			};
		$.post(url, data)
			.done(callback)
			.fail(function(xhr, status, err) {
				alert('Houston we have a problem... :(');
				console.error(err);
			});
	}

	$('li.appt-link').on('click', appointmentAction);
})
