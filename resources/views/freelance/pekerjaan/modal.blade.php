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
                            <label>Jenis Pekerjaan</label>
                            <select name="pekerjaan" class="form-control">
                                <option selected disabled>--Pilih Pekerjaan-</option>
                                @foreach ($dropdown as $dropdown)
                                <option value="{{ $dropdown->id }}">{{ $dropdown->nama }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="pekerjaan2"></strong>
                            </span>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label>Tanggal</label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tgl" required>
                            <span class="text-danger">
                                <strong id="tgl"></strong>
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                            <span class="text-danger">
                                <strong id="keterangan"></strong>
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