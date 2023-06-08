<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::all();
        return response()->json($payment_methods);
    }

    public function show($id)
    {
        $payment_method = PaymentMethod::find($id);
        return response()->json($payment_method);
    }

    public function store(Request $request)
    {
        $payment_method = PaymentMethod::create($request->all());
        return response()->json($payment_method);
    }

    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->update($request->all());
        return response()->json($payment_method);
    }

    public function destroy($id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->delete();
        return response()->json(['message' => 'Payment method deleted']);
    }
}
