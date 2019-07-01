$(document).ready(function () {

    $('#user_table').DataTable({
        autoWidth: true,
        processing: false,
        serverSide: false,
        ordering: false,
        ajax: {
            url: app_url + 'admin/user/get-list-user',
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
    
    $('#frm_create_user').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_create_user');

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        createUser(form.serialize());
    });

    $('#frm_edit_user').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_edit_user');

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        updateUser(form.serialize());
    });

    $('#frm_create_user').validate({
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

    $('#frm_edit_user').validate({
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
                required: Lang.get('user.please_enter_name')
            },
            birthday: {
                required: Lang.get('user.please_enter_birthday')
            },
            mobile: {
                required: Lang.get('user.please_enter_mobile')
            },
        },
    });

    jQuery('#birthday').datetimepicker({
        datepicker:true,
        timepicker:false,
        format:'d/m/Y'
    });

    function createUser(data) {
        $.ajax({
            url: app_url + 'admin/user',
            type: 'POST', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.href = app_url + 'admin/user';
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

    $('#user_table').on('click', '.btn-edit', function () {
        window.location.href = app_url + 'admin/user/' + $(this).data('id') + '/edit';
    });

    function updateUser(data) {

        $.ajax({
            url: app_url + 'admin/user/' + $('#user_id').val(),
            type: 'PATCH', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.href = app_url + 'admin/user';
                    }, 2000);

                    $('#btn-update').attr("disabled", "disabled");
                }
            }
        });
    }

    $('#user_table').on('click', '.btn-delete', function (event) {
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
                    url: app_url + 'admin/user/' + $(this).data('id'),
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (res)
                    {
                        if (!res.err) {
                            toastr.success(res.msg);

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);

                        } else {
                            toastr.error(res.msg);
                        }

                    }
                });
            }
        });
    });

    $('#user_table').on('click', '.btn-role', function () {
        window.location.href = app_url + 'admin/user/role/' + $(this).data('id');
    });

    $('#role_user_table').DataTable({
        autoWidth: true,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: app_url + 'admin/user/get-list-role-user',
            type: 'post',
            data: {
                user_id: $('#user_id').val()
            }
        },
        searching: true,
        columns: [
            { data: 'DT_RowIndex', className: 'tx-center'},
            { data: 'display_name'},
            { data: 'description', className: 'tx-center'},
            { data: 'created_at', className: 'tx-center'},
            { data: 'action', className: 'tx-center'},
        ],
    });

    $('#role_user_table').on('click', '.btn-role-user', function () {
        var role_id = $(this).data('id');
        var user_id = $('#user_id').val();
        var value = $(this).is(":checked") ? 1 : 0;

        $.ajax({
            url: app_url + 'admin/user/update-role-user',
            type: 'POST',// GET, POST, PUT, PATCH, DELETE,
            dataType: "JSON",
            data: {
                role_id: role_id,
                user_id: user_id,
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

    $('#frm_profile').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_profile');

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        updateProfile(form.serialize());
    });

    $('#frm_profile').validate({
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
                required: Lang.get('user.please_enter_name')
            },
            birthday: {
                required: Lang.get('user.please_enter_birthday')
            },
            mobile: {
                required: Lang.get('user.please_enter_mobile')
            },
        },
    });

    function updateProfile(data) {

        $.ajax({
            url: app_url + 'admin/user/profile',
            type: 'POST', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                    $('#btn-profile').attr("disabled", "disabled");
                } else {
                    toastr.error(res.msg);
                }
            }
        });
    }

    $('#frm_change_pw').on('submit', function (event) {
        event.preventDefault();

        var form = $('#frm_change_pw');
        var data = form.serialize();

        $('span[class=error]').remove();

        if (!form.valid()) {
            return false;
        }

        $.ajax({
            url: app_url + 'admin/user/changePassword',
            type: 'POST', // GET, POST, PUT, PATCH, DELETE,
            data: {
                data: data,
                user_id: $('#user_id').val()
            },
            success: function (res)
            {
                if (!res.err) {
                    toastr.success(res.msg);

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                } else {
                    toastr.error(res.msg);
                }
            }
        });
    });

    $('#frm_change_pw').validate({
        errorElement: "span",
        rules: {
            current_password: {
                required: true
            },
            password: {
                required: true
            },
            password_confirmation: {
                required: true
            }
        },
        messages: {
            current_password: {
                required: 'Vui lòng nhập mật khẩu hiện tại'
            },
            password: {
                required: 'Vui lòng nhập mật khẩu mới'
            },
            password_confirmation: {
                required: 'Vui lòng nhập mật khẩu xác nhận'
            },
        },
    });
});
