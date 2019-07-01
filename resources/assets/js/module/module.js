$(document).ready(function () {

    $('#modules_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/module/get-list',
            type: 'post'
        },
        searching: true,
        columns: [
            {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
            {data: 'display_name'},
            {data: 'module_category_name', searchable: false, className: 'tx-center'},
            {data: 'note'},
            {data: 'status', className: 'tx-center'},
            {data: 'created_at', className: 'tx-center'},
            {data: 'action', className: 'tx-center'},
        ],
    });

    $('#modules_table').on('click', '.btn-warning', function () {
        window.location.href = app_url + 'admin/module/' + $(this).data('id') + '/edit';
    });

    $('#modules_table').on('click', '.btn-danger', function (event) {
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
                    url: app_url + 'admin/module/' + $(this).data('id'),
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (res) {
                        if (!res.err) {
                            toastr.error(Lang.get('global.delete_success'));

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            }
        });
    });
});
