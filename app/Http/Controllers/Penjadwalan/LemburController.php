<?php

namespace App\Http\Controllers\Penjadwalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

use App\Models\Lembur;
use App\Models\User;
use App\Models\Gaji;
use App\Models\JenisPekerjaan;
use DateTime;

class LemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Lembur::with(['user', 'type']);
            $data = $query->orderByDesc('created_at')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return date('d F Y', strtotime($data->start));
                })
                ->addColumn('start', function ($data) {
                    return date('H:i', strtotime($data->start));
                })
                ->addColumn('end', function ($data) {
                    return date('H:i', strtotime($data->end));
                })
                ->addColumn('durasi', function ($data) {
                    return $data->durasi . ' Jam';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <center>
                        <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="delete_data(' . $row->id . ')"><i class="fas fa-trash-alt"></i></a>
                        </center>';
                    return $actionBtn;
                })
                ->make(true);
        }
        $user = User::select('id', 'name')->get();
        $gaji = Gaji::select('id', 'tahun', 'nominal')->get();
        $type = JenisPekerjaan::select('id', 'nama')->get();
        return view('penjadwalan.lembur.index',  [
            'title'     => 'Lembur',
            'user'      => $user,
            'gaji'      => $gaji,
            'type'      => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {

            $lembur = User::with(['total_durasi_lembur'])->get();

            return Datatables::of($lembur)
                ->addIndexColumn()
                ->addColumn('total_durasi_lembur', function ($data) {
                    if ($data->total_durasi_lembur) {
                        return $data->total_durasi_lembur->total.' Jam';
                    }else{
                        return '0 Jam';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <center>
                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Tambah"><i class="fas fa-plus"></i></a>
                        </center>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mulai'         => 'required',
            'selesai'           => 'required',
            'user'          => 'required',
            'gajipokok'     => 'required',
            'type'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // * Hitung Upah Lembur *
        // berdasarkan KEPUTUSAN MENTERI TENAGA KERJA DAN TRANSMIGRASI
        // REPUBLIK INDONESIA NOMOR KEP.102 /MEN/VI/2004

        $start  =  new DateTime($request->mulai);
        $end    =  new DateTime($request->selesai);
        $diff   = date_diff($start, $end); //date_diff error, diffInHours error juga
        // $diff = $end->diff($start);
        $durasi = $diff->h;
        // return $request;

        $gajiPokok = Gaji::find($request->gajipokok);
        // $durasi = $request->durasi;

        $upah_perJam = 1 / 173 * ($gajiPokok->nominal);

        if ($durasi == 1) {
            $upahLembur = 1.5 * $upah_perJam;
        } else {
            $upahLembur = (1.5 * $upah_perJam) + (($durasi - 1) * (2 * $upah_perJam));
        }

        Lembur::updateOrCreate(
            ['id' => $request->id],
            [
                'start'                 => $request->mulai,
                'end'                   => $request->selesai,
                'id_user'               => $request->user,
                'durasi'                => $durasi,
                'fee'                   => $upahLembur,
                'type'                  => $request->type,
                'keterangan'            => $request->keterangan,
            ]
        );

        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Lembur::find($id);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lembur::find($id)->delete();
        return response()->json(['status' => true]);
    }

    private function hitungUpah()
    {
    }
}
