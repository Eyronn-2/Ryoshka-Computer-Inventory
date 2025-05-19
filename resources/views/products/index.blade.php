@extends('layouts.master')

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        body { background: #f4f6fa; }
        .products-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            background: #fff;
            padding: 30px 20px 20px 20px;
            margin-top: 30px;
        }
        .products-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .products-header h3 {
            margin: 0;
            font-weight: 700;
            color: #2a2a2a;
        }
        .products-actions {
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
        .btn-archive {
            background: linear-gradient(90deg, #757f9a 0%, #d7dde8 100%);
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
    <div class="products-card">
        <div class="products-header">
            <h3 class="box-title">List of Products</h3>
            <div class="products-actions">
                <a onclick="addForm()" class="btn btn-add"><i class="fa fa-plus"></i> Add Products</a>
                <a onclick="showArchived()" class="btn btn-archive"><i class="fa fa-archive"></i> Archived Products</a>
            </div>
        </div>
        <div class="box-body">
            <table id="products-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty.</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    @include('products.form')
    <!-- Archived Products Modal -->
    <div class="modal fade" id="archived-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Archived Products</h3>
                </div>
                <div class="modal-body">
                    <table id="archived-products-table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty.</th>
                            <th>Image</th>
                            <th>Category</th>
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
        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').show();
                    $('#image-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        var table = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.products') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'show_photo', name: 'show_photo'},
                {data: 'category_name', name: 'category_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var archivedTable;
        function showArchived() {
            $('#archived-modal').modal('show');
            if (!archivedTable) {
                archivedTable = $('#archived-products-table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url('api/archived-products') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'price', name: 'price'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'show_photo', name: 'show_photo'},
                        {data: 'category_name', name: 'category_name'},
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
                text: "You can unarchive this product later!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('products') }}" + '/' + id,
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
                text: "This product will be restored!",
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, unarchive it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('products/unarchive') }}/" + id,
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
            $('#image-preview').hide();
            $('.modal-title').text('Add Product');
            $('.form-group').removeClass('has-error');
            $('.help-block.with-errors').text('');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('products') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Products');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#price').val(data.price);
                    $('#quantity').val(data.quantity);
                    $('#category_id').val(data.category_id);
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
                    url : "{{ url('products') }}" + '/' + id,
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
            $('#form-item').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    var url = (save_method == 'add') ? "{{ url('products') }}" : "{{ url('products') }}/" + id;

                    // Clear previous errors
                    $('.form-group').removeClass('has-error');
                    $('.help-block.with-errors').text('');

                    $.ajax({
                        url : url,
                        type : "POST",
                        data: new FormData($("#form-item")[0]),
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
