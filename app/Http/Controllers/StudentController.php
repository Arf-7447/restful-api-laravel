<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'List of all students',
            'data' => $students,
        ], 200);
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
        ]);

        $student = Student::create($request->all());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Student successfully created',
            'data' => $student,
        ], 201);
    }

    // Show specific student
    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Student found',
                'data' => $student,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Student not found',
            ], 404);
        }
    }

    // Update existing student
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if ($student) {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:students,email,' . $id,
                'phone' => 'sometimes|required|string|max:15',
            ]);

            $student->update($request->all());

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Student successfully updated',
                'data' => $student,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Student not found',
            ], 404);
        }
    }

    // Delete specific student
    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Student successfully deleted',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Student not found',
            ], 404);
        }
    }
}
