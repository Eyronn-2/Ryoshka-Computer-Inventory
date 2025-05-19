<style>
    .modal-content.premium-modal {
        box-shadow: 0 12px 40px rgba(0,0,0,0.18);
        border: none;
        border-radius: 22px;
        animation: fadeInModal 0.4s;
        font-family: 'Segoe UI', 'Arial', sans-serif;
    }
    @keyframes fadeInModal {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: none; }
    }
    .modal-header.premium-header {
        background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
        color: #fff;
        border-bottom: none;
        border-radius: 22px 22px 0 0;
        padding: 2rem 2rem 1rem 2rem;
        display: flex;
        align-items: center;
        flex-direction: column;
        text-align: center;
    }
    .modal-title-badge {
        background: #fff;
        color: #43cea2;
        border-radius: 50%;
        padding: 18px 20px;
        font-size: 2.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.10);
        margin-bottom: 0.7rem;
        display: inline-block;
    }
    .modal-title-text {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin-bottom: 0.2rem;
    }
    .modal-subtitle {
        font-size: 1.08rem;
        color: #e3e8ee;
        font-weight: 400;
        margin-bottom: 0.2rem;
    }
    .modal-body.premium-body {
        background: #f8fafc;
        border-radius: 0 0 22px 22px;
        padding: 2.2rem 2rem 1.2rem 2rem;
    }
    .form-floating-label {
        position: relative;
        margin-bottom: 2rem;
    }
    .form-floating-label input,
    .form-floating-label select {
        border-radius: 12px;
        border: 1.5px solid #e3e8ee;
        padding: 1.1rem 1.2rem 0.6rem 2.5rem;
        font-size: 1.13rem;
        background: #fff;
        width: 100%;
        transition: border 0.2s;
    }
    .form-floating-label input:focus,
    .form-floating-label select:focus {
        border-color: #43cea2;
        outline: none;
        box-shadow: 0 0 0 2px #e3f0ff;
    }
    .form-floating-label label {
        position: absolute;
        top: 1.1rem;
        left: 2.5rem;
        color: #7a7a7a;
        font-size: 1.08rem;
        pointer-events: none;
        transition: 0.2s;
        background: #fff;
        padding: 0 0.2rem;
    }
    .form-floating-label input:focus + label,
    .form-floating-label input:not(:placeholder-shown) + label,
    .form-floating-label select:focus + label,
    .form-floating-label select:not([value=""]) + label {
        top: -0.7rem;
        left: 1.2rem;
        font-size: 0.93rem;
        color: #43cea2;
        background: #f8fafc;
    }
    .input-icon {
        position: absolute;
        left: 0.9rem;
        top: 1.1rem;
        color: #b0b8c1;
        font-size: 1.2rem;
        z-index: 2;
    }
    .premium-btn {
        width: 100%;
        border-radius: 10px;
        font-size: 1.15rem;
        font-weight: 700;
        padding: 0.9rem 0;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        transition: background 0.2s, color 0.2s;
    }
    .premium-btn-success {
        background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
        color: #fff;
        border: none;
    }
    .premium-btn-success:hover {
        background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
        color: #fff;
    }
    .premium-btn-cancel {
        background: #fff;
        color: #43cea2;
        border: 2px solid #43cea2;
    }
    .premium-btn-cancel:hover {
        background: #f4f6fa;
        color: #185a9d;
    }
    @media (max-width: 767px) {
        .modal-header.premium-header, .modal-body.premium-body {
            padding: 1.2rem 0.7rem;
        }
    }
</style>
<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content premium-modal">
            <form id="form-item" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header premium-header">
                    <span class="modal-title-badge"><i class="fa fa-arrow-circle-down"></i></span>
                    <span class="modal-title-text"></span>
                    <div class="modal-subtitle">Enter purchase product details below</div>
                    <button type="button" class="close text-white position-absolute" style="right: 1.5rem;top:1.5rem;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body premium-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-floating-label">
                        <i class="fa fa-cube input-icon"></i>
                        {!! Form::select('product_id', $products, null, ['class' => 'form-control select', 'placeholder' => '', 'id' => 'product_id', 'required']) !!}
                        <label for="product_id">Product</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-floating-label">
                        <i class="fa fa-truck input-icon"></i>
                        {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control select', 'placeholder' => '', 'id' => 'supplier_id', 'required']) !!}
                        <label for="supplier_id">Supplier</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-floating-label">
                        <i class="fa fa-sort-numeric-asc input-icon"></i>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder=" " min="1" required>
                        <label for="quantity">Quantity</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-floating-label">
                        <i class="fa fa-calendar input-icon"></i>
                        <input data-date-format='yyyy-mm-dd' type="text" class="form-control" id="date" name="date" placeholder=" " required>
                        <label for="date">Date</label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom border-0">
                    <button type="button" class="premium-btn premium-btn-cancel" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="premium-btn premium-btn-success"><i class="fa fa-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#modal-form').on('show.bs.modal', function (event) {
    var modal = $(this);
    var title = modal.find('.modal-title-text');
    if ($('input[name=_method]').val() === 'POST') {
        title.text('Add New Purchase');
    } else {
        title.text('Edit Purchase');
    }
});

$(function(){
    $('#modal-form form').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()){
            var id = $('#id').val();
            if (save_method == 'add') url = "{{ url('productsIn') }}";
            else url = "{{ url('productsIn') . '/' }}" + id;

            $.ajax({
                url : url,
                type : "POST",
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
                        text: data.responseJSON.message || 'Something went wrong!',
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
