<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
        ]);

        // Générer un ID étudiant unique
        $studentId = 'ETU' . str_pad(Student::count() + 1, 6, '0', STR_PAD_LEFT);
        $validated['student_id'] = $studentId;

        // Générer un QR code unique
        $qrCode = uniqid('student_');
        $validated['qr_code'] = $qrCode;

        $student = Student::create($validated);

        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|unique:students,email,' . $student->id,
        ]);

        $student->update($validated);

        return response()->json($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(null, 204);
    }

    public function getQrCode(Student $student)
    {
        $qrCode = QrCode::format('png')
            ->size(300)
            ->generate($student->qr_code);

        return response($qrCode)
            ->header('Content-Type', 'image/png');
    }
}
