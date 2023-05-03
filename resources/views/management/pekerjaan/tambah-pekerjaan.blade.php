<!-- Modal -->
<div class="modal fade" id="modal-pekerjaan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="form-pekerjaan">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Freelance</label>
                            <select name="id_user" class="form-control">
                                <option selected disabled>--Pilih Freelance-</option>
                                <option value="semua">SEMUA Freelance</option>
                                @foreach ($user as $dropdown)
                                <option value="{{ $dropdown->id }}">{{ $dropdown->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="id_user"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tgl" value="{{ date('Y-m-d') }}" required>
                            <span class="text-danger">
                                <strong id="tgl"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Fee Akhir</label>
                            <input type="number" class="form-control" name="nominal" placeholder="Masukan Nominal"
                                required>
                            <span class="text-danger">
                                <strong id="nominal-fee"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukan Keterangan"></textarea>
                            <span class="text-danger">
                                <strong id="keterangan"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="save_pekerjaan()" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- basic modal end -->