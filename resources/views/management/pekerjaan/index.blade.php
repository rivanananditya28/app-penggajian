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
                <button onclick="add_pekerjaan()" class="btn btn-primary btn-round">Tambah Pekerjaan <i class="fas fa-plus-circle"></i></button>
                <a href="{{ route('management.jenis-pekerjaan.index') }}" class="btn btn-primary btn-round">Jenis Pekerjaan <i class="fas fa-plus-circle"></i></a>
                <a href="{{ route('logout') }}" class="btn btn-secondary btn-round">Logout <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row row-card-no-pd mt--2">
        <div class="col-sm-6 col-md-3">
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
                                <p class="card-category">Septian</p>
                                <h4 class="card-title"><span id="septian">0</span></h4>
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
                                <p class="card-category">Yoga</p>
                                <h4 class="card-title"><span id="yoga">0</span></h4>
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
                                <p class="card-category">Ilham</p>
                                <h4 class="card-title"><span id="ilham">0</span></h4>
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
                                <p class="card-category">Mojo</p>
                                <h4 class="card-title"><span id="mojo">0</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
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
                                <p class="card-category">Okta</p>
                                <h4 class="card-title"><span id="okta">0</span></h4>
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
                            <input type="date" class="form-control" value="{{ date('Y-m-26', strtotime('-1 month', strtotime(date('Y-m-01')))) }}" id="awal">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-25')}}" id="akhir">
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
                                    <th>Fee Awal</th>
                                    <th>Fee Akhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:center">
                                        <h4>Total Fee</h4>
                                    </th>
                                    <th colspan="1" style="text-align:left">
                                        <h4 id="totalawal"></h4>
                                    </th>
                                    <th colspan="3" style="text-align:left">
                                        <h4 id="totalakhir"></h4>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
    <!-- main content area end -->
    @include('management.pekerjaan.modal')
    @include('management.pekerjaan.tambah-pekerjaan')
    @endsection
    @section('js')

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
	<script src="{{ url('atlantis/assets/vendor/number/jquery.number.min.js') }}"></script>


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
                        url: "{{ route('management.pekerjaan.index') }}",
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
                    {data: 'total_fee_awal'},
                    {data: 'total_fee_akhir'},
                    {data: 'status_prospek', orderable: false, searchable: false},
                    {data: 'action', orderable: false, searchable: false},
                ],
                dom: 'Bfrtip',
                    buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA PEKERJAAN FREELANCE',
                            exportOptions: {
                                columns: ':not(:last-child)',
                            },
                        },
                        {
                            extend: 'print',
                            messageTop: 'PT. SOLO JALA BUANA',
                            title:'DATA PEKERJAAN FREELANCE',
                            message: false,
                            exportOptions: {
                                columns: ':not(:last-child)',
                            },
                        }
                    ],
                    "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                
                            // Total over all pages
                            totalawal = api
                                .column( 5 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            totalakhir = api
                                .column( 6 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                $("#totalawal").number(totalawal);
                                $("#totalakhir").number(totalakhir);
                            
                        }
                    } );
                });

        function reload_table(){
            table.ajax.reload(null,false);
            count_total();
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
               $("#dani").number(data.dani);
               $("#yoga").number(data.yoga);
               $("#ilham").number(data.ilham);
               $("#mojo").number(data.mojo);
               $("#okta").number(data.okta);
               $("#septian").number(data.septian);

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
            url : "/management/pekerjaan/" + id +"/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="nominal"]').val(data.fee);
                $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title   
                $('#modal-form').modal('show'); 
                reload_table();
            },
            error: function (jqXHR, textStatus , errorThrown) {
                alert(errorThrown);
            }
            });
        }

        function save(){
            $.ajax({
                url : "{{ route('management.pekerjaan.store') }}",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    if(data.status) {
                        $('#modal-form').modal('hide');
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

        function add_pekerjaan(){
            $('#form-pekerjaan')[0].reset(); // reset form on modals
            $('#keterangan').html("");
            $('#nominal-fee').html("");
            $('#id_user').html("");
            $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
            $('#modal-pekerjaan').modal('show'); // show bootstrap modal
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
                    url : "pekerjaan/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function(data){
                        reload_table();
                        sukseshapus();
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

        function save_pekerjaan(){
            $('#keterangan').html("");
            $('#nominal-fee').html("");
            $('#id_user').html("");
            $.ajax({
                url : "pekerjaan/1",
                type: "PUT",
                data: $('#form-pekerjaan').serialize(),
                dataType: "JSON",
                success: function(data){
                    if(data.status) {
                        $('#modal-pekerjaan').modal('hide');
                        reload_table();
                        sukses();
                    }else{
                        if(data.errors.nominal){
                            $('#nominal-fee').text(data.errors.nominal[0]);
                        }if(data.errors.keterangan){
                            $('#keterangan').text(data.errors.keterangan[0]);
                        }if(data.errors.id_user){
                            $('#id_user').text(data.errors.id_user[0]);
                        }
                    }
                },
                error: function (jqXHR, textStatus , errorThrown){ 
                    alert(errorThrown);
                }
            });
        }
    </script>
    @endsection