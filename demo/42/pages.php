<?php include 'lib/bootstrap.php'; ?>
<?php
$fields = array('title', 'description');
$fields_amount = count($fields) + 1;
?>

<h1>Administration - Pages</h1>
<div class="admin_pages">
    <table class="table table_size_<?= $fields_amount ?>" data-edit-table="pages">
        <?php
        echo '<thead><tr>';
        echo '<td>Page-Key</td>';
        foreach ($fields as $field) {
            echo '<td>' . $field . '</td>';
        }
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($CONFIGS_PAGES as $page_key => $page_config) {
            echo '<tr data-edit-index="' . $page_key . '">';
            echo '<td>' . $page_key . '</td>';
            foreach ($fields as $field) {
                echo '<td data-edit-field="' . $field . '">' . $page_config[$field] . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        ?>
    </table>
</div>

<?php include DIR_LIB . 'render.php'; ?>