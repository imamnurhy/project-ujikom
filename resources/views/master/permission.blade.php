@extends('layouts.app')

@section('title', 'Data Permission')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
    <div class="page has-sidebar-left bg-light">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row">
                    <div class="col">
                        <h3 class="my-2">
                            <i class="icon icon-clipboard-list2"></i> Data Permission
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
                                <table id="permission-table" class="table table-striped" style="width:100%"
                                    data-url="{{ route('api.permission') }}">
                                    <thead>
                                        <th width="30">No</th>
                                        <th>Nama</th>
                                        <th width="80">Guard Name</th>
                                        <th width="40"></th>
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
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

    <script type="text/javascript">
        var table = $('#permission-table').dataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: $('#permission-table').data('url'),
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
                    console.log('Opssss...');
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
                $('#alert').html('');
                $('#action').attr('disabled', true);

                var url = '';
                if ($('input[name=_method]').val() == 'POST') {
                    url = "{{ route('permission.store') }}";
                } else {
                    url = "{{ route('permission.update', ':id') }}".replace(':id', $('#id').val());
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#action').removeAttr('disabled');
                        $('#alert').html(
                            "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                            data.message + "</div>");

                        table.api().ajax.reload();

                        resetForm();

                    },
                    error: function(data) {
                        $('#action').removeAttr('disabled');
                        err = '';
                        respon = data.responseJSON;
                        $.each(respon.errors, function(index, value) {
                            err = err + "<li>" + value + "</li>";
                        });

                        $('#alert').html(
                            "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " +
                            respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    }
                });
                return false;
            }
            $(this).addClass('was-validated');
        });

        function resetForm() {
            $('#form').trigger('reset');
            $('#formTitle').html("Tambah");
            $('input[name=_method]').val('POST');
            $('#txtAction').html('');
            $('#btnReset').hide();
        }
    </script>
@endsection
