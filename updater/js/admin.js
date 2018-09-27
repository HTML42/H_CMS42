setTimeout(function () {
    c42('Admin-Area');

    $('.update_trigger').click(function() {
        $.get('ajax/update.php', function(response) {
            response = $.trim(response);
            if(response === '1') {
                alert('Successfully updated from repository.');
                location.reload(true);
            } else if(response === '2') {
                alert('Successfully updated from internal.');
                location.reload(true);
            } else {
                alert('Update failed.');
            }
        });
    });

    $('.missing_trigger').click(function() {
        $.get('ajax/create_missing.php', function(response) {
            response = $.trim(response);
            if(response === '1') {
                alert('Successfully created missing.');
                location.reload(true);
            } else {
                alert('Update failed.');
            }
        });
    });
}, 1);
