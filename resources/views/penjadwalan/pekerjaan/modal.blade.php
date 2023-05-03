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
                        <div class="col-md-12 col-12 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="belum-di-cek">Belum Di Cek</option>
                                <option value="valid">Valid</option>
                                <option value="tidak-valid">Tidak Valid</option>
                            </select>
                        </div>
                        <span class="text-danger">
                            <strong id="status"></strong>
                        </span>
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