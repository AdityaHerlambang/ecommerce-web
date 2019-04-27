<div id="modal-create" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>Add</h4>
            </div>
            <form enctype="multipart/form-data" id="form-create" action="{{url('/admin/product')}}" method="post">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                                {{-- Error Messages --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="control-label">Product Name</label>
                                <input type="text" class="form-control" name="product_name" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Price</label>
                                <input type="text" class="form-control" name="price" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" name="description" required> </textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Rate</label>
                                <input type="number" class="form-control" name="product_rate">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Stock</label>
                                <input type="stock" class="form-control" name="stock" required>
                            </div>

                            <div class="form-group">
                                    <label for="input-24" class="control-label">Product Pictures</label>
                                        <input id="input-24" name="file[]" type="file" multiple>
                                        <script>
                                            // 
                                                $("#input-24").fileinput({
                                                    theme: "fas",
                                                    initialCaption: "Browse or Drag Image to the Box",
                                                    overwriteInitial: true,
                                                    uploadIcon : "<i class='fas fa-upload'></i>",
                                                    removeIcon : "<i class='fas fa-trash-alt'></i>",
                                                    browseIcon : "<i class='fas fa-search-plus'></i>",
                                                    removeClass : 'btn btn-danger',
                                                    showUpload: false, // Removing upload button from form
                                                    browseOnZoneClick: true,
                                                    fileActionSettings: {
                                                        showUpload: false, // Removing upload button from action settings
                                                    }
                                                });
                                        </script>
                                    {{-- <script>
                                            var url1 = 'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg',
                                                url2 = 'http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg';
                                            $("#input-24").fileinput({
                                                theme: "fas",
                                                initialPreview: [url1, url2],
                                                initialPreviewAsData: true,
                                                initialPreviewConfig: [
                                                    {caption: "Moon.jpg", downloadUrl: url1, size: 930321, width: "120px", key: 1},
                                                    {caption: "Earth.jpg", downloadUrl: url2, size: 1218822, width: "120px", key: 2}
                                                ],
                                                deleteUrl: "/site/file-delete",
                                                overwriteInitial: false,
                                                maxFileSize: 100,
                                                initialCaption: "Browse or Drag Image to the Box"
                                            });
                                    </script> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>