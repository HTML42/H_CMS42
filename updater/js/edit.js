setTimeout(function () {
    $('[data-edit-table]').each(function () {
        var $table = $(this);
        var $tbody = $table.find('tbody');
        var table = $table.data('edit-table');
        //
        var keys = [];
        $table.find('[data-edit-index]:first() td').each(function () {
            keys.push($(this).attr('data-edit-field') ? $(this).data('edit-field') : '##' + keys.length);
        });
        //
        $table.find('[data-edit-index]').each(function () {
            var $row = $(this);
            var index = $row.data('edit-index');
            $row.find('[data-edit-field]').each(function () {
                var $field = $(this);
                var field_key = $field.data('edit-field');
            });
        });
        //
        var $button_add = $('<button>Add Row</button>');
        var $tfoot = $('<tfoot><tr><td colspan="' + keys.length + '"></td></tr></tfoot>');
        $tfoot.find('td').html($button_add);
        $table.append($tfoot);
        //
        var row_counter = 0;
        $button_add.click(function () {
            var $tr = $('<tr />');
            $(keys).each(function (key) {
                $tr.append('<td><input type="text" name="' + table + '[' + row_counter + '][' + key + ']" /></td>');
            });
            $tbody.append($tr);
            row_counter++;
        });
    });
}, 150);
