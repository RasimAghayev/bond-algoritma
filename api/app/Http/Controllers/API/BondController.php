<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bond;

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
        return response()->json($bonds);
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
            'nominal_price' => 'required|max:255',
            'frequency_payment_coupons' => 'required|max:255',
            'period_for_calculating_interest' => 'required',
            'coupon_interest' => 'required|max:255',
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
      
          return response()->json($newBond);
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
        return response()->json($bond);
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
            'emisia_date' => 'required|max:255',
            'turnover_date' => 'required|max:255',
            'nominal_price' => 'required|max:255',
            'frequency_payment_coupons' => 'required|max:255',
            'period_for_calculating_interest' => 'required',
            'coupon_interest' => 'required|max:255',
          ]);
    
            $bond->emisia_date = $request->get('emisia_date'); 
            $bond->turnover_date = $request->get('turnover_date');
            $bond->nominal_price = $request->get('nominal_price');
            $bond->frequency_payment_coupons = $request->get('frequency_payment_coupons');
            $bond->period_for_calculating_interest =$request->get('period_for_calculating_interest');
            $bond->coupon_interest = $request->get('coupon_interest');
      
          $bond->save();
      
          return response()->json($bond);
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

        return response()->json($bond::all());
    }
}
