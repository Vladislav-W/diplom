<?php
// app/Http/Controllers/Api/ResponsiblePersonController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResponsiblePerson;
use App\Http\Resources\ResponsiblePersonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponsiblePersonController extends Controller
{
    /**
     * GET /api/v1/responsible-people
     */
    public function index()
    {
        $people = ResponsiblePerson::all();
        return ResponsiblePersonResource::collection($people);
    }

    /**
     * POST /api/v1/responsible-people
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'second_name' => 'nullable|string',
            'department' => 'required|string',
            'post' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $person = ResponsiblePerson::create($request->all());
        return new ResponsiblePersonResource($person);
    }

    /**
     * GET /api/v1/responsible-people/{id}
     */
    public function show($id)
    {
        $person = ResponsiblePerson::findOrFail($id);
        return new ResponsiblePersonResource($person);
    }

    /**
     * PUT /api/v1/responsible-people/{id}
     */
    public function update(Request $request, $id)
    {
        $person = ResponsiblePerson::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'second_name' => 'nullable|string',
            'department' => 'required|string',
            'post' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $person->update($request->all());
        return new ResponsiblePersonResource($person);
    }

    /**
     * DELETE /api/v1/responsible-people/{id}
     */
    public function destroy($id)
    {
        $person = ResponsiblePerson::findOrFail($id);
        $person->delete();

        return response()->json(['message' => 'Responsible person deleted']);
    }
}