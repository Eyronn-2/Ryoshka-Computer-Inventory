@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Log on to codeastro.com for more projects! -->
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <style>
        body { background: #f4f6fa; }
        .outgoing-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            background: #fff;
            padding: 30px 20px 20px 20px;
            margin-top: 30px;
        }
        .outgoing-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .outgoing-header h3 {
            margin: 0;
            font-weight: 700;
            color: #2a2a2a;
        }
        .outgoing-actions {
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
            background: #0072ff;
            color: #fff;
        }
        .modal-title {
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="outgoing-card">
        <div class="outgoing-header">
            <h3 class="box-title">Outgoing List</h3>
            <div class="outgoing-actions">
                <a onclick="addForm()" class="btn btn-add"><i class="fa fa-plus"></i> Add New Outgoing Product</a>
                <a onclick="showArchived()" class="btn btn-archive"><i class="fa fa-archive"></i> Archived Outgoing</a>
                <a href="{{ route('exportPDF.productOutAll') }}" class="btn btn-export"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
            </div>
        </div>
        <div class="box-body">
            <table id="products-out-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Products</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="outgoing-card mt-4">
        <div class="outgoing-header">
            <h3 class="box-title">Export Invoice</h3>
        </div>
        <div class="box-body">
            <table id="invoice" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Products</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                @foreach($invoice_data as $i)
                    <tbody>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->product->name ?? '' }}</td>
                        <td>{{ $i->customer->name ?? '' }}</td>
                        <td>{{ $i->quantity }}</td>
                        <td>{{ $i->date }}</td>
                        <td>
                            <a href="{{ route('exportPDF.productOut', [ 'id' => $i->id ]) }}" class="btn btn-sm btn-danger">Export Invoice</a>
                        </td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
    @include('product_out.form')
    <!-- Archived Products Out Modal -->
    <div class="modal fade" id="archived-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Archived Outgoing Products</h3>
                </div>
                <div class="modal-body">
                    <table id="archived-products-out-table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Products</th>
                            <th>Customer</th>
                            <th>Quantity</th>
                            <th>Date</th>
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

    <!-- Log on to codeastro.com for more projects! -->
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
    // 'serverSide'  : true
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
        var table = $('#products-out-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.productsOut') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'products_name', name: 'products_name'},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'quantity', name: 'quantity'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var archivedTable;
        function showArchived() {
            $('#archived-modal').modal('show');
            if (!archivedTable) {
                archivedTable = $('#archived-products-out-table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('api/archived-products-out') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'products_name', name: 'products_name'},
                        {data: 'customer_name', name: 'customer_name'},
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
                text: "This outgoing product will be archived!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('productsOut') }}" + '/' + id,
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
                text: "This outgoing product will be restored!",
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, unarchive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('productsOut/unarchive') }}/" + id,
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
            $('.modal-title').text('Add Outgoing Products');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('productsOut') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Outgoing Product');

                    $('#id').val(data.id);
                    $('#product_id').val(data.product_id);
                    $('#customer_id').val(data.customer_id);
                    $('#quantity').val(data.quantity).prop('readonly', true);
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
                    url : "{{ url('productsOut') }}" + '/' + id,
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
                    if (save_method == 'add') url = "{{ url('productsOut') }}";
                    else url = "{{ url('productsOut') . '/' }}" + id;

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
                                title: 'The Quantity is not enough!',
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
