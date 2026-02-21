<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\MaterialItem;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cargo = Cargo::with('materialItems')->get();
            return response()->json([
                'success' => true,
                'data' => $cargo
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
            \Log::info('Cargo create request:', $request->all());

            $validated = $request->validate([
                'cargo_name' => 'required|string|max:200',
                'date_of_taking_cargo' => 'required|date',
                'type_of_packaging' => 'required|string|max:100',
                'weight_of_cargo' => 'required|numeric|min:0',
                'cargo_volume' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'cargo_unit' => 'required|string|max:50',
                'delivery_time' => 'required|date',
            ]);

            $cargo = Cargo::create([
                'cargo_name' => $request->input('cargo_name'),
                'date_of_taking_cargo' => $request->input('date_of_taking_cargo'),
                'type_of_packaging' => $request->input('type_of_packaging'),
                'weight_of_cargo' => $request->input('weight_of_cargo'),
                'cargo_volume' => $request->input('cargo_volume'),
                'quantity' => $request->input('quantity'),
                'cargo_unit' => $request->input('cargo_unit'),
                'danger_class' => $request->input('danger_class'),
                'delivery_time' => $request->input('delivery_time'),
                'notes' => $request->input('notes'),
            ]);

            // Сохраняем материальные ценности, если они переданы
            $materialItems = $request->input('material_items');
            if ($materialItems && is_array($materialItems)) {
                foreach ($materialItems as $item) {
                    MaterialItem::create([
                        'cargo_id' => $cargo->cargo_id,
                        'name' => $item['name'],
                        'quantity' => (int) $item['quantity'],
                        'unit' => $item['unit'],
                    ]);
                }
                \Log::info('Material items created:', ['count' => count($materialItems)]);
            }

            \Log::info('Cargo created:', ['cargo_id' => $cargo->cargo_id]);

            return response()->json([
                'success' => true,
                'message' => 'Груз успешно создан',
                'data' => $cargo
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Cargo create error:', ['message' => $e->getMessage()]);
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
            $cargo = Cargo::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $cargo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Груз не найден'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $cargo = Cargo::findOrFail($id);
            $cargo->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Груз успешно обновлён',
                'data' => $cargo
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
            $cargo = Cargo::findOrFail($id);
            $cargo->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Груз успешно удалён'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
