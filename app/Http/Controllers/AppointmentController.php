<?php

namespace App\Http\Controllers;

use App\Exports\AppointmentExport;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    protected array $statuses = ['pending', 'confirmed', 'cancelled', 'finished'];
    protected array $hours;

    public function __construct()
    {
        $open = (int) env('APPOINTMENT_OPEN');
        $close = (int) env('APPOINTMENT_CLOSE');

        $this->hours = array_map(function ($hour) {
            return Carbon::createFromFormat('H:i', $hour . ':00')->format('H:i');
        }, range($open, $close));
    }

    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'appointment-' . now()->format('Y-m-d');

        $start = request('start');
        $end = request('end');
        $appointments = Appointment::with('patient.user', 'service', 'payment')
            ->when($start, function ($query) use ($start) {
                return $query->where('date', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('date', '<=', $end);
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new AppointmentExport($appointments), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.appointment', [
                'appointments' => $appointments
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

        $appointments = Appointment::with('patient.user', 'service', 'payment')
            ->when($start, function ($query) use ($start) {
                return $query->where('date', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('date', '<=', $end);
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.appointment', [
            'appointments' => $appointments,
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

        $status = request('status');
        $statuses = $this->statuses;

        $user = request()->user();
        $appointments = Appointment::with('patient.user', 'service')
            ->when($user, function ($query) use ($user) {
                return $query->whereHas('patient', function ($query) use ($user) {
                    return $user->role === 'admin' ? $query : $query->where('user_id', $user->id);
                });
            })
            ->when($start, function ($query) use ($start) {
                return $query->where('date', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('date', '<=', $end);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('patients.appointments.index', [
            'appointments' => $appointments,
            'statuses' => $statuses,
            'status' => $status,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $patient = request()->user()->patient;
        if (!$patient) {
            return redirect()->route('patients.profile.edit')
                ->with('error', __('Lengkapi profil untuk mulai membuat Janji'));
        }

        $min = Carbon::now()->addDay()->format('Y-m-d');
        $max = Carbon::now()->addMonth()->format('Y-m-d');

        $validated = $request->validate([
            'date' => ['nullable', 'date', 'after:tommorow', 'before:+1 month'],
        ]);

        $date = $validated['date'] ?? Carbon::now()->addDay()->format('Y-m-d');
        $appointments = Appointment::where('date', $date)->get();

        $services = Service::all();
        $payments = Payment::all();
        $frequencies = [
            'none',
            'every hour',
            'every 6 hours',
            'every 12 hours',
            'every day',
            'every 2 days',
            'every week',
        ];

        $timetable = array_combine(
            $this->hours,
            array_map(function ($hour) use ($appointments) {
                $filled = $appointments->first(function ($appointment) use ($hour) {
                    return $appointment->time == $hour && in_array($appointment->status, ['pending', 'confirmed']);
                });
                return $filled ? false : true;
            }, $this->hours)
        );

        return view('patients.appointments.create', [
            'frequencies' => $frequencies,
            'timetable' => $timetable,
            'services' => $services,
            'payments' => $payments,
            'date' => $date,
            'min' => $min,
            'max' => $max,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $filled = Appointment::where('date', $request->date)
            ->where('time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($filled) {
            return redirect()
                ->back()
                ->with('error', __('Tanggal dan waktu yang dipilih sudah terisi'));
        }

        $appointment = Appointment::create([
            'patient_id' => request()->user()->patient->id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
            'code' => rand(100, 999),
            'service_id' => $request->service_id,
            'payment_id' => $request->payment_id,
        ]);

        Notification::create([
            'frequency' => $request->frequency,
            'appointment_id' => $appointment->id,
        ]);

        return redirect()
            ->route('patients.appointments.index')
            ->with('success', __('Berhasil menambahkan Janji'));
    }

    /**
     * Add payment receipt to appointment.
     */

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $user = request()->user();
        $patient = $appointment->patient;
        if ($user->role != 'admin' && $user->id != $patient->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        $appointment->load('service', 'patient.user', 'notification', 'payment');

        return view('patients.appointments.show', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $user = request()->user();
        $patient = $appointment->patient;
        if ($user->role != 'admin' && $user->id != $patient->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        if ($appointment->status != 'pending') {
            return redirect()
                ->back()
                ->with('error', __('Tidak dapat melakukan pembayaran, melewati batas waktu'));
        }

        $timeout = (int) env('APPOINTMENT_TIMEOUT');

        return view('patients.appointments.edit', [
            'appointment' => $appointment->load('service', 'patient.user'),
            'timeout' => $timeout,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $user = request()->user();
        $patient = $appointment->patient;
        if ($user->role != 'admin' && $user->id != $patient->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat mengubah Janji ini'));
        }

        if ($appointment->status != 'pending') {
            return redirect()
                ->back()
                ->with('error', __('Tidak dapat melakukan pembayaran, melewati batas waktu'));
        }

        $filename = $request->file('receipt')->store('media/receipts');
        $appointment->receipt = $filename;
        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()
            ->route('patients.appointments.index')
            ->with('success', __('Berhasil menambah pembayaran Janji'));
    }

    /**
     * Cancel appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $user = request()->user();
        $patient = $appointment->patient;
        if ($user->role != 'admin' && $user->id != $patient->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat menghapus Janji ini'));
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()
            ->route('patients.appointments.index')
            ->with('success', __('Berhasil membatalkan Janji'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // disabled
    }
}
