<!-- Modal -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Jenis Pekerjaan"
                                required>
                            <span class="text-danger">
                                <strong id="nama"></strong>
                            </span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Nominal</label>
                            <input type="number" class="form-control" name="nominal" placeholder="Masukan Nominal"
                                required>
                            <span class="text-danger">
                                <strong id="nominal"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="save()" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- basic modal end -->