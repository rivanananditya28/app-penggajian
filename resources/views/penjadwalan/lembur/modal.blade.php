<!-- Modal -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-row">
                        <div class="col-md-6 col-12 mb-3">
                            <label>Start</label>
                            <input type="datetime-local" value="{{ date('Y-m-d H:00') }}" class="form-control" name="mulai"
                                required>
                            <span class="text-danger">
                                <strong id="mulai"></strong>
                            </span>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label>End</label>
                            <input type="datetime-local" value="{{ date('Y-m-d H:00', strtotime('+1 hours', strtotime(date('H:00')))) }}" class="form-control" name="selesai"
                                required>
                            <span class="text-danger">
                                <strong id="selesai"></strong>
                            </span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Nama Teknisi</label>
                            <select name="user" class="form-control">
                                <option selected disabled>--Pilih Teknisi--</option>
                                @foreach ($user as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="user"></strong>
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Gaji Pokok</label>
                            <select name="gajipokok" class="form-control" required>
                                <option selected disabled>--Pilih UMK--</option>
                                @foreach ($gaji as $gaji)
                                    <option value="{{ $gaji->id }}">UMK - Tahun {{ $gaji->tahun }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="gajipokok"></strong>
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option selected disabled>--Pilih Type Lembur--</option>
                                @foreach ($type as $type)
                                    <option value="{{ $type->id }}">{{$type->nama}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="type"></strong>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="save()" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- basic modal end -->
