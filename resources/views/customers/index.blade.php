@extends('layouts.master')


@section('top')
    <!-- DataTables --><!-- Log on to codeastro.com for more projects! -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">--}}
    @include('sweet::alert')
    <style>
        body { background: #f4f6fa; }
        .customers-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            background: #fff;
            padding: 30px 20px 20px 20px;
            margin-top: 30px;
        }
        .customers-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .customers-header h3 {
            margin: 0;
            font-weight: 700;
            color: #2a2a2a;
        }
        .customers-actions {
            display: flex;
            gap: 10px;
        }
        .btn-add {
            background: linear-gradient(90deg, #00c6ff 0%, #0072ff 100%);
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 6px;
        }
        .btn-export {
            background: linear-gradient(90deg, #ff416c 0%, #ff4b2b 100%);
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 6px;
        }
        .dataTables_filter input {
            border-radius: 6px;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
            background: #f9fafb;
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f6f8fa;
        }
        .table-hover tbody tr:hover {
            background-color: #eaf1fb;
        }
        .modal-content {
            border-radius: 14px;
        }
        .modal-header {
            border-radius: 14px 14px 0 0;
            background: #00b09b;
            color: #fff;
        }
        .modal-title {
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="customers-card">
        <div class="customers-header">
            <h3 class="box-title">List of Customers</h3>
            <div class="customers-actions">
                <a onclick="addForm()" class="btn btn-add"><i class="fa fa-plus"></i> Add New Customer</a>
                <a onclick="showArchived()" class="btn btn-archive"><i class="fa fa-archive"></i> Archived Customers</a>
                <a href="{{ route('exportPDF.customersAll') }}" class="btn btn-export"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
            </div>
        </div>
        <div class="box-body">
            <table id="customer-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('customers.form_import')

    @include('customers.form')

    <!-- Archived Customers Modal -->
    <div class="modal fade" id="archived-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Archived Customers</h3>
                </div>
                <div class="modal-body">
                    <table id="archived-customers-table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>--}}

    {{--<script>--}}
    {{--$(function () {--}}
    {{--$('#items-table').DataTable()--}}
    {{--$('#example2').DataTable({--}}
    {{--'paging'      : true,--}}
    {{--'lengthChange': false,--}}
    {{--'searching'   : false,--}}
    {{--'ordering'    : true,--}}
    {{--'info'        : true,--}}
    {{--'autoWidth'   : false--}}
    {{--})--}}
    {{--})--}}
    {{--</script>--}}

    <script type="text/javascript">
        var table = $('#customer-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.customers') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var archivedTable;
        function showArchived() {
            $('#archived-modal').modal('show');
            if (!archivedTable) {
                archivedTable = $('#archived-customers-table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('api/archived-customers') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'address', name: 'address'},
                        {data: 'email', name: 'email'},
                        {data: 'phone', name: 'phone'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            } else {
                archivedTable.ajax.reload();
            }
        }

        function archiveData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "This customer will be archived!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('customers') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        function unarchiveData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "This customer will be restored!",
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, unarchive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('customers/unarchive') }}/" + id,
                    type : "POST",
                    data : {'_token' : csrf_token},
                    success : function(data) {
                        archivedTable.ajax.reload();
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Customers');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('customers') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Customers');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('customers') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('customers') }}";
                    else url = "{{ url('customers') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>

@endsection
