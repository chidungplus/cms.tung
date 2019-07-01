$(document).ready(function () {

    $('#customer_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/customer/get_list_customer',
            type: 'post'
        },
        searching: true,
        columns: [
            { data: 'DT_RowIndex', className: 'tx-center', searchable: false},
            { data: 'name'},
            { data: 'email'},
            { data: 'birthday', className: 'tx-center'},
            { data: 'gender', className: 'tx-center'},
            { data: 'type', className: 'tx-center'},
            { data: 'status', className: 'tx-center'},
            { data: 'action', className: 'tx-center'},
        ],
    });

    $('#frm_create_customer').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_create_customer');

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        createcustomer(form.serialize());
    });

    $('#frm_edit_customer').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_edit_customer');

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        updatecustomer(form.serialize());
    });

    $('#frm_create_customer').validate({
        errorElement: "span",
        rules: {
            name: {
                required: true
            },
            birthday: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true
            }
        },
        messages: {
            name: {
                required: Lang.get('user.please_enter_name')
            },
            birthday: {
                required: Lang.get('user.please_enter_birthday')
            },
            email: {
                required: Lang.get('user.please_enter_email'),
                email: Lang.get('user.email_not_invalid')
            },
            mobile: {
                required: Lang.get('user.please_enter_mobile')
            },
        },
    });

    $('#frm_edit_customer').validate({
        errorElement: "span",
        rules: {
            name: {
                required: true
            },
            birthday: {
                required: true
            },
            mobile: {
                required: true
            }
        },
        messages: {
            name: {
                required: Lang.get('customer.please_enter_name')
            },
            birthday: {
                required: Lang.get('customer.please_enter_birthday')
            },
            mobile: {
                required: Lang.get('customer.please_enter_mobile')
            },
        },
    });

    jQuery('#birthday').datetimepicker({
        datepicker:true,
        timepicker:false,
        format:'d/m/Y'
    });

    function createcustomer(data) {
        $.ajax({
            url: app_url + 'admin/customer',
            type: 'POST', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.href = app_url + 'admin/customer';
                    }, 2000);

                    $('#btn-create').attr("disabled", "disabled");
                } else {
                    if (res.type == 'email')
                    {
                        $('#email').parent().append('<span id="email-error" class="error">'+res.msg+'</span>');
                    } else {
                        toastr.error(res.msg);
                    }
                }
            }
        });
    }

    $('#customer_table').on('click', '.btn-edit', function () {
        window.location.href = app_url + 'admin/customer/' + $(this).data('id') + '/edit';
    });

    function updatecustomer(data) {

        $.ajax({
            url: app_url + 'admin/customer/' + $('#customer_id').val(),
            type: 'PATCH', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.href = app_url + 'admin/customer';
                    }, 2000);

                    $('#btn-update').attr("disabled", "disabled");
                }
            }
        });
    }

    $('#customer_table').on('click', '.btn-delete', function (event) {
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
                    url: app_url + 'admin/customer/' + $(this).data('id'),
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (res)
                    {
                        if (!res.err) {
                            toastr.success(res.msg);

                            $('#customer_table').DataTable().ajax.reload();
                        } else {
                            toastr.error(res.msg);
                        }
                    }
                });
            }
        });
    });

    $('#customer_table').on('click', '.btn-role', function () {
        window.location.href = app_url + 'admin/customer/role/' + $(this).data('id');
    });

    $('#role_customer_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/customer/get-list-role-customer',
            type: 'post',
            data: {
                customer_id: $('#customer_id').val()
            }
        },
        searching: true,
        columns: [
            { data: 'DT_Row_Index', className: 'tx-center'},
            { data: 'display_name'},
            { data: 'description', className: 'tx-center'},
            { data: 'created_at', className: 'tx-center'},
            { data: 'action', className: 'tx-center'},
        ],
    });

    $('#role_customer_table').on('click', '.btn-role-customer', function () {
        var role_id = $(this).data('id');
        var customer_id = $('#customer_id').val();
        var value = $(this).is(":checked") ? 1 : 0;

        $.ajax({
            url: app_url + '/admin/customer/update-role-customer',
            type: 'POST',// GET, POST, PUT, PATCH, DELETE,
            dataType: "JSON",
            data: {
                role_id: role_id,
                customer_id: customer_id,
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
    });
});
