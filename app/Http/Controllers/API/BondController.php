<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BondResource;
use App\Modules\Bond\Http\Requests\BondStoreRequest;
use App\Modules\Bond\Http\Requests\BondUpdateRequest;
use App\Modules\Bond\Services\BondPricingService;
use App\Models\Bond;
use Illuminate\Http\Request;

class BondController extends Controller
{
    public function __construct(private BondPricingService $pricingService)
    {
    }

    public function index()
    {
        $bonds = Bond::withCount('purchaseOrders')->get();
        return response(['bonds' => BondResource::collection($bonds)]);
    }

    public function store(BondStoreRequest $request)
    {
        $bond = Bond::create($request->validated());
        return response(['bond' => new BondResource($bond), 'message' => 'Bond created successfully']);
    }

    public function show(Bond $bond)
    {
        $bond->load('purchaseOrders');
        return response(['bond' => new BondResource($bond)]);
    }

    public function update(BondUpdateRequest $request, Bond $bond)
    {
        $bond->update($request->validated());
        return response(['bond' => new BondResource($bond), 'message' => 'Bond updated successfully']);
    }

    public function destroy(Bond $bond)
    {
        $bond->delete();
        return response(['bond' => $bond->id, 'message' => 'Bond deleted successfully']);
    }

    public function payouts(int $id, Request $request)
    {
        $bond = Bond::findOrFail($id);
        $dates = $this->pricingService->calculatePayoutDates($bond);
        $asArray = filter_var($request->query('arr', 'false'), FILTER_VALIDATE_BOOLEAN);
        return $asArray ? $dates : response(['dates' => $dates]);
    }

    public function order(int $id)
    {
        $payouts = $this->pricingService->calculateOrderPayouts($id);
        return response(['payouts' => $payouts]);
    }
}
