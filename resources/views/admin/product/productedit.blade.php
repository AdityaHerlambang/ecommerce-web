<!DOCTYPE html>
<html lang="en">

@include('admin.components.head')
<link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@include('admin.components.plugins.fileinput')

<body class="fix-header card-no-border">

        @include('admin.components.preloader')

    <div id="main-wrapper">

        @include('admin.components.topbar')

        @include('admin.components.aside')

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">{{$title}} Edit</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-12">
                                        <form enctype="multipart/form-data" id="form-create" action="{{url('/admin/product/'.$data->id)}}" method="post">
                                        @method('POST')
                                        @csrf
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

                                                    <input type="hidden" name="id" value="{{$data->id}}">

                                                    <div class="form-group">
                                                        <label class="control-label">Product Name</label>
                                                        <input type="text" class="form-control" name="product_name" value="{{$data->product_name}}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">Price</label>
                                                        <input type="text" class="form-control" name="price" value="{{$data->price}}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">Description</label>
                                                        <textarea class="form-control" name="description" required> {{$data->description}} </textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">Rate</label>
                                                        <input type="number" class="form-control" name="product_rate" value="{{$data->product_rate}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">Stock</label>
                                                        <input type="stock" class="form-control" name="stock" value="{{$data->stock}}" required>
                                                    </div>

                                                    <div class="form-group">
                                                            <label for="inputfile" class="control-label">Product Pictures</label>
                                                                <input id="inputfile" name="file[]" type="file" multiple>
                                                                {{-- <script>
                                                                    // 
                                                                        $("#inputfile").fileinput({
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
                                                                </script> --}}
                                                                <script>
                                                                        $("#inputfile").fileinput({
                                                                            theme: "fas",
                                                                            // initialPreview: [url1, url2],
                                                                            initialPreview: {!! $initialPreview !!} ,
                                                                            initialPreviewAsData: true,
                                                                            // initialPreviewConfig: [
                                                                            //     {caption: "Moon.jpg", downloadUrl: url1, size: 930321, width: "120px", key: 1, extra: {id: 100}},
                                                                            //     {caption: "Earth.jpg", downloadUrl: url2, size: 1218822, width: "120px", key: 2, extra: {id: 100}}
                                                                            // ],
                                                                            initialPreviewConfig: {!! $initialPreviewConfig !!},
                                                                            deleteUrl: "url('admin/product/image/delete')",
                                                                            overwriteInitial: false,
                                                                            initialCaption: "Browse or Drag Image to the Box",
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
                                                    </div>
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                                </div>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->

                @include('admin.components.sidebar')

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            @include('admin.components.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    
    @include('admin.components.mainscript')

    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

    <!-- This is data table -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>
    $.validate({
        lang: 'es'
    });
    </script>

    {{-- Modal CRUD --}}

    {{-- <script>
        jQuery(document).ready(function ($) {

            $(document).on('click','.btn-edit',function(){
                var url = "{{url('/admin/productcategory')}}";
                var id = $(this).val();
                $.get(url + '/' + id, function (data) {
                    console.log(data);

                    $('#form-edit').attr('action',"{{url('/admin/productcategory/')}}"+"/"+id)
                    $('#id').val(id);
                    $('#category_name').val(data.category_name);
                    $('#modal-edit').modal("show");
                });
            }); 

        });
    </script> --}}

    {{-- END Modal CRUD --}}

    {{-- Modal Error --}}
    {{-- @if ($errors->any())
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(window).on('load',function(){
                    $('#modal-create').modal('show');
                });
            });
        </script>
    @endif --}}
    {{-- End Modal Error --}}

    {{-- <script>
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
        
        $(".select2").select2();
    </script> --}}

</body>

</html>
