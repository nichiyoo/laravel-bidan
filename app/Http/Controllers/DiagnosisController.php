<?php

namespace App\Http\Controllers;

use App\Exports\DiagnosisExport;
use App\Models\Appointment;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class DiagnosisController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'appointment-' . now()->format('Y-m-d');

        $start = request('start');
        $end = request('end');
        $diagnoses = Diagnosis::with('appointment.patient.user', 'appointment.service')
            ->when($start, function ($query) use ($start) {
                return $query->whereHas('appointment', function ($query) use ($start) {
                    return $query->where('date', '>=', $start);
                });
            })
            ->when($end, function ($query) use ($end) {
                return $query->whereHas('appointment', function ($query) use ($end) {
                    return $query->where('date', '<=', $end);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new DiagnosisExport($diagnoses), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.diagnosis', [
                'diagnoses' => $diagnoses
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $start = request('start');
        $end = request('end');

        $diagnoses = Diagnosis::with('appointment.patient.user', 'appointment.service')
            ->when($start, function ($query) use ($start) {
                return $query->whereHas('appointment', function ($query) use ($start) {
                    return $query->where('date', '>=', $start);
                });
            })
            ->when($end, function ($query) use ($end) {
                return $query->whereHas('appointment', function ($query) use ($end) {
                    return $query->where('date', '<=', $end);
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.diagnosis', [
            'diagnoses' => $diagnoses,
            'start' => $start,
            'end' => $end,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $start = request('start');
        $end = request('end');

        $user = auth()->user();
        $diagnoses = Diagnosis::with('appointment.service', 'appointment.patient.user')
            ->withCount(['appointment as appointments_count' => function ($query) {
                $query->withCount('patient');
            }])
            ->when($user, function ($query) use ($user) {
                return $query->whereHas('appointment', function ($query) use ($user) {
                    return $query->whereHas('patient', function ($query) use ($user) {
                        return $user->role === 'admin' ? $query : $query->where('user_id', $user->id);
                    });
                });
            })
            ->when($start, function ($query) use ($start) {
                return $query->where('appointment.date', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('appointment.date', '<=', $end);
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('patients.diagnoses.index', [
            'diagnoses' => $diagnoses,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Appointment $appointment)
    {
        if ($appointment->status !== 'confirmed') {
            return redirect()->route('patients.diagnoses.index', $appointment)
                ->with('error', __('Tidak dapat menambahkan diagnosa, periksa appointment status'));
        }

        return view('admins.diagnoses.create', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'confirmed') {
            return redirect()->route('patients.diagnoses.index', $appointment)
                ->with('error', __('Tidak dapat menambahkan diagnosa, periksa appointment status'));
        }

        $diagnosis = Diagnosis::create([
            'detail' => $request->get('detail'),
            'appointment_id' => $appointment->id,
        ]);

        $appointment->status = 'finished';
        $appointment->save();

        return redirect()->route('patients.diagnoses.index', $appointment)
            ->with('success', __('Berhasil menambahkan diagnosis' . ' ' . $appointment->patient->user->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosis $diagnosis)
    {
        $user = $diagnosis->appointment->patient->user;
        if (auth()->user()->role !== 'admin' && $user->id !== auth()->user()->id) {
            return redirect()->route('patients.diagnoses.index', $diagnosis)
                ->with('error', __('Tidak dapat melihat diagnosa, hanya user terkait dapat melihatnya'));
        }

        return view('patients.diagnoses.show', [
            'diagnosis' => $diagnosis,
            'appointment' => $diagnosis->appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {
        return view('admins.diagnoses.edit', [
            'diagnosis' => $diagnosis,
            'appointment' => $diagnosis->appointment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diagnosis $diagnosis)
    {
        $diagnosis->update($request->only('detail'));

        return redirect()->route('patients.diagnoses.index', $diagnosis)
            ->with('success', __('Berhasil mengubah diagnosa' . ' ' . $diagnosis->appointment->patient->user->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}
