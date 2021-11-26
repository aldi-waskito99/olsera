<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Item;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index()
    {
        // $data = Item::latest()->get();

        $data = DB::table('items')
                    ->select('items.id','items.nama','items.created_at','items.updated_at','pajaks.id as pajak_id','pajaks.nama as nama_pajak','pajaks.rate')
                    ->join('pajaks', 'pajaks.item_id', 'items.id')
                    ->where('items.id', "3")
                    ->get();

        return response()->json([ItemResource::collection($data), 'Product fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $item = Item::create([
            'nama' => $request->nama
         ]);
        
        return response()->json(['Nama Item Berhasil Ditambahkan.', new ItemResource($item)]);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new ItemResource($item)]);
    }

    public function update(Request $request, Item $item)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $item->nama = $request->nama;
        $item->save();
        
        return response()->json(['Nama Produk Berhasil Diupdate.', new ItemResource($item)]);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json('Produk Berhasil Dihapus.');
    }
}
