<?php

namespace App\Http\Controllers\Penjadwalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\JenisPekerjaan;
use App\Models\Pekerjaan;
use App\Models\User;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //datatable
        if (request()->ajax()) {

            if ($request->get('freelance') == 'all') {

                if ($request->get('status') == 'all') {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_jenis_pekerjaan', $request->get('status'));
                }
            } else {

                if ($request->get('status') == 'all') {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_user', $request->get('freelance'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_jenis_pekerjaan', $request->get('status'))
                        ->where('id_user', $request->get('freelance'));
                }
            }

            $data = $query->orderByDesc('created_at')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_pekerjaan', function ($row) {
                    return date('d/m/Y', strtotime($row->tgl));
                })
                ->addColumn('total_nominal', function ($row) {
                    return number_format($row->nominal);
                })
                ->addColumn('total_fee_awal', function ($row) {
                    return $row->jenis_pekerjaan->nominal;
                })
                ->addColumn('total_fee_akhir', function ($row) {
                    return $row->fee;
                })
                ->addColumn('status_prospek', function ($row) {

                    if ($row->status == "belum-di-cek") {
                        $actionBtn = '
                        <a href="javascript:void(0)" title="Edit" onclick="edit(' . $row->id . ')"><span class="badge badge-warning">Belum di cek</span></a>
                        ';
                    } else if ($row->status == 'valid') {
                        $actionBtn = '
                        <a href="javascript:void(0)"  title="Edit" onclick="edit(' . $row->id . ')"><span class="badge badge-primary">Valid</span></a>
                            ';
                    } else if ($row->status == 'tidak-valid') {
                        $actionBtn = '
                        <a href="javascript:void(0)"title="Edit" onclick="edit(' . $row->id . ')"><span class="badge badge-danger">Tidak Valid</span></a>
                            ';
                    } else {
                    }
                    return $actionBtn;
                })
                ->rawColumns(['status_prospek', 'total_fee_akhir'])
                ->make(true);
        }

        $jenis  = JenisPekerjaan::select('id', 'nama')->get();
        $freelance  = User::select('id', 'name', 'id_role')->where('id_role', 8)->get();

        return view('penjadwalan.pekerjaan.index', [
            'title'     => 'Data Pekerjaan',
            'jenis'     => $jenis,
            'freelance'     => $freelance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'id'              => 'required',
            'status'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Pekerjaan::find($request->id)->update(
            [
                'status'       => $request->status,
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
    public function show($id, Request $request)
    {
        $belum    = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('status', 'belum-di-cek')
            ->first();

        $valid    = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('status', 'valid')
            ->first();

        $tidak    = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('status', 'tidak-valid')
            ->first();

        $data = [
            'belum'     => $belum->total,
            'valid'     => $valid->total,
            'tidak'     => $tidak->total,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data = Pekerjaan::find($id);
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
        //
    }
}
