<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedRows = [10, 25, 50, 100];

        $perPage = (int) $request->get('rows', 25);

        if (!in_array($perPage, $allowedRows, true)) {
            $perPage = 25;
        }

        $search = trim(
            (string) $request->get('search', '')
        );

        $visitor = Visitor::query()
            ->select(['id', 'ip', 'date', 'country', 'city', 'state_name', 'lat', 'long',])
            ->when(
                $search !== '',
                function ($query) use ($search) {

                    $query->where(
                        function ($q) use ($search) {

                            $q->where('ip', 'like', "%{$search}%")
                                ->orWhere('country', 'like', "%{$search}%")
                                ->orWhere('city', 'like', "%{$search}%")
                                ->orWhere('state_name', 'like', "%{$search}%");
                        }
                    );
                }
            )

            ->orderByDesc('id')
            ->simplePaginate($perPage)
            ->withQueryString();

        return view('administrator.visitor.index', compact('visitor', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
