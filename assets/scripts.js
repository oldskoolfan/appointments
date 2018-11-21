(function () {
    const callback = (data) => {
        if (data.status === 'error') throw new Error(data['error_msg']);

        const link = document.querySelector(`li[data-appt-ts="${data.appt}"]`);
        const cell = link.closest('div.cell');
        
        link.dataset.action = data.action === 'add' ? 'remove' : 'add';
        link.classList.toggle('appt-add');
        link.classList.toggle('appt-remove');

        cell.classList.toggle('has-appt', cell.querySelectorAll('li.appt-remove').length);
    };

    const apptAction = function() {
        const url = 'appointment.php';
        const data = new FormData();
        data.append('appt', this.dataset.apptTs);
        data.append('action', this.dataset.action);

        fetch(url, {
            method: 'POST',
            body: data,
        }).then(resp => resp.json())
        .then(callback)
        .catch(err => {
            console.error(err);
            alert('Houston we have a problem... :(');
        });
    };

    document.querySelectorAll('li.appt-link').forEach(el => {
        el.addEventListener('click', apptAction);
    });
})();