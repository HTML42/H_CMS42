setTimeout(function () {
    c42('Admin-Area');

    $('.update_trigger').click(function() {
        $.get('ajax/update.php', function(response) {
            c42('UPDATE:', response);
        });
    });
}, 1);
