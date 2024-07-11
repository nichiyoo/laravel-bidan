<?php

namespace App\Http\Controllers;

use App\Exports\ReviewExport;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class ReviewController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'review-' . now()->format('Y-m-d');

        $start = request('start');
        $end = request('end');
        $reviews = Review::with('user')
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new ReviewExport($reviews), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.review', [
                'reviews' => $reviews
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

        $reviews = Review::with('user')
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.review', [
            'reviews' => $reviews,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serach = request('search');

        $user = request()->user();
        $reviews = Review::with('user')
            ->when($user, function ($query) use ($user) {
                return $user->role == 'admin' ? $query : $query->where('user_id', $user->id);
            })
            ->when($serach, function ($query) use ($serach) {
                return $query->where('title', 'like', '%' . $serach . '%');
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('patients.reviews.index', [
            'reviews' => $reviews,
            'search' => $serach,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'body' => $request->body,
            'action' => $request->action,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()
            ->route('patients.reviews.index')
            ->with('success', __('Berhasil menambahkan review' . ' ' . $review->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $user = request()->user();
        if ($user->role != 'admin' && $user->id != $review->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        return view('patients.reviews.show', [
            'review' => $review,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $statuses = ['processing', 'approved', 'rejected'];

        return view('patients.reviews.edit', [
            'review' => $review,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $validated = $request->validated();
        $review->update($validated);

        return redirect()
            ->route('patients.reviews.index')
            ->with('success', __('Berhasil mengupdate review' . ' ' . $review->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $user = request()->user();
        if ($user->role != 'admin' && $user->id != $review->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        $review->delete();

        return redirect()
            ->route('patients.reviews.index')
            ->with('success', __('Berhasil menghapus review' . ' ' . $review->title));
    }
}
