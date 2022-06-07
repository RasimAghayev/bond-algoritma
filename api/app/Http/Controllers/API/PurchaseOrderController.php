<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseOrder = PurchaseOrder::all();
//        return response()->json($purchaseOrder);
        return response(['purchaseorderresources' => PurchaseOrderResource::collection($purchaseOrder)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'order_date' => 'required|date_format:Y-m-d',
            'number_bonds_received' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $newPurchaseOrder = new PurchaseOrder([
            'order_date' => $request->get('order_date'), //Y-m-d
            'number_bonds_received' => $request->get('number_bonds_received'),//digit
        ]);

        $newPurchaseOrder->save();

//        return response()->json($newPurchaseOrder);
          return response(['purchaseorderresource' => new PurchaseOrderResource($newPurchaseOrder),
              'message' => 'PurchaseOrder created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
//        return response()->json($purchaseOrder);
        return response(['purchaseorderresource' => PurchaseOrderResource::collection($purchaseOrder)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $request->validate([
            'order_date' => 'required|date_format:Y-m-d',
            'number_bonds_received' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $purchaseOrder->order_date = $request->get('order_date');
        $purchaseOrder->number_bonds_received = $request->get('number_bonds_received');

        $purchaseOrder->save();

//        return response()->json($purchaseOrder);
        return response(['purchaseorderresource' => new PurchaseOrderResource($purchaseOrder),
            'message' => 'PurchaseOrder updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bond = PurchaseOrder::findOrFail($id);
        $bond->delete();
//        return response()->json($bond::all());
        return response(['purchaseorderresource' => $id, 'message' => 'PurchaseOrder deleted successfully']);
    }
}
