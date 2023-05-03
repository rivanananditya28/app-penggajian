@extends('layouts.app')
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Jenis Pekerjaan</h2>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="{{ route('management.pekerjaan.index') }}" class="btn btn-primary btn-round">Data Pekerjaan <i class="fas fa-plus-circle"></i></a>
                <a href="{{ route('logout') }}" class="btn btn-secondary btn-round">Logout <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <h2 class="header-title">Data Jenis Pekerjaan</h2>
                        </div>
                        <div class="col-md-6 text-right mb-2">
                            <button onclick="add()" class="btn btn-secondary">Tambah Data <i class="far fa-plus-square"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pekerjaan</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
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
    @include('management.jenis-pekerjaan.modal')
    @endsection
    @section('js')

    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        var table;
      $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            table = $('#dataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ordering: false,
                paging: false,
                ajax: {
                        url: "{{ route('management.jenis-pekerjaan.index') }}",
                        type: "GET",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'total_nominal', name: 'total_nominal'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
        });

        function reload_table(){
            table.ajax.reload(null,false);
        }

        function add(){
            $('#form')[0].reset(); // reset form on modals
            $('#nama').html("");
            $('#nominal').html("");
            $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
            $('#modal-form').modal('show'); // show bootstrap modal
        }

        function save(){
            $.ajax({
                url : "{{ route('management.jenis-pekerjaan.store') }}",
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
                        if(data.errors.nama){
                            $('#nama').text(data.errors.nama[0]);
                        }if(data.errors.nominal){
                            $('#nominal').text(data.errors.nominal[0]);
                        }
                    }
                },
                error: function (jqXHR, textStatus , errorThrown){ 
                    alert(errorThrown);
                }
            });
        }

        function edit(id){
            $('#form')[0].reset(); // reset form on modals
            $('#nama').html("");
            $('#nominal').html("");
            $('[name="id"]').val('');
            //Ajax Load data from ajax
            $.ajax({
            url : "jenis-pekerjaan/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="nominal"]').val(data.nominal);
                $('[name="nama"]').val(data.nama);
                $('#modal-form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title   
            },
            error: function (jqXHR, textStatus , errorThrown) {
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
                    url : "jenis-pekerjaan/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function(data){
                        console.log(status);
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
        
    </script>
    @endsection