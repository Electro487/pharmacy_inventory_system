<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Medicine;
use App\Services\PurchaseService;
use App\Http\Requests\StorePurchaseRequest;

class PurchaseController extends Controller
{
    protected PurchaseService  $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = $this->purchaseService->getAll();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $medicines = Medicine::where('status', true)->orderBy('name')->get();

        return view('purchases.create', compact(
            'suppliers',
            'medicines'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $this->purchaseService->create($request->validated());

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase created successfully.');
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
