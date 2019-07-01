$(document).ready(function () {

    $('#permission_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/permission/get-list-permission',
            type: 'post'
        },
        searching: true,
        columns: [
            {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
            {data: 'name'},
            {data: 'display_name'},
            {data: 'created_at', className: 'tx-center'},
            // {data: 'action', className: 'tx-center'},
        ],
    });
});
