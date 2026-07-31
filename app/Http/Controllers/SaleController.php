<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Medicine;
use App\Services\SaleService;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Exception;

class SaleController extends Controller
{

    public function __construct(protected SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = $this->saleService->getAll(Auth::user());
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', true)->get();
        $medicines = Medicine::where('status', true)->get();
        return view('sales.create', compact('customers', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        try { 
            $sale = $this->saleService->create($request->validated());

            return redirect()
                ->route('sales.show', $sale)
                ->with('success', 'Sale created successfully.');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'stock' => $e->getMessage()
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale = $this->saleService->getById($sale->id);

        if (auth()->user()->isCashier() && $sale->user_id !== auth()->id()) {
            abort(403);
        }

        return view('sales.show', compact('sale'));
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
