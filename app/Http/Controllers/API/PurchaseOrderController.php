<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use App\Modules\PurchaseOrder\Http\Requests\PurchaseOrderStoreRequest;
use App\Modules\PurchaseOrder\Http\Requests\PurchaseOrderUpdateRequest;
use App\Models\Bond;
use App\Models\PurchaseOrder;
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

        if ($validated['order_date'] < $bond->emisia_date) {
            return response(['bond' => $bond, 'error' => 'Alış tarixi “Emissiya tarixi”-dən az ola bilməz.']);
        }
        if ($bond->turnover_date < $validated['order_date']) {
            return response(['bond' => $bond, 'error' => 'Alış tarixi “Son tədavül tarixi”-dən çox ola bilməz.']);
        }

        $purchaseOrder = PurchaseOrder::create(array_merge($validated, ['bond_id' => $id]));
        return response(['purchase_order' => new PurchaseOrderResource($purchaseOrder), 'message' => 'Purchase order created successfully']);
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
