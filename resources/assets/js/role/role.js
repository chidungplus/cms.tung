$(document).ready(function () {

    $('#role_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/role/get-list-role',
            type: 'post'
        },
        searching: true,
        columns: [
            {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
            {data: 'display_name'},
            {data: 'description'},
            {data: 'created_at', className: 'tx-center'},
            {data: 'action', className: 'tx-center'},
        ],
    });
    
    $('#role_table').on('click', '.btn-edit', function () {
       window.location.href = app_url + 'admin/role/' + $(this).data('id') + '/edit';
    });

    $('#role_table').on('click', '.btn-permission', function () {
        window.location.href = app_url + 'admin/role/permission/' + $(this).data('id');
    });

    $('#role_table').on('click', '.btn-delete', function (event) {
        event.preventDefault();

        swal({
            title: Lang.get('global.are_you_sure_to_delete'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00b297',
            cancelButtonColor: '#d33',
            confirmButtonText: Lang.get('global.confirm'),
            cancelButtonText: Lang.get('global.cancle')
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    url: app_url + 'admin/role/' + $(this).data('id'),
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (res) {
                        // console.log(res);
                        if (!res.err) {
                            toastr.success(res.msg);

                            $('#role_table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    });

    $('#permission_role_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/role/get-list-permission',
            type: 'post',
            data: {
                id: $('#role_id').val()
            }
        },
        searching: true,
        columns: [
            {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
            {data: 'name'},
            {data: 'display_name'},
            {data: 'created_at', className: 'tx-center'},
            {data: 'action', className: 'tx-center'},
        ],
    });
    
    $('#permission_role_table').on('click', '.btn-permission-role', function () {
        var permission_id = $(this).data('id');
        var role_id = $('#role_id').val();
        var value = $(this).is(":checked") ? 1 : 0;

        $.ajax({
            url: app_url + 'admin/role/update-permission-role',
            type: 'POST',// GET, POST, PUT, PATCH, DELETE,
            dataType: "JSON",
            data: {
                role_id: role_id,
                permission_id: permission_id,
                value: value
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);
                } else {
                    toastr.err(res.msg);
                }
            }
        });
    })
});
