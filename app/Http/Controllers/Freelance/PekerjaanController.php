<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPekerjaan;
use App\Models\Pekerjaan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


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

            if ($request->get('pekerjaan') == 'all') {

                if ($request->get('status') == 'all') {

                    $query = Pekerjaan::with('jenis_pekerjaan')
                        // ->where('id_user', session('id'))
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan')
                        // ->where('id_user', session('id'))
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('status', $request->get('status'));
                }
            } else {

                if ($request->get('status') == 'all') {

                    $query = Pekerjaan::with('jenis_pekerjaan')
                        // ->where('id_user', session('id'))
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_jenis_pekerjaan', $request->get('pekerjaan'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan')
                        // ->where('id_user', session('id'))
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_jenis_pekerjaan', $request->get('pekerjaan'))
                        ->where('status', $request->get('status'));
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
                    return number_format($row->jenis_pekerjaan->nominal);
                })
                ->addColumn('total_fee_akhir', function ($row) {

                    if($row->status == 'valid'){
                        
                        return number_format($row->fee);

                    }else{
                        return 0;
                    }

                })
                ->addColumn('action', function ($row) {

                    // if(session('id') == $row->created_by){
                        $actionBtn = '
                        <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="delete_data(' . $row->id . ')"><i class="fas fa-trash-alt"></i></a>
                        ';
                    // }else{
                    //     $actionBtn = '<span class="badge badge-info">No Action</span>';
                    // }

                    return $actionBtn;
                })
                ->addColumn('status_prospek', function ($row) {

                    if ($row->status == "belum-di-cek") {
                        $actionBtn = '
                    <span class="badge badge-warning">Belum di cek</span>
                        ';
                    } else if ($row->status == 'valid') {
                        $actionBtn = '
                        <span class="badge badge-primary">Valid</span>
                            ';
                    } else if ($row->status == 'tidak-valid') {
                        $actionBtn = '
                       <span class="badge badge-danger">Tidak Valid</span>
                            ';
                    } else {
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status_prospek', 'total_fee_akhir'])
                ->make(true);
        }

        $jenis  = JenisPekerjaan::select('id', 'nama')->get();

        return view('freelance.pekerjaan.index', [
            'title'     => 'Pekerjaan',
            'jenis'     => $jenis,
            'dropdown'  => $jenis
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
            'keterangan'        => 'required',
            'pekerjaan'         => 'required',
            'tgl'               => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $fee = JenisPekerjaan::find($request->pekerjaan);

        Pekerjaan::updateOrCreate(
            ['id' => $request->id],
            [
                'id_user'               => session('id'),
                'tgl'                   => $request->tgl,
                'id_jenis_pekerjaan'    => $request->pekerjaan,
                'keterangan'            => $request->keterangan,
                'fee'                   => $fee->nominal,
                'status'                => 'belum-di-cek',
                'created_by'            => session('id'),
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
        $baru   = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('id_jenis_pekerjaan', 1)
            // ->where('id_user', session('id'))
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->first();

        $maintenance   = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('id_jenis_pekerjaan', 2)
            // ->where('id_user', session('id'))
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->first();

        $bts   = DB::table('pekerjaan')
            ->selectRaw('count(id) as total')
            ->where('id_jenis_pekerjaan', 3)
            // ->where('id_user', session('id'))
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->first();

        $data = [
            'baru'          => $baru->total,
            'maintenance'   => $maintenance->total,
            'bts'           => $bts->total,
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
        Pekerjaan::find($id)->delete();
        return response()->json(['status' => true]);
    }
}
