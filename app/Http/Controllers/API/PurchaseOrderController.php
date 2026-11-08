<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use App\Modules\PurchaseOrder\Http\Requests\PurchaseOrderStoreRequest;
use App\Modules\PurchaseOrder\Http\Requests\PurchaseOrderUpdateRequest;
use App\Models\Bond;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('bond')->get();
        return response(['purchase_orders' => PurchaseOrderResource::collection($purchaseOrders)]);
    }

    public function store(PurchaseOrderStoreRequest $request, int $id)
    {
        $validated = $request->validated();
        $bond = Bond::findOrFail($id);

        $orderDate = Carbon::parse($validated['order_date']);
        $emissionDate = Carbon::parse($bond->emisia_date);
        $turnoverDate = Carbon::parse($bond->turnover_date);

        if ($orderDate->lt($emissionDate)) {
            return response()->json([
                'bond' => $bond,
                'error' => 'Alış tarixi “Emissiya tarixi”-dən az ola bilməz.',
            ], 422);
        }
        if ($turnoverDate->lt($orderDate)) {
            return response()->json([
                'bond' => $bond,
                'error' => 'Alış tarixi “Son tədavül tarixi”-dən çox ola bilməz.',
            ], 422);
        }

        $purchaseOrder = PurchaseOrder::create(array_merge($validated, ['bond_id' => $id]));
        return response()->json([
            'purchase_order' => new PurchaseOrderResource($purchaseOrder),
            'message' => 'Purchase order created successfully',
        ]);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('bond');
        return response(['purchase_order' => new PurchaseOrderResource($purchaseOrder)]);
    }

    public function update(PurchaseOrderUpdateRequest $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update($request->validated());
        return response(['purchase_order' => new PurchaseOrderResource($purchaseOrder), 'message' => 'Purchase order updated successfully']);
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
        return response(['purchase_order' => $purchaseOrder->id, 'message' => 'Purchase order deleted successfully']);
    }
}
