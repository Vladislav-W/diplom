<?php
// app/Http/Controllers/Api/OrganizationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    /**
     * GET /api/v1/organizations
     */
    public function index()
    {
        $organizations = Organization::all();
        return OrganizationResource::collection($organizations);
    }

    /**
     * POST /api/v1/organizations
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:organizations,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $organization = Organization::create([
            'name' => $request->name
        ]);

        return new OrganizationResource($organization);
    }

    /**
     * GET /api/v1/organizations/{id}
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        return new OrganizationResource($organization);
    }

    /**
     * PUT /api/v1/organizations/{id}
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:organizations,name,' . $id . ',organization_id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $organization->update([
            'name' => $request->name
        ]);

        return new OrganizationResource($organization);
    }

    /**
     * DELETE /api/v1/organizations/{id}
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return response()->json(['message' => 'Organization deleted']);
    }
}