<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerPackage;
use App\Wallet;
use App\BusinessSetting;
use App\Reference;
use Auth;
use Session;
Use App\User;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\VoguePayController;

class CustomerPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_packages = CustomerPackage::all();
        return view('customer_packages.index',compact('customer_packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer_packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_package = new CustomerPackage;
        $customer_package->name = $request->name;
        $customer_package->amount = $request->amount;
        $customer_package->product_upload = $request->product_upload;
        if($request->hasFile('logo')){
            $customer_package->logo = $request->file('logo')->store('uploads/customer_package');
        }

        if($customer_package->save()){
            flash(__('Package has been inserted successfully'))->success();
            return redirect()->route('customer_packages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer_package = CustomerPackage::findOrFail(decrypt($id));
        return view('customer_packages.edit', compact('customer_package'));
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
        $customer_package = CustomerPackage::findOrFail($id);
        $customer_package->name = $request->name;
        $customer_package->amount = $request->amount;
        $customer_package->product_upload = $request->product_upload;
        if($request->hasFile('logo')){
            $customer_package->logo = $request->file('logo')->store('uploads/customer_package');
        }

        if($customer_package->save()){
            flash(__('Package has been updated successfully'))->success();
            return redirect()->route('customer_packages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer_package = CustomerPackage::findOrFail($id);
        if(CustomerPackage::destroy($id)){
            if($customer_package->logo != null){
                //unlink($customer_package->logo);
            }
            flash(__('Package has been deleted successfully'))->success();
            return redirect()->route('customer_packages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function purchase_package(Request $request)
    {
        $data['customer_package_id'] = $request->customer_package_id;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'package_payment');
        $request->session()->put('payment_data', $data);

        $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);

        if($customer_package->amount == 0){
            $user = User::findOrFail(Auth::user()->id);
            if($user->customer_package_id != $customer_package->id){
                return $this->purchase_payment_done(Session::get('payment_data'), null);
            }
            else {
                flash(__('You can not purchase this package anymore.'))->warning();
                return back();
            }
        }

        if($request->payment_option == 'paypal'){
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }
        elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->stripe();
        }
        elseif ($request->payment_option == 'sslcommerz_payment') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
        elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        }
        elseif ($request->payment_option == 'razorpay') {
            $razorpay = new RazorpayController;
            return $razorpay->payWithRazorpay($request);
        }
        elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        }
    }

    public function purchase_payment_done($payment_data, $payment){
        $user = User::findOrFail(Auth::user()->id);
        $user->customer_package_id = Session::get('payment_data')['customer_package_id'];
        $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
        $user->remaining_uploads += $customer_package->product_upload;
        $user->save();

        flash(__('Package purchasing successful'))->success();
        return redirect()->route('dashboard');
    }
}
