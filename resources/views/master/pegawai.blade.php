@extends('layouts.app')

@section('title', 'Master Pegawai')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-fancybox.min.css') }}">

    <style>
        .fancybox-content {
            width: 790px;
            height: 500px;

            /* Buat boder radius */
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="page has-sidebar-left bg-light">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row">
                    <ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
                        <li>
                            <a class="nav-link" href="javascript:;" onclick="add()">
                                <i class="icon icon-plus"></i>
                                Tambah Pegawai
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- START PAGE CONTENT -->
        <div class="container-fluid my-2 animatedParent animateOnce">
            <div class="row animated fadeInUpShort">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <h6>
                                <strong>
                                    Tabel {{ $subTitle }}
                                </strong>
                            </h6>
                        </div>
                        <div class="card-body no-b p-3">
                            <div class="table-responsive">
                                <table class="table table-striped" id="pegawai-table" data-url="{{ route('pegawai.api') }}"
                                    style="width:100%">
                                    <thead>
                                        <th width="30">No</th>
                                        <th>Nama</th>
                                        <th>No telp</th>
                                        <th>Email</th>
                                        <th width="120">Pengguna APP</th>
                                        <th width="40"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->

        <!-- START FORM PEGAWAI -->
        <div id='popup_pegawai' style="display: none">
            <div class="form-row">
                <div class="col-md-12">
                    <h4>
                        <span id="formTitle">Tambah </span> {{ $subTitle }}
                    </h4>
                    <form class="needs-validation" id="form-pegawai" method="POST" novalidate>

                        @csrf
                        @method('POST')

                        <div id="alert"></div>

                        <input type="hidden" name="id">

                        <div class="form-group m-1">
                            <label for="n_pegawai" class="col-form-label s-12">
                                Nama
                            </label>
                            <input type="text" name="n_pegawai" class="form-control" autocomplete="off" required />
                        </div>

                        <div class="form-group m-1">
                            <label for="telp" class="col-form-label s-12">
                                No Hp
                            </label>
                            <input type="text" name="telp" class="form-control" autocomplete="off" required />
                        </div>

                        <div class="form-group m-1">
                            <label for="email" class="col-form-label s-12">
                                Email
                            </label>
                            <input type="email" name="email" class="form-control" autocomplete="off" required />
                        </div>

                        <div class="float-right mt-1">
                            <button type="submit" class="btn btn-primary btn-lg m-2" id="action">
                                <i class="icon-save mr-2"></i>
                                Simpan
                                <span id="textAction"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END FORM PEGAWAI -->

        <!-- START EDIT USER -->
        <div id="popup_user" style="display: none;">
            <h4>
                <span>Edit User</span>
            </h4>
            <div class="row m-0">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active show" id="v-status-tab" data-toggle="pill" href="#v-status" role="tab"
                            aria-controls="v-status" aria-selected="true">
                            Status
                        </a>
                        <a class="nav-link" id="v-username-tab" data-toggle="pill" href="#v-username" role="tab"
                            aria-controls="v-username" aria-selected="true">
                            Username
                        </a>
                        <a class="nav-link" id="v-password-tab" data-toggle="pill" href="#v-password" role="tab"
                            aria-controls="v-password" aria-selected="false">
                            Password
                        </a>
                        <a class="nav-link" id="v-pills-roles-tab" data-toggle="pill" href="#v-pills-roles" role="tab"
                            aria-controls="v-pills-roles" aria-selected="false">
                            List Role
                        </a>
                        <a class="btn btn-danger mt-2" id="hapus_user">
                            Hapus User
                        </a>
                    </div>
                </div>

                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade active show" id="v-status" role="tabpanel"
                            aria-labelledby="status-tab">
                            <form class="needs-validation" id="form1" method="POST" novalidate>
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="type" value="1" />
                                <input type="hidden" name="id" />

                                <ul class="list-group no-b">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="s-12">Status User</strong>
                                        <div class="material-switch">
                                            <input name="status" type="checkbox" id="status" />
                                            <label for="status" class="bg-primary"></label>
                                        </div>
                                    </li>
                                </ul>

                                <div class="float-right mt-1">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action">
                                        <i class="icon-save mr-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="v-username" role="tabpanel" aria-labelledby="username-tab">
                            <form class="needs-validation" id="form2" method="POST" novalidate>
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="type" value="2" />
                                <input type="hidden" name="id" />

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group m-1">
                                            <label for="username" class="col-form-label s-12">Username</label>
                                            <input type="text" name="username" id="username" placeholder=""
                                                class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right mt-1">
                                    <button type="submit"class="btn btn-primary btn-sm" id="action">
                                        <i class="icon-save mr-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="v-password" role="tabpanel" aria-labelledby="v-password-tab">
                            <form class="needs-validation" id="form3" method="POST" novalidate>
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="type" value="3" />
                                <input type="hidden" name="id" />

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group m-1">
                                            <label for="password" class="col-form-label s-12">Password</label>
                                            <input type="password" name="password" id="password" placeholder=""
                                                class="form-control " required />
                                        </div>
                                        <div class="form-group m-1">
                                            <label for="password_confirmation" class="col-form-label s-12">Ulangi
                                                Password</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" placeholder="" class="form-control" required
                                                data-match="#password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right mt-1">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action">
                                        <i class="icon-save mr-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="v-pills-roles" role="tabpanel"
                            aria-labelledby="v-pills-roles-tab">
                            <div class="row m-0">
                                <div class="col-8">
                                    <form class="needs-validation" id="form4" method="POST" novalidate>
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="type" value="4" />
                                        <input type="hidden" name="id" />

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group m-1">
                                                    <label for="role" class="col-form-label s-12">Role</label>
                                                    <select name="roles[]" id="role" placeholder=""
                                                        class="form-control" multiple="multiple" required>
                                                        <option value="">Pilih</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right mt-1">
                                            <button type="submit" class="btn btn-primary btn-sm" id="action">
                                                <i class="icon-save mr-2"></i>
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-4">
                                    <strong>List Role:</strong>
                                    <ol id="viewRole" class=""></ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EDIT USER -->
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#form4 select[id=role]').select2({
                dropdownParent: $('#popup_user')
            });
        });

        var table = $('#pegawai-table').dataTable({
            processing: true,
            serverSide: true,
            order: [2, 'asc'],
            ajax: $('#pegawai-table').data('url'),
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'n_pegawai',
                    name: 'n_pegawai'
                },
                {
                    data: 'telp',
                    name: 'telp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ]
        });

        $('#form-pegawai').on('submit', function(e) {
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                var self = this;
                var inputId = $('input[name=id]', self).val();

                $('#alert', self).html('');
                $('#action', self).attr('disabled', true);

                var url = '';

                if ($('input[name=_method]', self).val() == 'POST') {
                    url = "{{ route($route . 'store') }}";
                } else {
                    url = "{{ route($route . 'update', ':id') }}".replace(':id', inputId);
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#action', self).removeAttr('disabled');
                        $('#alert', self).html(
                            "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                            data + "</div>");

                        table.api().ajax.reload();

                        $.fancybox.close();

                        self.reset();
                    },
                    error: function(data, textStatus, errorMessage) {
                        $('#action', self).removeAttr('disabled');
                        var err = '';
                        if (data.status == 422) {
                            var respon = data.responseJSON;
                            $.each(respon.errors, function(index, value) {
                                err = err + "<li>" + value + "</li>";
                            });
                        } else {
                            err = "<li>" + data.responseText + "</li>";
                        }
                        $('#alert', self).html(
                            "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>" +
                            textStatus.toUpperCase() + " : </strong> " + errorMessage +
                            "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    }
                });
                return false;
            }
            $(this).addClass('was-validated');
        });

        function add() {
            $('#popup_pegawai #alert').html('');
            $('#popup_pegawai #formTitle').html("Tambah");
            $('#popup_pegawai #textAction').html("");
            $('#popup_pegawai input[name=_method]').val('POST');

            $.fancybox.open({
                src: '#popup_pegawai',
                type: 'inline',
                opts: {
                    beforeShow: function(instance, current) {
                        $('#form-pegawai')[0].reset();
                    }
                }
            });
        }

        function edit(e) {
            $('#popup_pegawai #alert').html('');
            $('#popup_pegawai #formTitle').html("Edit");
            $('#popup_pegawai #textAction').html(" Perubahan");
            $('#popup_pegawai input[name=_method]').val('PATCH');

            $.fancybox.open({
                src: '#popup_pegawai',
                type: 'inline',
                opts: {
                    afterShow: function(instance, current) {
                        $.ajax({
                            url: $(e).data('url'),
                            type: "GET",
                            dataType: "JSON",
                            success: function(data) {
                                $('input[name=id]').val(data.id);
                                $('input[name=n_pegawai]').val(data.n_pegawai);
                                $('input[name=telp]').val(data.telp);
                                $('input[name=email]').val(data.email);
                            },
                            error: function() {
                                console.log('Opssss...');
                                reload();
                            }
                        })
                    }
                }
            });
        }

        function remove(e) {
            $.confirm({
                title: '',
                content: 'Apakah Anda yakin akan menghapus data ini?',
                icon: 'icon icon-question amber-text',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    ok: {
                        text: "ok!",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function() {
                            var csrf_token = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: $(e).data('url'),
                                type: "POST",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token
                                },
                                success: function(data) {
                                    table.api().ajax.reload();
                                },
                                error: function() {
                                    console.log('Opssss...');
                                    reload();
                                }
                            });
                        }
                    }
                }
            });
        }
    </script>

    <!-- USER -->
    <script type="text/javascript">
        function showPopupUser(e) {
            $.fancybox.open({
                src: '#popup_user',
                type: 'inline',
                opts: {
                    afterShow: function(instance, current) {
                        $.ajax({
                            url: $(e).data('url'),
                            type: "GET",
                            dataType: "JSON",
                            success: function(data) {
                                $('#popup_user input[name=id]').val(data.user.id);
                                $('#popup_user input[name=status]').attr('checked', data
                                    .user.status);
                                $('#popup_user input[name=username]').val(data
                                    .user.username);

                                $('#popup_user select[id=role]').empty();
                                $.each(data.roles, function(index, value) {
                                    $('#popup_user select[id=role]').append(
                                        '<option value="' + value.id +
                                        '">' + value.name +
                                        '</option>');
                                });

                                getRoles(data.user.id);

                                $('#popup_user a[id=hapus_user]').attr('onclick', 'removeUser(' +
                                    data.user.id + ')');

                            },
                            error: function() {
                                console.log('Opssss...');
                                reload();
                            }
                        })
                    }
                }
            });
        }

        function getRoles(userId) {
            $('#popup_user #viewRole').html("Loading...");
            url = "{{ route('user.getRoles', ':id') }}".replace(':id', userId);
            $.get(url, function(data) {
                $('#popup_user #viewRole').html("");
                if (data.length > 0) {
                    $.each(data, function(index, value) {
                        val = "'" + value + "'";
                        $('#popup_user #viewRole').append('<li>' + value +
                            ' <a href="#" onclick="removeRole(' + val +
                            ',' + userId +
                            ')" class="text-danger" title="Hapus Data"><i class="icon-remove"></i></a></li>'
                        );
                    });
                } else {
                    $('#popup_user #viewRole').html("<em>Data role kosong.</em>");
                }
            });
        }

        function addUser(id) {
            $.ajax({
                url: "{{ route('user.add_user', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $.fancybox.open({
                        src: '#popup_user',
                        type: 'inline',
                        opts: {
                            afterShow: function(instance, current) {
                                $.ajax({
                                    url: "{{ route('user.edit', ':id') }}".replace(':id',
                                        data.id),
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function(data) {
                                        $('#popup_user input[name=id]').val(data.user
                                            .id);
                                        $('#popup_user input[name=status]').attr(
                                            'checked', data
                                            .user.status);
                                        $('#popup_user input[name=username]').val(data
                                            .user.username);

                                        $('#popup_user select[id=role]').empty();
                                        $.each(data.roles, function(index, value) {
                                            $('#popup_user select[id=role]')
                                                .append(
                                                    '<option value="' + value
                                                    .id +
                                                    '">' + value.name +
                                                    '</option>');
                                        });

                                        getRoles(data.user.id);

                                        $('#popup_user a[id=hapus_user]').attr(
                                            'onclick', 'removeUser(' +
                                            data.user.id + ')');

                                        table.api().ajax.reload();
                                    },
                                    error: function() {
                                        console.log('Opssss...');
                                        reload();
                                    }
                                })
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', status, error);
                }
            });
        }

        $('#form1,#form2,#form3,#form4').on('submit', function(e) {
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                var self = this;
                var inputId = $('input[name=id]', self).val();

                $('#alert', self).html('');
                $('#action', self).attr('disabled', true);

                $.ajax({
                    url: "{{ route('user.update', ':id') }}".replace(':id', inputId),
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#action', self).removeAttr('disabled');
                        $('#alert', self).html(
                            "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                            data + "</div>");

                        table.api().ajax.reload();

                        if ($('input[name=type]', self).val() == 4) {
                            getRoles(inputId);
                        } else {
                            $.fancybox.close();
                        }

                        self.reset();
                    },
                    error: function(data, textStatus, errorMessage) {
                        $('#action', self).removeAttr('disabled');
                        var err = '';
                        if (data.status == 422) {
                            var respon = data.responseJSON;
                            $.each(respon.errors, function(index, value) {
                                err = err + "<li>" + value + "</li>";
                            });
                        } else {
                            err = "<li>" + data.responseText + "</li>";
                        }
                        $('#alert', self).html(
                            "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>" +
                            textStatus.toUpperCase() + " : </strong> " + errorMessage +
                            "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    }
                });
                return false;
            }
            $(this).addClass('was-validated');
        });

        function removeRole(name, userId) {
            $.confirm({
                title: '',
                content: 'Apakah Anda yakin akan menghapus role ini?',
                icon: 'icon icon-question amber-text',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    ok: {
                        text: "ok!",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function() {
                            var csrf_token = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: "{{ route('user.destroyRole', ':name') }}".replace(':name', name),
                                type: "POST",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token,
                                    'id': userId
                                },
                                success: function(data) {
                                    getRoles(userId);
                                },
                                error: function() {
                                    console.log('Opssss...');
                                    reload();
                                }
                            });
                        }
                    }
                }
            });
        }

        function removeUser(id) {
            $.confirm({
                title: '',
                content: 'Apakah Anda yakin akan menghapus user ini?',
                icon: 'icon icon-question amber-text',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    ok: {
                        text: "ok!",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function() {
                            var csrf_token = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: "{{ route('user.destroy', ':id') }}".replace(':id', id),
                                type: "POST",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token
                                },
                                success: function(data) {
                                    $.fancybox.close();
                                    table.api().ajax.reload();
                                },
                                error: function() {
                                    console.log('Opssss...');
                                    reload();
                                }
                            });
                        }
                    },
                    cancel: function() {
                        console.log('the user clicked cancel');
                    }
                }
            });
        }
    </script>
@endsection
