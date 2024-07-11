<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ArticleExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    protected array $statuses = ['published', 'draft'];

    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'article-' . now()->format('Y-m-d');

        $start = request('start');
        $end = request('end');
        $articles = Article::when($start, function ($query) use ($start) {
            return $query->where('created_at', '>=', $start);
        })
            ->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new ArticleExport($articles), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.article', [
                'articles' => $articles
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

        $articles = Article::when($start, function ($query) use ($start) {
            return $query->where('created_at', '>=', $start);
        })
            ->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.article', [
            'articles' => $articles,
            'start' => $start,
            'end' => $end,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');
        $statuses = $this->statuses;

        $articles = Article::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(10)->withQueryString();

        return view('admins.articles.index', [
            'articles' => $articles,
            'statuses' => $statuses,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = $this->statuses;

        return view('admins.articles.create', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        $article = Article::create($validated);
        $filename = $request->file('photo')->store('media/articles');
        $article->photo = $filename;
        $article->save();

        return redirect()
            ->route('admins.articles.index')
            ->with('success', __('Berhasil menambahkan artikel' . ' ' . $article->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $statuses = $this->statuses;

        return view('admins.articles.edit', [
            'article' => $article,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->except('photo'));

        if ($request->hasFile('photo')) {
            if ($article->photo) Storage::delete($article->photo);

            $filename = $request->file('photo')->store('media/articles');
            $article->photo = $filename;
            $article->save();
        }

        return redirect()
            ->route('admins.articles.index')
            ->with('success', __('Berhasil mengupdate artikel' . ' ' . $article->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admins.articles.index')
            ->with('success', __('Berhasil menghapus artikel' . ' ' . $article->title));
    }
}
