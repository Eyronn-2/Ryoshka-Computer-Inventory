@extends('layouts.master')

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <style>
        body { background: #f4f6fa; }
        .purchase-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            background: #fff;
            padding: 30px 20px 20px 20px;
            margin-top: 30px;
        }
        .purchase-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .purchase-header h3 {
            margin: 0;
            font-weight: 700;
            color: #2a2a2a;
        }
        .purchase-actions {
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
    <div class="purchase-card">
        <div class="purchase-header">
            <h3 class="box-title">Purchase Products List</h3>
            <div class="purchase-actions">
                <a onclick="addForm()" class="btn btn-add"><i class="fa fa-plus"></i> Add New Purchase</a>
                <a onclick="showArchived()" class="btn btn-archive"><i class="fa fa-archive"></i> Archived Purchases</a>
                <a href="{{ route('exportPDF.productInAll') }}" class="btn btn-export"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
            </div>
        </div>
        <div class="box-body">
            <table id="products-in-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Products</th>
                    <th>Supplier</th>
                    <th>Qty.</th>
                    <th>In Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="purchase-card mt-4">
        <div class="purchase-header">
            <h3 class="box-title">Export Invoice</h3>
        </div>
        <div class="box-body">
            <table id="invoice" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Products</th>
                    <th>Supplier</th>
                    <th>Qty.</th>
                    <th>In Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice_data as $i)
                    <tr>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->product->name }}</td>
                        <td>{{ $i->supplier->name }}</td>
                        <td>{{ $i->quantity }}</td>
                        <td>{{ $i->date }}</td>
                        <td>
                            <a href="{{ route('exportPDF.productIn', [ 'id' => $i->id ]) }}" class="btn btn-sm btn-danger">Export Invoice</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('product_in.form')
    <!-- Archived Products In Modal -->
    <div class="modal fade" id="archived-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Archived Purchases</h3>
                </div>
                <div class="modal-body">
                    <table id="archived-products-in-table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Products</th>
                            <th>Supplier</th>
                            <th>Qty.</th>
                            <th>In Date</th>
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


    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    <script>
    $(function () {
    // $('#items-table').DataTable()
    $('#invoice').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
    'processing'  : true,
    'pageLength'  : 10
    })
    })
    </script>

    <script>
        $(function () {

            //Date picker
            $('#date').datepicker({
                autoclose: true,
                // dateFormat: 'yyyy-mm-dd'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>

    <script type="text/javascript">
        var table = $('#products-in-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.productsIn') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'products_name', name: 'products_name'},
                {data: 'supplier_name', name: 'supplier_name'},
                {data: 'quantity', name: 'quantity'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var archivedTable;
        function showArchived() {
            $('#archived-modal').modal('show');
            if (!archivedTable) {
                archivedTable = $('#archived-products-in-table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('api/archived-products-in') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'products_name', name: 'products_name'},
                        {data: 'supplier_name', name: 'supplier_name'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'date', name: 'date'},
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
                text: "This purchase will be archived!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('productsIn') }}" + '/' + id,
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
                text: "This purchase will be restored!",
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, unarchive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('productsIn/unarchive') }}/" + id,
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
            $('.modal-title').text('Add New Purchase');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('productsIn') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Products In');

                    $('#id').val(data.id);
                    $('#product_id').val(data.product_id);
                    $('#supplier_id').val(data.supplier_id);
                    $('#quantity').val(data.quantity);
                    $('#date').val(data.date);
                },
                error : function() {
                    swal({
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        type: 'error',
                        timer: '1500'
                    });
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
                    url : "{{ url('productsIn') }}" + '/' + id,
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
                    if (save_method == 'add') url = "{{ url('productsIn') }}";
                    else url = "{{ url('productsIn') . '/' }}" + id;

                    // Clear previous errors
                    $('.form-group').removeClass('has-error');
                    $('.help-block.with-errors').text('');

                    $.ajax({
                        url : url,
                        type : "POST",
                        data : $('#modal-form form').serialize(),
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
                        error : function(xhr){
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $('#' + key).closest('.form-group').addClass('has-error');
                                    $('#' + key).closest('.form-group').find('.help-block').text(value[0]);
                                });
                            } else {
                                swal({
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    type: 'error',
                                    timer: '1500'
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>

@endsection
