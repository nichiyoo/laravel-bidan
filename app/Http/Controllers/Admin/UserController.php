<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'user-' . now()->format('Y-m-d');

        if ($type == 'csv') {
            return Excel::download(new UserExport, $filename . '.csv', ExcelType::CSV);
        } else {
            $users = User::all();
            $pdf = Pdf::loadView('reports.user', [
                'users' => $users
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $users = User::orderBy('id')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.user', [
            'users' => $users,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate(10)
            ->withQueryString();

        return view('admins.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = [
            'admin' => __('Administrator'),
            'patient' => __('Pasien'),
        ];

        return view('admins.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil menambahkan user' . ' ' . $user->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = [
            'admin' => __('Administrator'),
            'patient' => __('Pasien'),
        ];

        return view('admins.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user->update($validated);

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil mengupdate user' . ' ' . $user->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil menghapus user' . ' ' . $user->name));
    }
}
