<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Bond;

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
    public function store(Request $request,$id)
    {

        $request->validate([
            'order_date' => 'required|date_format:Y-m-d',
            'number_bonds_received' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $order_date=$request->get('order_date');
        $bond = Bond::findOrFail($id);
        $emisia_date= $bond->emisia_date;
        $turnover_date= $bond->turnover_date;
        if($order_date<$emisia_date){
            return response(['bond'=>$bond,'error' => 'Alış tarixi “Emissiya tarixi”-dən az ola bilməz.']);
        }
        if($turnover_date<$order_date){
            return response(['bond'=>$bond,'error' => 'Alış tarix “Son tədavül tarixi”-dən cox ola bilməz.']);
        }
        $newPurchaseOrder = new PurchaseOrder([
            'bonds_id'=>$bond->id,
            'order_date' => $request->get('order_date'), //Y-m-d
            'number_bonds_received' => $request->get('number_bonds_received'),//digit
        ]);

        $newPurchaseOrder->save();

//        return response()->json($newPurchaseOrder);
          return response(['purchaseorder' => new PurchaseOrderResource($newPurchaseOrder),
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
