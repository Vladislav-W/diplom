<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Resources\CityResource; // Добавьте этот импорт
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Получить список всех городов
     */
    public function index()
    {
        $cities = City::all();
        
        // Возвращаем коллекцию городов через Resource
        return CityResource::collection($cities);
    }

    /**
     * Создать новый город
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cities,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city = City::create([
            'name' => $request->name
        ]);

        // Возвращаем созданный город через Resource
        return new CityResource($city);
    }

    /**
     * Получить конкретный город
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        
        // Возвращаем один город через Resource
        return new CityResource($city);
    }

    /**
     * Обновить город
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cities,name,' . $id . ',city_id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city->update([
            'name' => $request->name
        ]);

        // Возвращаем обновленный город через Resource
        return new CityResource($city);
    }

    /**
     * Удалить город
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(['message' => 'Город удален']);
    }
}