<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequests;

class ProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $patient = request()->user()->patient;
        $genders = [
            'male' => __('Laki-laki'),
            'female' => __('Perempuan'),
        ];

        return view('patients.profile.edit', [
            'patient' => $patient,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequests $request)
    {
        $validated = $request->validated();
        $patient = request()->user()->patient;

        if ($patient) {
            $patient->update($validated);
            $patient->save();
        } else {
            $patient = request()->user()
                ->patient()
                ->create($validated);
        }

        return redirect()->back()
            ->with('success', __('Berhasil mengupdate profil' . ' ' . request()->user()->name));
    }
}
