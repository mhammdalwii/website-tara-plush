<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Balita::with(['user', 'measurements']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $balitas = $query->latest()->paginate(10);

        $data = $balitas->map(function ($balita) {
            // Data pengukuran dari balitas table
            $firstMeasurement = [
                'id' => $balita->id, // pakai id balita supaya tidak null
                'balita_id' => $balita->id,
                'measurement_date' => $balita->measurement_date,
                'height' => $balita->height,
                'weight' => $balita->weight,
                'arm_circumference' => $balita->arm_circumference,
                'head_circumference' => $balita->head_circumference,
                'created_at' => $balita->created_at,
                'updated_at' => $balita->updated_at,
            ];

            // Data dari balita_measurements
            $measurements = $balita->measurements->sortBy('measurement_date')->values();

            // Gabungkan pengukuran pertama + measurements tambahan
            $allMeasurements = collect([$firstMeasurement])->merge($measurements);

            return [
                'id' => $balita->id,
                'name' => $balita->name,
                'date_of_birth' => $balita->date_of_birth,
                'gender' => $balita->gender,
                'address' => $balita->address,
                'parent' => $balita->user ? [
                    'id' => $balita->user->id,
                    'name' => $balita->user->name,
                ] : null,
                'first_measurement' => $allMeasurements->first(),
                'last_measurement' => $allMeasurements->last(),
                'measurements' => $allMeasurements,
            ];
        });

        return response()->json([
            'data' => $data,
            'links' => [
                'first' => $balitas->url(1),
                'last' => $balitas->url($balitas->lastPage()),
                'prev' => $balitas->previousPageUrl(),
                'next' => $balitas->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $balitas->currentPage(),
                'from' => $balitas->firstItem(),
                'last_page' => $balitas->lastPage(),
                'per_page' => $balitas->perPage(),
                'to' => $balitas->lastItem(),
                'total' => $balitas->total(),
            ]
        ]);
    }


    // Endpoint detail measurements tetap ada
    public function measurements(Balita $balita)
    {
        $balita->load('user');

        $measurements = $balita->measurements()->orderBy('measurement_date')->get();

        return response()->json([
            'data' => [
                'id' => $balita->id,
                'name' => $balita->name,
                'date_of_birth' => $balita->date_of_birth,
                'gender' => $balita->gender,
                'address' => $balita->address,
                'parent' => $balita->user ? [
                    'id' => $balita->user->id,
                    'name' => $balita->user->name,
                ] : null,
                'first_measurement' => $measurements->first(),
                'last_measurement' => $measurements->last(),
                'measurements' => $measurements,
            ]
        ]);
    }
}
