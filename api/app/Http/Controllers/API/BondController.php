<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use App\Enums\FrequencyPaymentCoupons;
//use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use App\Models\Bond;
use App\Http\Resources\BondResource;

class BondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bonds = Bond::all();
        return response(['bonds' => BondResource::collection($bonds)]);
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
            'emisia_date' => 'required|date_format:Y-m-d',
            'turnover_date' => 'required|date_format:Y-m-d',
            'nominal_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
//            'frequency_payment_coupons' => [new Enum(FrequencyPaymentCoupons::class)],
            'frequency_payment_coupons' => 'required|in:1, 2, 4, 12',
//            'period_for_calculating_interest' => [new Enum(PeriodForCalculatingInterest::class)],
            'period_for_calculating_interest' => 'required|in:360, 364, 365',
            'coupon_interest' => 'required|integer|between:0,100',
          ]);

          $newBond = new Bond([
            'emisia_date' => $request->get('emisia_date'), //Y-m-d
            'turnover_date' => $request->get('turnover_date'),//Y-m-d
            'nominal_price' => $request->get('nominal_price'),//digit
            'frequency_payment_coupons' => $request->get('frequency_payment_coupons'),//1, 2, 4, 12
            'period_for_calculating_interest' =>$request->get('period_for_calculating_interest'),//360, 364, 365
            'coupon_interest' => $request->get('coupon_interest'),//0-100
          ]);

          $newBond->save();
          return response(['bound' => new BondResource($newBond), 'message' => 'Bond created successfully']);
//          return response()->json($newBond);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bond = Bond::findOrFail($id);
        return response(['bound' => new BondResource($bond)]);
//        return response()->json($bond);
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
        $bond = Bond::findOrFail($id);
        $request->validate([
            'emisia_date' => 'required|date_format:Y-m-d',
            'turnover_date' => 'required|date_format:Y-m-d',
            'nominal_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
//            'frequency_payment_coupons' => [new Enum(FrequencyPaymentCoupons::class)],
            'frequency_payment_coupons' => 'required|in:1, 2, 4, 12',
//            'period_for_calculating_interest' => [new Enum(PeriodForCalculatingInterest::class)],
            'period_for_calculating_interest' => 'required|in:360, 364, 365',
            'coupon_interest' => 'required|integer|between:0,100',
          ]);

            $bond->emisia_date = $request->get('emisia_date');
            $bond->turnover_date = $request->get('turnover_date');
            $bond->nominal_price = $request->get('nominal_price');
            $bond->frequency_payment_coupons = $request->get('frequency_payment_coupons');
            $bond->period_for_calculating_interest =$request->get('period_for_calculating_interest');
            $bond->coupon_interest = $request->get('coupon_interest');

          $bond->save();

//          return response()->json($bond);
        return response(['bound' => new BondResource($bond), 'message' => 'Bond updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bond = Bond::findOrFail($id);
        $bond->delete();
//        return response()->json($bond::all());
        return response(['bound' => $id, 'message' => 'Bond deleted successfully']);
    }
}
