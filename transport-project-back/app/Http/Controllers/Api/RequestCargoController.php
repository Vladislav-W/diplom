<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RequestCargo;
use Illuminate\Http\Request;

class RequestCargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $requestCargos = RequestCargo::all();
            return response()->json([
                'success' => true,
                'data' => $requestCargos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'request_id' => 'required|integer',
                'cargo_id' => 'required|integer',
            ]);

            $requestCargo = RequestCargo::create([
                'request_id' => $request->input('request_id'),
                'cargo_id' => $request->input('cargo_id'),
                'quantity' => $request->input('quantity', 1),
                'unit' => $request->input('unit', 'шт'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Груз успешно привязан к заявке',
                'data' => $requestCargo
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $requestCargo = RequestCargo::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $requestCargo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Связь груза с заявкой не найдена'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $requestCargo = RequestCargo::findOrFail($id);
            $requestCargo->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Связь груза с заявкой успешно обновлена',
                'data' => $requestCargo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $requestCargo = RequestCargo::findOrFail($id);
            $requestCargo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Груз успешно отвязан от заявки'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
