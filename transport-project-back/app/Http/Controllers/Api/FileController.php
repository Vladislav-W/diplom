<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $files = FileModel::all();
            return response()->json([
                'success' => true,
                'data' => $files
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
            \Log::info('File upload request:', [
                'request_id' => $request->input('request_id'),
                'has_file' => $request->hasFile('file'),
            ]);

            $request->validate([
                'request_id' => 'required|integer',
                'file' => 'required|file|max:10240', // максимум 10MB
            ]);

            $uploadedFile = $request->file('file');

            // Читаем содержимое файла
            $fileData = file_get_contents($uploadedFile->getRealPath());

            \Log::info('File data:', [
                'file_name' => $uploadedFile->getClientOriginalName(),
                'file_type' => $uploadedFile->getMimeType(),
                'file_size' => $uploadedFile->getSize(),
                'data_length' => strlen($fileData),
            ]);

            $file = FileModel::create([
                'request_id' => $request->input('request_id'),
                'file_name' => $uploadedFile->getClientOriginalName(),
                'file_type' => $uploadedFile->getMimeType(),
                'file_data' => $fileData,
                'file_size' => $uploadedFile->getSize(),
            ]);

            \Log::info('File created:', ['file_id' => $file->file_id]);

            return response()->json([
                'success' => true,
                'message' => 'Файл успешно загружен',
                'data' => [
                    'file_id' => $file->file_id,
                    'file_name' => $file->file_name,
                    'file_type' => $file->file_type,
                    'file_size' => $file->file_size
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('File upload error:', ['message' => $e->getMessage()]);
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
            $file = FileModel::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'file_id' => $file->file_id,
                    'request_id' => $file->request_id,
                    'file_name' => $file->file_name,
                    'file_type' => $file->file_type,
                    'file_size' => $file->file_size,
                    'created_at' => $file->created_at
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Файл не найден'
            ], 404);
        }
    }

    /**
     * Download the specified resource.
     */
    public function download(string $id)
    {
        try {
            $file = FileModel::findOrFail($id);
            
            return response($file->file_data)
                ->header('Content-Type', $file->file_type)
                ->header('Content-Disposition', 'attachment; filename="' . $file->file_name . '"');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Файл не найден'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $file = FileModel::findOrFail($id);
            $file->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Файл успешно обновлён',
                'data' => $file
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
            $file = FileModel::findOrFail($id);
            $file->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Файл успешно удалён'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
