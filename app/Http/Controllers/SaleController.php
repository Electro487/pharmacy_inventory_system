<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Support\Facades\Auth;
use Exception;

class SaleController extends Controller
{
    public function __construct(protected SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = $this->saleService->getAll(Auth::user());
        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale = $this->saleService->getById($sale->id);

        if (auth()->user()->isCashier() && $sale->user_id !== auth()->id()) {
            abort(403);
        }

        return view('sales.show', compact('sale'));
    }
}
