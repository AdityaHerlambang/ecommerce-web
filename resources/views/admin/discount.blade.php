<!DOCTYPE html>
<html lang="en">

@include('admin.components.head')
<link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

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
                            <li class="breadcrumb-item active"><a href="{{url('/admin/product')}}">Product</a></li>
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
                                                <th>Percentage</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Percentage</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($tableData as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->percentage}}</td>
                                                <td>{{$data->start}}</td>
                                                <td>{{$data->end}}</td>
                                                <td>
                                                    <button value="{{$data->id}}" class="btn btn-edit btn-primary waves-effect waves-light" type="button"><span class="btn-label"><i class="fa fa-edit"></i></span>Edit</button>
                                                    <form method='post' action='/admin/product/discount/{{$data->id}}'>
                                                        @csrf
                                                        @method('DELETE')
                                                            <button class="btn btn-danger waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-trash"></i></span>Delete</button>
                                                    </form>
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
                <div id="modal-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Data Admin</h4>
                            </div>
                            <form enctype="multipart/form-data" action="{{url('/admin/product/discount')}}" method="post">
                                @method('POST')
                                @csrf
                                <div class="modal-body">
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

                                        <input type="hidden" class="form-control" value="{{$id_product}}" name="id_product" required>

                                        <div class="form-group">
                                            <label class="control-label">Percentage</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="percentage" name="percentage" aria-describedby="basic-addon2" required>
                                                <span class="input-group-addon" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Start</label>
                                            <input class="form-control date-input" type="date" value="" name="start" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">End</label>
                                            <input class="form-control date-input" type="date" value="" name="end" required>
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
                <!-- /.modal -->

                <!-- Modal Edit -->
                <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Edit</h4>
                            </div>
                            <form enctype="multipart/form-data" id="form-edit" method="post">
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
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

                                        <input type="hidden" class="form-control" id="id" name="id" required>
                                        <input type="hidden" class="form-control" id="id_product" name="id_product" required>

                                        <div class="form-group">
                                            <label class="control-label">Percentage</label>
                                            <input type="text" class="form-control" name="percentage" id="percentage" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Start</label>
                                            <input class="form-control date-input" type="date" value="" id="start" name="start" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">End</label>
                                            <input class="form-control date-input" type="date" value="" id="end" name="end" required>
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
                <!-- /.modal -->
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

    <script>
        jQuery(document).ready(function ($) {

            $(document).on('click','.btn-edit',function(){
                var url = "{{url('/admin/product/discount')}}";
                var id = $(this).val();
                $.get(url + '/' + id, function (data) {
                    console.log(data);

                    $('#form-edit').attr('action',"{{url('/admin/product/discount/')}}"+"/"+id)
                    $('#id').val(id);
                    $('#id_product').val(data.id_product);
                    $('#percentage').val(data.percentage);
                    $('#start').val(data.start);
                    $('#end').val(data.end);
                    $('#modal-edit').modal("show");
                });
            }); 

        });
    </script>

    {{-- END Modal CRUD --}}

    {{-- Modal Error --}}
    @if ($errors->any())
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(window).on('load',function(){
                    $('#modal-create').modal('show');
                });
            });
        </script>
    @endif
    {{-- End Modal Error --}}

    <script>
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
