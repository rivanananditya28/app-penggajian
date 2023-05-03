<?php

namespace App\Http\Controllers\Management;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\JenisPekerjaan;

class JenisPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //datatable
        if (request()->ajax()) {
            $data = JenisPekerjaan::select('id', 'nama', 'nominal')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('total_nominal', function ($row) {
                    return number_format($row->nominal);
                })
                ->addColumn('action', function ($row) {

                    $actionBtn = '
                            <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="delete_data(' . $row->id . ')"><i class="fas fa-trash-alt"></i></a>
                            ';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('management.jenis-pekerjaan.index', [
            'title'     => 'Data Jenis Pekerjaan'
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
            'nama'            => 'required',
            'nominal'         => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        JenisPekerjaan::updateOrCreate(['id' => $request->id],
                [
                    'nama'          => $request->nama,
                    'nominal'       => $request->nominal,
                ]);   
   
        return response()->json(['status'=> true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = JenisPekerjaan::find($id);
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
        //
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
        JenisPekerjaan::find($id)->delete();
        return response()->json(['status'=> true]);
    }
}
