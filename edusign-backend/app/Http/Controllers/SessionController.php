<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Course;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $sessions = Session::with(['course', 'attendances'])->get();
        return view('admin.sessions.index', compact('courses', 'sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.sessions.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $qrCode = uniqid('session_');
        $validated['qr_code'] = $qrCode;

        $session = Session::create($validated);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Séance créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        $session->load(['course', 'attendances.student']);
        return view('admin.sessions.show', compact('session'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getQrCode(Session $session)
    {
        // Générer le QR code au format PNG avec la valeur unique de la séance
        $qrCode = \QrCode::format('png')->size(300)->generate($session->qr_code);
        return response($qrCode)->header('Content-Type', 'image/png');
    }

    public function scanQrCode(Request $request)
    {
        $validated = $request->validate([
            'session_qr_code' => 'required|string|exists:sessions,qr_code',
            'student_id' => 'required|exists:students,id',
        ]);

        $session = Session::where('qr_code', $validated['session_qr_code'])->first();

        // Vérifier si la séance est en cours
        $now = now();
        if ($now < $session->start_time || $now > $session->end_time) {
            return response()->json([
                'message' => 'La séance n\'est pas en cours'
            ], 400);
        }

        // Vérifier si l'étudiant a déjà marqué sa présence
        $existingAttendance = $session->attendances()
            ->where('student_id', $validated['student_id'])
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'message' => 'Présence déjà enregistrée'
            ], 400);
        }

        // Créer l'enregistrement de présence
        $attendance = $session->attendances()->create([
            'student_id' => $validated['student_id'],
            'check_in' => now(),
        ]);

        return response()->json([
            'message' => 'Présence enregistrée avec succès',
            'attendance' => $attendance
        ]);
    }
}
