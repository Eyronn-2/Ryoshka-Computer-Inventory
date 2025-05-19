<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog"><!-- Log on to codeastro.com for more projects! -->
        <div class="modal-content">
            <form  id="form-item" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">


                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                            <span class="help-block with-errors"></span>
                        </div>


                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <span class="help-block with-errors"></span>
                            <div id="image-preview" style="display: none; margin-top: 10px;">
                                <img src="" alt="Preview" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            {!! Form::select('category_id', $category, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Category --', 'id' => 'category_id', 'required']) !!}
                            <span class="help-block with-errors"></span>
                        </div>




                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- Log on to codeastro.com for more projects! -->
<!-- /.modal -->
