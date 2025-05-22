<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Attendance::with(['student', 'course'])->get();
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
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'check_in' => 'required|date',
        ]);

        $attendance = Attendance::create($validated);

        return response()->json($attendance, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return $attendance->load(['student', 'course']);
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
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'student_id' => 'exists:students,id',
            'course_id' => 'exists:courses,id',
            'check_in' => 'date',
        ]);

        $attendance->update($validated);

        return response()->json($attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return response()->json(null, 204);
    }

    public function scanQrCode(Request $request)
    {
        $validated = $request->validate([
            'student_qr_code' => 'required|string|exists:students,qr_code',
            'course_qr_code' => 'required|string|exists:courses,qr_code',
        ]);

        $student = Student::where('qr_code', $validated['student_qr_code'])->first();
        $course = Course::where('qr_code', $validated['course_qr_code'])->first();

        // Check if attendance already exists for today
        $existingAttendance = Attendance::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->whereDate('check_in', now())
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'message' => 'Attendance already recorded for today'
            ], 400);
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'check_in' => now(),
        ]);

        return response()->json($attendance, 201);
    }
}
