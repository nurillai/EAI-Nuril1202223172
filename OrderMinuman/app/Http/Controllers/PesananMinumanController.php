<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PesananMinuman;

class PesananMinumanController extends Controller
{
    public function index()
    {
        $pesanan = PesananMinuman::all();
        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $pesanan = PesananMinuman::find($id);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
   
        $validatedData = $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'jenis_minuman' => 'required|in:Thai Tea,Green Tea,Milk Tea,Dark Choco,Vanilla Latte,Mocca Latte,Mango Yakult,Lychee Tea,Peach Tea',
            'suhu' => 'required|in:Hot,Ice',
            'gula' => 'required|in:25%,50%,100%'
        ]);

       
        $pesanan = PesananMinuman::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil disimpan!',
            'data' => $pesanan
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $pesanan = PesananMinuman::find($id);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'nama_pemesan' => 'sometimes|string|max:100',
            'jenis_minuman' => 'sometimes|in:Thai Tea,Green Tea,Milk Tea,Dark Choco,Vanilla Latte,Mocca Latte,Mango Yakult,Lychee Tea,Peach Tea',
            'suhu' => 'sometimes|in:Hot,Ice',
            'gula' => 'sometimes|in:25%,50%,100%'
        ]);

        $pesanan->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil diperbarui!',
            'data' => $pesanan
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $pesanan = PesananMinuman::find($id);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $pesanan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dihapus'
        ], Response::HTTP_OK);
    }
}
