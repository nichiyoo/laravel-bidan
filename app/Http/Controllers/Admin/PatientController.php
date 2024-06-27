<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PatientExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'patient-' . now()->format('Y-m-d');

        if ($type == 'csv') {
            return Excel::download(new PatientExport, $filename . '.csv', ExcelType::CSV);
        } else {
            $data = Patient::all();
            $pdf = Pdf::loadView('reports.patient', ['patients' => $data]);
            return $pdf->setPaper('auto', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $patients = Patient::with('user')
            ->orderBy('id')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.patient', [
            'patients' => $patients,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = request('name');

        $patients = Patient::with('user')
            ->withCount([
                'appointments as total',
                'appointments as cancelled' => function ($query) {
                    return $query->where('status', 'cancelled');
                },
            ])
            ->when($name, function ($query) use ($name) {
                return $query->whereHas('user', function ($query) use ($name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admins.patients.index', [
            'patients' => $patients,
            'name' => $name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::doesntHave('patient')
            ->where('role', 'patient')
            ->select('id', 'name')
            ->get();

        $genders = [
            'male' => __('Laki-laki'),
            'female' => __('Perempuan'),
        ];

        return view('admins.patients.create', [
            'users' => $users,
            'genders' => $genders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();
        $patient = Patient::create($validated);

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil menambahkan patient' . ' ' . $patient->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $genders = [
            'male' => __('Laki-laki'),
            'female' => __('Perempuan'),
        ];

        return view('admins.patients.edit', [
            'patient' => $patient,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validated = $request->validated();
        $patient->update($validated);

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil mengupdate patient' . ' ' . $patient->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil menghapus patient' . ' ' . $patient->name));
    }
}
