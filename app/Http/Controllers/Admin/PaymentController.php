<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'payment-' . now()->format('Y-m-d');

        if ($type == 'csv') {
            return Excel::download(new PaymentExport, $filename . '.csv', ExcelType::CSV);
        } else {
            $payments = Payment::all();
            $pdf = Pdf::loadView('reports.payment', [
                'payments' => $payments
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $payments = Payment::orderBy('id')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.payment', [
            'payments' => $payments,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $payments = Payment::when($search, function ($query) use ($search) {
            return $query->where('account', 'like', '%' . $search . '%');
        })->paginate(10)->withQueryString();

        return view('admins.payments.index', [
            'payments' => $payments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        $payment = Payment::create($validated);

        return redirect()
            ->route('admins.payments.index')
            ->with('success', __('Berhasil menambahkan payment' . ' ' . $payment->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('admins.payments.edit', [
            'payment' => $payment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();
        $payment->update($validated);

        return redirect()
            ->route('admins.payments.index')
            ->with('success', __('Berhasil mengupdate payment' . ' ' . $payment->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admins.payments.index')
            ->with('success', __('Berhasil menghapus payment' . ' ' . $payment->title));
    }
}
