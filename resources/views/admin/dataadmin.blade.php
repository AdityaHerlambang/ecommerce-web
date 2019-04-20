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
                        <h3 class="text-themecolor m-b-0 m-t-0">Data Admin</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Data Admin</li>
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
                                <h4 class="card-title">Data Admin</h4>
                                <h6 class="card-subtitle">Berisi List Admin</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Profile Image</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Profile Image</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($tableData as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->username}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->phone}}</td>
                                                <td><img src="{{url('admin_profile_images/'.$data->profile_image)}}" class="img-circle" style="width:50px;height:50px;"> </td>
                                                <td>
                                                    <button class="btn btn-primary waves-effect waves-light" type="button"><span class="btn-label"><i class="fa fa-edit"></i></span>Edit</button>
                                                    <button class="btn btn-danger waves-effect waves-light" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span>Delete</button>
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
                            <form enctype="multipart/form-data" action="{{url('/admin/dataadmin')}}" method="post">
                                @method('POST')
                                @csrf
                            <div class="modal-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    <div class="form-group" style="text-align: center">
                                        <label for="recipient-name" class="control-label">Profile Image</label><br>
                                        <img id="create-imagepreview" src="{{asset('images/profile-placeholder.jpg')}}" class="img-circle" style="height:100px;width:100px;display:inline-block"><br>
                                        <input type="file" class="form-control" name="imageupload" onchange="readURL(this);">
                                        <script>
                                        function readURL(input) {
                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                                reader.onload = function (e) {
                                                    $('#create-imagepreview')
                                                        .attr('src', e.target.result);
                                                };

                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Name</label>
                                        <input type="name" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Phone</label>
                                        <input type="number" class="form-control" name="phone" required>
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
