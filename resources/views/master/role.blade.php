@extends('layouts.app')

@section('title', 'Data Role')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-fancybox.min.css') }}">

    <style>
        .fancybox-content {
            width: 700px;
            height: 350px;

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
                    <div class="col">
                        <h3 class="my-2">
                            <i class="icon icon-key4"></i> Data Role
                        </h3>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-fluid my-2">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6>
                                <strong>
                                    Tabel {{ $subTitle }}
                                </strong>
                            </h6>
                        </div>
                        <div class="card-body no-b">
                            <div class="table-responsive">
                                <table id="role-table" class="table table-striped" data-url="{{ route('api.role') }}"
                                    style="width:100%">
                                    <thead>
                                        <th width="30">No</th>
                                        <th>Nama</th>
                                        <th width="80">Guard Name</th>
                                        <th width="80">Permissions</th>
                                        <th width="60"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="alert"></div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h6>
                                        <strong>
                                            <span id="formTitle">Tambah </span> {{ $subTitle }}
                                        </strong>
                                    </h6>
                                </div>
                                <div class="col-md-2" style="display: none; " id="btnReset">
                                    <a href='#' onclick='resetForm()' class='btn btn-outline-primary btn-xs'>Batal</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" id="form" method="POST" novalidate>
                                @csrf
                                @method('POST')

                                <input type="hidden" id="id" name="id" />

                                <div class="form-row form-inline">
                                    <div class="col-md-12">
                                        <div class="form-group m-0">
                                            <label for="name" class="col-form-label s-12 col-md-4">Nama</label>
                                            <input type="text" name="name" id="name" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                                        </div>
                                        <div class="form-group m-0">
                                            <label for="guard_name" class="col-form-label s-12 col-md-4">Guard Name</label>
                                            <input type="text" name="guard_name" id="guard_name" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action">
                                        <i class="icon-save mr-2"></i>
                                        Simpan
                                        <span id="txtAction"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- START PERMISSION -->
        <div id="popup_permission" style="display: none">
            <div id="alert"></div>
            <div class="row">
                <div class="col-6">
                    <form class="needs-validation" id="form-permission" method="POST" novalidate>

                        @csrf
                        @method('POST')

                        <input type="hidden" name="id">
                        <div class="form-row form-inline">
                            <div class="col-md-12">
                                <div class="form-group m-0">
                                    <label for="permission" class="col-form-label s-12 col-md-3">Permission</label>
                                    <div class="col-md-9">
                                        <select name="permissions[]" id="permission" placeholder=""
                                            class="form-control r-0 light s-12" multiple="multiple" required>
                                            @foreach ($permissions as $key => $permission)
                                                <option value="{{ $permission->name }}">
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                <div class="col-6">
                    <strong>List Permission:</strong>
                    <ol id="viewPermission" class=""></ol>
                </div>
            </div>
        </div>
        <!-- END PERMISSION -->
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>

    <script type="text/javascript">
        var table = $('#role-table').dataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: $('#role-table').data('url'),
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'guard_name',
                    name: 'guard_name'
                },
                {
                    data: 'permissions',
                    name: 'permissions',
                    className: 'text-center'
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

        function edit(e) {
            $('#alert').html('');
            $('#form').trigger('reset');
            $('#formTitle').html("Mohon tunggu beberapa saat...");
            $('#txtAction').html(" Perubahan");
            $('#reset').hide();
            $('input[name=_method]').val('PATCH');
            $('#btnReset').show();
            $.ajax({
                url: $(e).data('url'),
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#formTitle').html("Edit");
                    $('#id').val(data.id);
                    $('#name').val(data.name).focus();
                    $('#guard_name').val(data.guard_name);
                },
                error: function() {
                    reload();
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
                    },
                    cancel: function() {
                        console.log('the user clicked cancel');
                    }
                }
            });
        }

        $('#form').on('submit', function(e) {
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                var self = this;
                $('#alert', self).html('');
                $('#action', self).attr('disabled', true);

                var url = '';
                if ($('input[name=_method]', self).val() == 'POST') {
                    url = "{{ route('role.store') }}";
                } else {
                    url = "{{ route('role.update', ':id') }}".replace(':id', $('#id').val());
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#action', self).removeAttr('disabled');
                        $('#alert').html(
                            "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                            data.message + "</div>");

                        table.api().ajax.reload();

                        resetForm(self);
                    },
                    error: function(data, textStatus, errorMessage) {
                        $('#action', self).removeAttr('disabled');
                        err = '';
                        if (data.status == 422) {
                            respon = data.responseJSON;
                            $.each(respon.errors, function(index, value) {
                                err = err + "<li>" + value + "</li>";
                            });
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

        function resetForm(thisForm) {
            $('#form').trigger('reset');
            $('#formTitle', thisForm).html("Tambah");
            $('input[name=_method]', thisForm).val('POST');
            $('#txtAction', thisForm).html('');
            $('#btnReset', thisForm).hide();
        }
    </script>

    <!-- PERMISSION -->
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#popup_permission select[id=permission]').select2({
                dropdownParent: $('#popup_permission')
            });
        });

        function showPopupPermission(id) {
            $.fancybox.open({
                src: '#popup_permission',
                type: 'inline',
                opts: {
                    afterShow: function(instance, current) {
                        getPermissions(id);
                        $('#form-permission input[name=id]').val(id);
                    }
                }
            });
        }

        function getPermissions(id) {
            $('#viewPermission').html("Loading...");
            urlPermission = "{{ route('role.getPermissions', ':id') }}".replace(':id', id);
            $.get(urlPermission, function(data) {
                $('#viewPermission').html("");
                if (data.length > 0) {
                    $.each(data, function(index, value) {
                        val = "'" + value.name + "'";
                        $('#viewPermission').append('<li>' + value.name +
                            ' <a href="#" onclick="removePermission(' + val +
                            ',' + id +
                            ')" class="text-danger" title="Hapus Data"><i class="icon-remove"></i></a></li>'
                        );
                    });
                } else {
                    $('#viewPermission').html("<em>Data role kosong.</em>");
                }
            });
        }

        $('#form-permission').on('submit', function(e) {
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                var self = this;
                $('#alert', self).html('');
                $('#action', self).attr('disabled', true);;

                $.ajax({
                    url: "{{ route('role.storePermissions') }}",
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#action', self).removeAttr('disabled');
                        $('#alert', self).html(
                            "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                            data.message + "</div>");

                        var inputId = $('input[name=id]', self).val();

                        table.api().ajax.reload();

                        getPermissions(inputId);

                        self.reset();
                    },
                    error: function(data, textStatus, errorMessage) {
                        $('#action', self).removeAttr('disabled');
                        err = '';
                        if (data.status == 422) {
                            respon = data.responseJSON;
                            $.each(respon.errors, function(index, value) {
                                err = err + "<li>" + value + "</li>";
                            });
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

        function removePermission(name, roleId) {
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
                                url: "{{ route('role.destroyPermission', ':name') }}".replace(':name',
                                    name),
                                type: "POST",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token,
                                    'id': roleId,
                                },
                                success: function(data) {
                                    getPermissions(roleId);
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
