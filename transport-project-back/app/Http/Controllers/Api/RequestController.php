<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Organization;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * GET /api/v1/requests
     */
    public function index()
    {
        try {
            $requests = RequestModel::with([
                'organizationFrom',
                'organizationTo',
                'departureCity',
                'arrivalCity',
                'responsiblePerson'
            ])->get();
            
            return response()->json([
                'success' => true,
                'data' => $requests
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/v1/requests
     */
    public function store(Request $request)
    {
        try {
            // Получаем ID организаций по имени
            $organizationFromId = null;
            $organizationToId = null;
            
            // Если передано имя организации - ищем по имени
            if ($request->has('organization_from_name') && $request->input('organization_from_name')) {
                $orgFrom = Organization::where('name', $request->input('organization_from_name'))->first();
                if ($orgFrom) {
                    $organizationFromId = $orgFrom->organization_id;
                }
            } elseif ($request->has('organization_from_id')) {
                $organizationFromId = $request->input('organization_from_id');
            }
            
            if ($request->has('organization_to_name') && $request->input('organization_to_name')) {
                $orgTo = Organization::where('name', $request->input('organization_to_name'))->first();
                if ($orgTo) {
                    $organizationToId = $orgTo->organization_id;
                }
            } elseif ($request->has('organization_to_id')) {
                $organizationToId = $request->input('organization_to_id');
            }
            
            // Генерируем номер заявки, если не передан
            $requestNumber = $request->input('request_number', 'REQ-' . date('YmdHis') . '-' . rand(1000, 9999));
            
            // Создаём новую заявку
            $newRequest = RequestModel::create([
                'request_number' => $requestNumber,
                'status' => $request->input('status', 'new'),
                'organization_from_id' => $organizationFromId,
                'departure_city_id' => $request->input('departure_city_id'),
                'address_from' => $request->input('address_from'),
                'notes_from' => $request->input('notes_from'),
                'organization_to_id' => $organizationToId,
                'arrival_city_id' => $request->input('arrival_city_id'),
                'address_to' => $request->input('address_to'),
                'notes_to' => $request->input('notes_to'),
                'departure_datetime' => $request->input('departure_datetime'),
                'arrival_datetime' => $request->input('arrival_datetime'),
                'auto_id' => $request->input('auto_id'),
                'driver_id' => $request->input('driver_id'),
                'responsible_person_id' => $request->input('responsible_person_id'),
                'attorney_for_driver' => $request->input('attorney_for_driver', false),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно создана',
                'request_id' => $newRequest->request_id,
                'data' => $newRequest
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/v1/requests/{id}
     */
    public function show(string $id)
    {
        try {
            $request = RequestModel::with([
                'organizationFrom',
                'organizationTo',
                'departureCity',
                'arrivalCity',
                'responsiblePerson'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $request
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Заявка не найдена'
            ], 404);
        }
    }

    /**
     * PUT /api/v1/requests/{id}
     */
    public function update(Request $request, string $id)
    {
        try {
            $requestModel = RequestModel::findOrFail($id);
            
            // Получаем ID организаций по имени
            $organizationFromId = $request->input('organization_from_id');
            $organizationToId = $request->input('organization_to_id');
            
            if ($request->has('organization_from_name') && $request->input('organization_from_name')) {
                $orgFrom = Organization::where('name', $request->input('organization_from_name'))->first();
                if ($orgFrom) {
                    $organizationFromId = $orgFrom->organization_id;
                }
            }
            
            if ($request->has('organization_to_name') && $request->input('organization_to_name')) {
                $orgTo = Organization::where('name', $request->input('organization_to_name'))->first();
                if ($orgTo) {
                    $organizationToId = $orgTo->organization_id;
                }
            }
            
            $requestModel->update([
                'request_number' => $request->input('request_number', $requestModel->request_number),
                'status' => $request->input('status', $requestModel->status),
                'organization_from_id' => $organizationFromId,
                'departure_city_id' => $request->input('departure_city_id', $requestModel->departure_city_id),
                'address_from' => $request->input('address_from', $requestModel->address_from),
                'notes_from' => $request->input('notes_from', $requestModel->notes_from),
                'organization_to_id' => $organizationToId,
                'arrival_city_id' => $request->input('arrival_city_id', $requestModel->arrival_city_id),
                'address_to' => $request->input('address_to', $requestModel->address_to),
                'notes_to' => $request->input('notes_to', $requestModel->notes_to),
                'departure_datetime' => $request->input('departure_datetime', $requestModel->departure_datetime),
                'arrival_datetime' => $request->input('arrival_datetime', $requestModel->arrival_datetime),
                'auto_id' => $request->input('auto_id', $requestModel->auto_id),
                'driver_id' => $request->input('driver_id', $requestModel->driver_id),
                'responsible_person_id' => $request->input('responsible_person_id', $requestModel->responsible_person_id),
                'attorney_for_driver' => $request->input('attorney_for_driver', $requestModel->attorney_for_driver),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно обновлена',
                'data' => $requestModel
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/v1/requests/{id}
     */
    public function destroy(string $id)
    {
        try {
            $requestModel = RequestModel::findOrFail($id);
            $requestModel->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно удалена'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
