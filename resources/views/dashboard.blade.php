@extends('layouts.app')
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                <h5 class="text-white op-7 mb-2">Monitoring User Prospek</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="" class="btn btn-secondary btn-round">Logout</a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row row-card-no-pd mt--2">
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-secondary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Marketing Medsos</p>
                                <h4 class="card-title"><span id="medsos">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">AGUS</p>
                                <h4 class="card-title"><span id="agus">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">IKHSAN</p>
                                <h4 class="card-title"><span id="ikhsan">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">DENI</p>
                                <h4 class="card-title"><span id="deni">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">WIDAYAT</p>
                                <h4 class="card-title"><span id="widayat">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-user-1 text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Marketing Office</p>
                                <h4 class="card-title"><span id="office">0</span> User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <h2 class="header-title">Data User Prospek</h2>
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Tanggal Awal</label>
                            <input type="date" class="form-control" value="" id="awal" min="2021-07-16">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" value="" id="akhir">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="all" selected>SEMUA</option>
                                <option value="belum-di-cek">Belum di cek</option>
                                <option value="valid">Valid</option>
                                <option value="tidak-valid">Tidak Valid</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Marketing</label>
                            <select id="marketing" class="form-control">
                                <option value="all" selected>SEMUA</option>
                                <option value="M001">MARKETING OFFICE</option>
                                <option value="M000">MARKETING MEDSOS</option>
                                <option value="M002">AGUS</option>
                                <option value="M007">IKHSAN</option>
                                <option value="M012">DENI</option>
                                <option value="M009">WIDAYAT</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-12 text-center mb-3">
                            <button onclick="add_filter()" class="btn btn-secondary mt-3"><i class="fa fa-search"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama User</th>
                                    <th>Marketing</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
    <!-- main content area end -->
    @endsection
    @section('js')

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        var table;
      $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            count_total();
            
            table = $('#dataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ordering: false,
                paging: false,
                ajax: {
                        url: "",
                        type: "GET",
                        data: function(data) {
                            data.marketing  = $('#marketing').val();
                            data.status     = $('#status').val();
                            data.awal       = $('#awal').val();
                            data.akhir      = $('#akhir').val();
                    }
                },
                columns: [
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'nama_user', name: 'nama_user'},
                    {data: 'marketing.nama_user', name: 'marketing.nama_user'},
                    {data: 'telp', name: 'telp'},
                    {data: 'alamat_prospek', name: 'alamat_prospek'},
                    {data: 'catatan', name: 'catatan'},
                    {data: 'status_prospek', name: 'status_prospek', orderable: false, searchable: false},
                ],
                dom: 'Bfrtip',
                    buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA USER PROSPEK'
                        },
                        {
                            extend: 'print',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA USER PROSPEK',
                            header: false,
                            footer: false,
                            message: false
                        }
                    ]
            });
        });
        function reload_table(){
            table.ajax.reload(null,false);
        }
        function add_filter(){
            var marketing   = $("#marketing").val();
            var status      = $("#status").val();
            var awal        = $("#awal").val();
            var akhir       = $("#akhir").val();
            count_total();
            table.draw();
            sukses();
        }
        function count_total(){
            var awal        = $("#awal").val();
            var akhir       = $("#akhir").val();
            //Ajax Load data from ajax
            $.ajax({
            url : "user-prospek/1?awal=" + awal + "&&akhir=" + akhir,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
               $("#agus").text(data.agus);
               $("#ikhsan").text(data.ikhsan);
               $("#deni").text(data.deni);
               $("#widayat").text(data.widayat);
               $("#office").text(data.office);
               $("#medsos").text(data.medsos);
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }
        function validasi(id){
            $('#form')[0].reset(); 
            $('[name="id_prospek"]').val('');
            //Ajax Load data from ajax
            $.ajax({
            url : "user-prospek" + id + "edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_prospek"]').val(data.id_prospek);
                $('[name="nama_user"]').val(data.nama_user);
                $('[name="status_prospek"]').val(data.status);
                $('[name="catatan"]').val(data.catatan);
                $('#modal-form').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }
        function save(){
            id = $('[name="id_prospek"]').val();
            $.ajax({
                url : "user-prospek/" + id,
                type: "PUT",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    console.log(data);
                    if(data.status) {
                        $('#modal-form').modal('hide');
                        reload_table();
                        sukses();
                    }else{
                        if(data.errors.status){
                            $('#status').text(data.errors.status[0]);
                        }
                    }
                },
                error: function (jqXHR, textStatus , errorThrown){ 
                    alert(errorThrown);
                }
            });
        }
        function sukses() {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
                });
            Toast.fire({
                icon: 'success',
                title: 'Berhasil !'
            })
        }
    </script>
    @endsection