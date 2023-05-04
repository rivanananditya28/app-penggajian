@extends('layouts.app')
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Welcome <span id="session">{{ strtoupper(session('name')) }}</span>
                </h2>
                <h5 class="text-white op-7 mb-2">Data Lembur Anda</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <button onclick="add()" class="btn btn-primary btn-round">Tambah Data Lembur <i
                        class="fas fa-plus-circle"></i></button>
                {{-- <a href="http://auth.solonet.net.id/user/profile" class="btn btn-secondary btn-round">Setting <i
                        class="fas fa-user-cog"></i></a> --}}
                <a href="{{ route('logout') }}" class="btn btn-secondary btn-round">Logout <i
                        class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-12">
                    <h2 class="header-title">Data Total Lembur Pegawai</h2>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-2 col-12 mb-3">
                    <label>Tanggal Awal</label>
                    <input type="date" class="form-control"
                        value="{{ date('Y-m-26', strtotime('-1 month', strtotime(date('Y-m-01')))) }}" id="awal">
                </div>
                <div class="col-md-2 col-12 mb-3">
                    <label>Tanggal Akhir</label>
                    <input type="date" class="form-control" value="{{ date('Y-m-25') }}" id="akhir">
                </div>
                <div class="col-md-1 col-12 text-center mb-3">
                    <button onclick="add_filter()" class="btn btn-secondary mt-3"><i class="fa fa-search"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table id="tableUpah" class="display table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Teknisi</th>
                            <th>Nama Teknisi</th>
                            <th>Total Durasi Lembur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <button type="submit" class="btn btn-secondary mt-3">Pilih</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <h2 class="header-title">Data Lembur Pegawai</h2>
                            <br>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Tanggal</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Nama Teknisi</th>
                                    <th>Type</th>
                                    <th>Keterangan</th>
                                    <th>Durasi</th>
                                    <th>
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
<!-- main content area end -->
@endsection
@include('penjadwalan.lembur.modal')
@section('js')
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#tableUpah').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('penjadwalan.lembur.create') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'id_user'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'total_durasi_lembur'
                    },
                    {
                        data: 'action'
                    },
                ],
            });

            table = $('#dataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('penjadwalan.lembur.index') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'start'
                    },
                    {
                        data: 'end'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'type.nama'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'durasi'
                    },
                    {
                        data: 'action'
                    },
                ],
            });
        });

        function reload_table(){
            table.ajax.reload(null,false);
            // count_total();
        }
        
        function add() {
            $('#form')[0].reset(); // reset form on modals
            $('[name="id"]').val('');
            $('#pekerjaan2').html("");
            $('#tgl').html("");
            $('#keterangan').html("");
            $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
            $('#modal-form').modal('show'); // show bootstrap modal
        }

        function save(){
            $('#mulai').html("");
            $('#selesai').html("");
            $('#user').html("");
            $('#gajipokok').html("");
            $('#type').html("");
            $('#keterangan').html("");
            $.ajax({
                url : "{{ route('penjadwalan.lembur.store') }}",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    console.log(data);
                    if(data.status) {
                        $('#modal-form').modal('hide');
                        reload_table();
                        sukses();
                    }else{
                        if(data.errors.mulai){
                            $('#mulai').text(data.errors.mulai[0]);
                        }if(data.errors.selesai){
                            $('#selesai').text(data.errors.selesai[0]);
                        }if(data.errors.user){
                            $('#user').text(data.errors.user[0]);
                        }if(data.errors.gajipokok){
                            $('#gajipokok').text(data.errors.gajipokok[0]);
                        }if(data.errors.type){
                            $('#type').text(data.errors.type[0]);
                        }if(data.errors.keterangan){
                            $('#keterangan').text(data.errors.keterangan[0]);
                        }
                    }
                },
                error: function (jqXHR, textStatus , errorThrown){ 
                    alert(errorThrown);
                }
            });
        }

        function delete_data(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
            })
            swalWithBootstrapButtons.fire({
                title: 'Konfirmasi !',
                text: "Anda Akan Menghapus Data ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus !',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                $.ajax({
                    url : "/penjadwalan/lembur/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function(data){
                        reload_table();
                        sukseshapus();
                        // count_total();
                    },
                    error: function (jqXHR, textStatus , errorThrown){ 
                        console.log(errorThrown);
                    }
                })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Batal',
                    'Data tidak dihapus',
                    'error'
                )
                }
            })
        }

        function edit(id){
            $('#form')[0].reset(); 
            $('#mulai').html("");
            $('#selesai').html("");
            $('#user').html("");
            $('#gajipokok').html("");
            $('#type').html("");
            $('#keterangan').html("");
            $('[name="id"]').val('');
            //Ajax Load data from ajax
            $.ajax({
            url : "/penjadwalan/lembur/" + id +"/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="mulai"]').val(data.start);
                $('[name="selesai"]').val(data.end);
                $('[name="user"]').val(data.id_user);
                $('[name="type"]').val(data.type);
                $('[name="keterangan"]').val(data.keterangan);
                $('#modal-form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title   
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }

        function to_rupiah(angka) {
            var rev = parseInt(angka, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var i = 0; i < rev.length; i++) {
                rev2 += rev[i];
                if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            return 'Rp. ' + rev2.split('').reverse().join('');
        }
</script>
@endsection