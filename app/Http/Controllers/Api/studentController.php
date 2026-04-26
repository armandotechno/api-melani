<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        // if ($students->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron estudiantes',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 404);
        // }
        $data = [
            'message' => $students,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:student,email',
            'phone' => 'required|string|max:20',
            'language' => 'required|string|max:50',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);
        if (!$student) {
            return response()->json([
                'message' => 'Error al crear el estudiante',
                'data' => $student,
                'status' => 500
            ], 500);
        }
        $data = [
            'message' => 'Estudiante creado exitosamente',
            'data' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }
        $data = [
            'message' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }
        $student->delete();
        $data = [
            'message' => 'Estudiante eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:student,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'language' => 'sometimes|required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $student->update($request->only(['name', 'email', 'phone', 'language']));

        $data = [
            'message' => 'Estudiante actualizado exitosamente',
            'data' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:student,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'language' => 'sometimes|required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $student->update($request->only(['name', 'email', 'phone', 'language']));

        $data = [
            'message' => 'Estudiante actualizado exitosamente',
            'data' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
