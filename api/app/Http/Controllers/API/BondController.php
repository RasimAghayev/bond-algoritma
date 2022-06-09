<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use App\Enums\FrequencyPaymentCoupons;
//use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use App\Models\Bond;
use App\Http\Resources\BondResource;
use Carbon\Carbon;
use DateTime;

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

    /**
     * payouts list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payouts($id){
        $bond = Bond::findOrFail($id);
        $date=[];
        $emisia_date= $bond->emisia_date;//  'emisia_date' Emissiya tarixi,
        $turnover_date= $bond->turnover_date;//  'turnover_date' Son tədavül tarix,
        $nominal_price= (double) $bond->nominal_price;//  'nominal_price' Nominal Qiymət,
        $period_for_calculating_interest=  (int) $bond->period_for_calculating_interest;//'period_for_calculating_interest' Kuponların ödənilmə tezliyi 1, 2, 4, 12
        $frequency_payment_coupons= (int) $bond->frequency_payment_coupons;// frequency_payment_coupons  Faizlərin hesablanma periodu 360, 364, 365,
        $coupon_interest= (int) $bond->coupon_interest; //  'coupon_interest' Kupon faizi,
        // $interest_accrual_period = match ($period_for_calculating_interest) {
        //     '364' => 364 / $frequency_payment_coupons,
        //     '360' => (12 / $frequency_payment_coupons) * 30,
        //     '365' => 12 / $frequency_payment_coupons,
        // };
        switch ($period_for_calculating_interest) {
            case 360:
              $interest_accrual_period = (12 / $frequency_payment_coupons) * 30;
              $month_or_day='day';
              break;
            case 364:
              $interest_accrual_period = 364/ $frequency_payment_coupons;
              $month_or_day='day';
              break;
            case 365:
              $interest_accrual_period = 12 / $frequency_payment_coupons;
              $month_or_day='month';
              break;
        }
        // $emisia_date_year =Carbon::createFromFormat('Y-m-d', $emisia_date)->year;
        // $turnover_date_year = Carbon::createFromFormat('Y-m-d', $turnover_date)->year;
        // $year_period=($turnover_date_year-$emisia_date_year+1)*$period_for_calculating_interest;

        $emisia_date1 = new DateTime($emisia_date);
        $turnover_date1 = new DateTime($turnover_date);
        $interval = $emisia_date1->diff($turnover_date1);
        $totalDays = $interval->format('%a');
        $yearsInMonths = $interval->format('%r%y') * 12;
        $months = $interval->format('%r%m');
        $totalMonths = $yearsInMonths + $months;
        $countPeriod=($month_or_day=='day')?$totalDays:$totalMonths;
//        $interest_accrual_period=$interest_accrual_period_day??$interest_accrual_period_month;
        for ($i = $interest_accrual_period; $i <= $countPeriod; $i++) {
            $percent_paid_date1=date("Y-m-d", strtotime($emisia_date . "+".$i." ".$month_or_day));
            $intervalDate = new DateTime($percent_paid_date1);
            $week_num = (int) $intervalDate->format("w");
            $nextMonday=(($week_num==6)?2:0) + (($week_num==0)?1:0);
            $percent_paid_date=($week_num==6 || $week_num==0)?date("Y-m-d", strtotime($percent_paid_date1 . "+".$nextMonday." day")):$percent_paid_date1;
//            $date[]=['period_for_calculating_interest'=>$week_num ,'oldDate'=>$percent_paid_date1,'date'=>$percent_paid_date];
            $date[]=['date'=>$percent_paid_date];
            $i=$i+$interest_accrual_period;
        }
//        return response(['bond'=>new BondResource($bond),'dates' => $date]);
         return response(['dates' =>$date]);
    }

}
