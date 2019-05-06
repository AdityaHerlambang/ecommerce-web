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
                        <h3 class="text-themecolor m-b-0 m-t-0">{{$title}}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <button class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modal-create" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Data</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{$title}}</h4>
                                <h6 class="card-subtitle">Berisi List {{$title}}</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Description</th>
                                                <th>Rate</th>
                                                <th>Categories</th>
                                                <th>Discounts</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Description</th>
                                                <th>Rate</th>
                                                <th>Categories</th>
                                                <th>Discounts</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($tableData as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->product_name}}</td>
                                                <td>{{$data->price}}</td>
                                                <td>{{$data->description}}</td>
                                                <td>{{$data->product_rate}}</td>
                                                <td>
                                                    @foreach ($data->product_category_detail as $dataDetail)
                                                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-xs btn-primary">
                                                            {{$dataDetail->product_category->category_name}} -
                                                            @if ($dataDetail->product_category->gender == '1')
                                                                Male
                                                            @else
                                                                Female
                                                            @endif
                                                        </button>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button class="btn btn-edit btn-info waves-effect waves-light" onclick="window.location.href='{{ url('/admin/product/discount/'.$data->id.'/index') }}'" type="button"><i class="fa fa-percentage"></i></button>
                                                </td>
                                                <td>{{$data->stock}}</td>
                                                <td style='display:inline-block;'>
                                                    <form method='get' action='/admin/product/{{$data->id}}/edit'>
                                                        @csrf
                                                        @method('GET')
                                                            <button class="btn btn-edit btn-primary waves-effect waves-light" type="submit"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                    <form method='post' action='/admin/product/{{$data->id}}'>
                                                        @csrf
                                                        @method('DELETE')
                                                            <button class="btn btn-danger waves-effect waves-light" type="submit"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                    <button onclick="window.location.href='{{ url('/product/'.$data->id) }}'" class="btn btn-success waves-effect waves-light" type="submit"><i class="fa fa-eye"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

                {{-- MODALS --}}

                <!-- Modal Create -->
                @include('admin.product.createmodal')
                <!-- /.modal -->

                {{-- END MODALS --}}

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

    <script>
        $(".select2").select2();

        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $(".select2").select2();
    </script> --}}

</body>

</html>
