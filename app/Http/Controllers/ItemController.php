<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pajak;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Laravel\Lumen\Routing\Controller as BaseController;

class ItemController extends Controller
{
    public function index()
    {
        $showitems = Item::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Item',
            'data'    => $showitems
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
        ]);

        if ($validator->fails()) 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Semua Kolom Wajib Diisi!',
                    'data'   => $validator->errors()
                ],401);
            } 
        else 
        {
            //mengecek data nama produk yang sama
            $cekitem = DB::table('items')
                        ->select('id','nama')
                        ->where('nama', '=' , $request->input('nama'))
                        ->get();

            foreach($cekitem as $cekitem){
                if($cekitem->nama == $request->input('nama'))
                {
                    return response()->json(
                      [
                          'success' => false,
                          'message' => 'Data Sudah Ada!',
                      ], 400);
                }
            }

        $additem = Item::create([
            'nama' => $request->input('nama'),
        ]);

        if ($additem) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Disimpan!',
                'data' => $additem
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 400);
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Berhasil Diinput!',
            ], 400);
        }
    }

    public function show($id)
    {

        $items = DB::select("select id, nama from items where id = $id");

        $results = array();

        for($i=0; $i < count($items); $i++)
        {
            $results[$i]["id"] = $items[$i]->id;
            $results[$i]["nama"] = $items[$i]->nama;
            $results[$i]["pajak"] = DB::select( DB::raw("select * from pajaks where item_id = $id"));
        }

        return response()->json
                (
                    array
                        (
                            'data' => $results
                        ),
                );
        die;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            // Update tabel items
            $updateitem = DB::table('items')
                ->where('id', "$id")
                ->update(
                    [
                        'nama' => $request->input('nama')
                    ]
                );

            if ($updateitem) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item Berhasil Diupdate!',
                    'data' => $updateitem
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Gagal Diupdate!',
                ], 400);
            }

        }
    }

    public function destroy($id)
    {
        $hapusitem = DB::table('items')->where('id', "$id")->delete();
        $hapuspajak = DB::table('pajaks')->where('item_id', "$id")->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item dan Pajak Berhasil Dihapus!',
        ], 200);
    }
}