<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();

        $receipts = Appointment::with('patient.user', 'service', 'payment')
            ->when($user, function ($query) use ($user) {
                return $query->whereHas('patient', function ($query) use ($user) {
                    return $user->role === 'admin' ? $query : $query->where('user_id', $user->id);
                });
            })
            ->orderBy('date', 'asc')
            ->paginate(10)
            ->withQueryString();



        $sums = DB::table('appointments')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->selectRaw('appointments.status, sum(appointments.code) + sum(services.price) as sum')
            ->when($user, function ($query) use ($user) {
                return $user->role == 'admin' ? $query : $query->where('patients.user_id', $user->id);
            })
            ->groupBy('appointments.status')
            ->get();

        return view('patients.receipts.index', [
            'receipts' => $receipts,
            'sums' => $sums,
        ]);
    }
}
