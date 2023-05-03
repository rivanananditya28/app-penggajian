@extends('layouts.app')
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                <h5 class="text-white op-7 mb-2">Monitoring Pekerjaan Freelance</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="http://auth.solonet.net.id/user/profile" class="btn btn-secondary btn-round">Setting <i class="fas fa-user-cog"></i></a>
                <a href="{{ route('logout') }}" class="btn btn-secondary btn-round">Logout <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row row-card-no-pd mt--2">
        <div class="col-sm-12 col-md-4">
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
                                <p class="card-category">Belum Di Cek</p>
                                <h4 class="card-title"><span id="belum">0</span> Pekerjaan</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
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
                                <p class="card-category">Valid</p>
                                <h4 class="card-title"><span id="valid">0</span> Pekerjaan</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
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
                                <p class="card-category">Tidak Valid</p>
                                <h4 class="card-title"><span id="tidak">0</span> Pekerjaan</h4>
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
                            <h2 class="header-title">Data Pekerjaan</h2>
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Tanggal Awal</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-01') }}" id="awal">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-t')}}" id="akhir">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Jenis Pekerjaan</label>
                            <select id="status" class="form-control">
                                <option value="all" selected>SEMUA</option>
                                @foreach ($jenis as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Freelance</label>
                            <select id="freelance" class="form-control">
                                <option value="all" selected>SEMUA</option>
                                @foreach ($freelance as $freelance)
                                <option value="{{ $freelance->id }}">{{ $freelance->name }}</option>
                                @endforeach
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
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Freelance</th>
                                    <th>Pekerjaan</th>
                                    <th>Keterangan</th>
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
    @include('penjadwalan.pekerjaan.modal')
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
                        url: "{{ route('penjadwalan.pekerjaan.index') }}",
                        type: "GET",
                        data: function(data) {
                            data.status     = $('#status').val();
                            data.freelance     = $('#freelance').val();
                            data.awal       = $('#awal').val();
                            data.akhir      = $('#akhir').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'tgl_pekerjaan'},
                    {data: 'user.name'},
                    {data: 'jenis_pekerjaan.nama'},
                    {data: 'keterangan'},
                    {data: 'status_prospek'},
                ],
                dom: 'Bfrtip',
                    buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA PEKERJAAN FREELANCE',
                        },
                        {
                            extend: 'print',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA PEKERJAAN FREELANCE',
                            message: false,
                        }
                    ],
            } );
        });

        function reload_table(){
            table.ajax.reload(null,false);
        }

        function add_filter(){
            var freelance   = $("#freelance").val();
            var status      = $("#status").val();
            var awal        = $("#awal").val();
            var akhir       = $("#akhir").val();
            table.draw();
            sukses();
            count_total();
        }

        function count_total(){
            var awal        = $("#awal").val();
            var akhir       = $("#akhir").val();
            //Ajax Load data from ajax
            $.ajax({
            url : "pekerjaan/1?awal=" + awal + "&&akhir=" + akhir,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
               $("#belum").text(data.belum);
               $("#valid").text(data.valid);
               $("#tidak").text(data.tidak);
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }

        function edit(id){
            $('#form')[0].reset(); 
            $('[name="id"]').val('');
            //Ajax Load data from ajax
            $.ajax({
            url : "/penjadwalan/pekerjaan/" + id +"/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="status"]').val(data.status);
                $('.modal-title').text('Edit Data');
                $('#modal-form').modal('show'); 
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }

        function save(){
            $.ajax({
                url : "{{ route('penjadwalan.pekerjaan.store') }}",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    if(data.status) {
                        $('#modal-form').modal('hide');
                        count_total();
                        reload_table();
                        sukses();
                    }else{
                        if(data.errors.nominal){
                            $('#nominal').text(data.errors.nominal[0]);
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