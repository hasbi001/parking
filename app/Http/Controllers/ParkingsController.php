<?php

namespace App\Http\Controllers;

use App\Models\Parkings;
use Illuminate\Http\Request;
use DataTables;
use PDF;

class ParkingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Parkings::count();
        $data = Parkings::orderByDesc('id')->first();
        $kode = "PK0001";
        if(!empty($data)){
            $kode = "PK";
            // $string = substr($data->kode_tiket,0,2);
            $lastnumber = preg_replace('/[PK0]/', '', $data->kode_tiket);
            $inc = 1 + intval($lastnumber);
            $x = strlen("'".$inc."'");
            for ($i=0; $i < $x; $i++) { 
                $kode .= "0";
            }
            $kode .= $inc;
        }
        return view('index',['kode'=>$kode,'total'=>$total]);
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
        $model = new Parkings;
        $model->kode_tiket = $request->kode_tiket;
        $model->jenis_kendaraan = $request->jenis_kendaraan;

        $validasi = $this->validatePlatNo($request);
        if (!empty($validasi)) {
            return response()->json($validasi,200);
        }
        $model->plat_no = $request->plat_no_1.$request->plat_no_2.$request->plat_no_3;
        $model->jam_masuk = $request->jam_masuk;
        $model->jam_keluar = $request->jam_keluar;
        $model->duration = $request->duration;
        $model->tarif_parkir = $request->tarif_parkir;
        if ($model->save()) {
            return response()->json('success',200);
        }
        else
        {
            return response()->json('failed',200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parkings  $parkings
     * @return \Illuminate\Http\Response
     */
    public function show(Parkings $parkings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parkings  $parkings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo $id; die();
        $model = Parkings::where('id',$id)->get();
        $arrDatas = $model->toArray();
        $platumber = $arrDatas[0]['plat_no'];
        $b = preg_replace('/[^0-9]/', '', $platumber);
        
        $plat = preg_replace('/[0-9]/', ' ', $platumber);
        $platNo = explode(" ",$plat);
        // echo "<pre>";
        // print_r();
        // die();
        $datas = [
            'id' => $model[0]['id'],
            'kode_tiket' => $model[0]['kode_tiket'],
            'jenis_kendaraan' => $model[0]['jenis_kendaraan'],
            'plat_no_1' => $platNo[0],
            'plat_no_2' => $b,
            'plat_no_3' => end($platNo),
            'jam_masuk' => $model[0]['jam_masuk'],
            'jam_keluar' => $model[0]['jam_keluar'],
            'duration' => $model[0]['duration'],
            'tarif_parkir' => $model[0]['tarif_parkir'],
        ];
        return response()->json($datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parkings  $parkings
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $model = Parkings::find($id);
        $model->kode_tiket = $request->kode_tiket;
        $model->jenis_kendaraan = $request->jenis_kendaraan;

        $validasi = $this->validatePlatNo($request);
        if (!empty($validasi)) {
            return response()->json($validasi,200);
        }
        $model->plat_no = $request->plat_no_1.$request->plat_no_2.$request->plat_no_3;
        $model->jam_masuk = $request->jam_masuk;
        $model->jam_keluar = $request->jam_keluar;
        $model->duration = $request->duration;
        $model->tarif_parkir = $request->tarif_parkir;
        if ($model->save()) {
            return response()->json('success',200);
        }
        else
        {
            return response()->json('failed',200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parkings  $parkings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Parkings::find($id);
        $model->delete();
        return redirect('/');
    }

    /**
     * Get All Data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        if ($request->ajax()) {
            $data = Parkings::latest()->get();;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" onclick="edit('.$row->id.')" class="edit btn btn-success btn-sm">Edit</a> <a href="'.route('delete',['id'=>$row->id]).'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Build Plat Number
     *
     * @param  \Illuminate\Http\Request  $request
     * @return String
     */
    public function validatePlatNo($request)
    {
        $a = $request->plat_no_1;
        $b = $request->plat_no_2;
        $c = $request->plat_no_3;
        $message = '';
        if(strlen($a) != 1 || is_numeric($a)){
            $message .= "Character pertama harus berupa huruf dan 1 huruf <br/>";
        }

        if (strlen($b) < 1 || !is_numeric($b) || strlen($b) > 4 ) {
            $message .= "Character pertama harus berupa angka, minimal 1 angka dan maksimal 4 angka <br/>";
        }

        if(strlen($c) < 1 || is_numeric($c) || strlen($c) > 3){
            $message .= "Character pertama harus berupa huruf, 1 huruf dan maksimal 3 huruf <br/>";
        }

        return $message;
    }

    public function exportPdf()
    {
        $model = Parkings::all();
        $pdf = PDF::loadView('templatePdf',['model'=>$model->toArray()]);
        return $pdf->download('data_parkir.pdf');
    }
}
