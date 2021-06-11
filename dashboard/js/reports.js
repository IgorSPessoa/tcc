$(document).ready( function () {
    $('#table_id').DataTable();
    $('#table_idsnd').DataTable({
        "order": [[ 3, "desc" ]]
    } );
});
