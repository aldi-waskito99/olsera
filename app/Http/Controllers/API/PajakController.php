<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Pajak;
use App\Http\Resources\PajakResource;

class PajakController extends Controller
{
    public function index()
    {
        $data = Pajak::latest()->get();
        return response()->json([ItemResource::collection($data), 'Tax fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'rate' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $pajak = Pajak::create([
            'item_id' => $request->item_id,
            'nama' => $request->nama,
            'rate' => $request->rate
         ]);
        
        return response()->json(['Data Berhasil Ditambahkan.', new PajakResource($pajak)]);
    }

    public function update(Request $request, Pajak $pajak)
    {
        $validator = Validator::make($request->all(),[
            'item_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'rate' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $pajak->item_id = $request->item_id;
        $pajak->nama = $request->nama;
        $pajak->rate = $request->rate;
        $pajak->save();
        
        return response()->json(['Data Berhasil Diupdate.', new PajakResource($pajak)]);
    }

    public function destroy(Pajak $pajak)
    {
        $pajak->delete();

        return response()->json('Data Berhasil Dihapus.');
    }
}
