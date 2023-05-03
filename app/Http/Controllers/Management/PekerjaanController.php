<?php

namespace App\Http\Controllers\Management;

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
                        ->where('status', 'valid')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('status', 'valid')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_jenis_pekerjaan', $request->get('status'));
                }
            } else {

                if ($request->get('status') == 'all') {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('status', 'valid')
                        ->where('tgl', '>=', $request->get('awal'))
                        ->where('tgl', '<=', $request->get('akhir'))
                        ->where('id_user', $request->get('freelance'));
                } else {

                    $query = Pekerjaan::with('jenis_pekerjaan', 'user')
                        ->where('status', 'valid')
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
                ->addColumn('action', function ($row) {

                    if(session('id') == $row->created_by){
                        $actionBtn = '
                        <a href="javascript:void(0)" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="delete_data(' . $row->id . ')"><i class="fas fa-trash"></i></a>
                        ';
                    }else{
                        $actionBtn = '
                        <a href="javascript:void(0)" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                        ';
                    }

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

        $jenis      = JenisPekerjaan::select('id', 'nama')->get();
        $freelance  = User::select('id', 'name', 'id_role')->where('id_role', 8)->get();

        return view('management.pekerjaan.index', [
            'title'         => 'Data Pekerjaan',
            'jenis'         => $jenis,
            'freelance'     => $freelance,
            'user'          => $freelance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'nominal'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Pekerjaan::find($request->id)->update(
            [
                'fee'       => $request->nominal,
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
        $dani   = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 10)
            ->first();

        $yoga   = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 11)
            ->first();

        $mojo   = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 50)
            ->first();

        $ilham   = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 13)
            ->first();

        $okta   = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 14)
            ->first();

        $septian  = DB::table('pekerjaan')
            ->selectRaw('sum(fee) as total')
            ->where('status', 'valid')
            ->where('tgl', '>=', $request->get('awal'))
            ->where('tgl', '<=', $request->get('akhir'))
            ->where('id_user', 49)
            ->first();

        $data = [
            'dani'  => $dani->total,
            'yoga'  => $yoga->total,
            'mojo'  => $mojo->total,
            'ilham' => $ilham->total,
            'okta'  => $okta->total,
            'septian'  => $septian->total,
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

        $validator = Validator::make($request->all(), [
            'id_user'        => 'required',
            'nominal'        => 'required',
            'keterangan'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try {

            if ($request->id_user == 'semua') {

                $freelance  = User::select('id', 'name', 'id_role')->where('id_role', 8)->get();

                foreach ($freelance as $items) {
                    Pekerjaan::create([
                        'id_user'               => $items->id,
                        'tgl'                   => $request->tgl,
                        'id_jenis_pekerjaan'    => '6',
                        'keterangan'            => $request->keterangan,
                        'fee'                   => $request->nominal,
                        'status'                => 'valid',
                        'created_by'            => session('id'),
                    ]);
                }
            } else {

                Pekerjaan::create([
                    'id_user'               => $request->id_user,
                    'tgl'                   => $request->tgl,
                    'id_jenis_pekerjaan'    => '6',
                    'keterangan'            => $request->keterangan,
                    'fee'                   => $request->nominal,
                    'status'                => 'valid',
                    'created_by'            => session('id'),
                ]);
            }

            DB::commit();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollback();

            //add log
            Log::channel('info')->info('GAGAL : ', [
                'error'  => $e
            ]);

            Log::channel('discord')->info('GAGAL Tambah Pekerjaan Freelance : ', [
                'error'  => $e
            ]);
        }
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
        return response()->json(true);
    }
}
