<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function showQrCode(Student $student)
    {
        $qrCode = QrCode::size(200)->generate($student->qr_code);
        return view('admin.students.qrcode', compact('student', 'qrCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'student_id' => 'required|string|unique:students',
        ]);

        $qrCode = uniqid('student_');
        $validated['qr_code'] = $qrCode;

        $student = Student::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant créé avec succès');
    }
}
