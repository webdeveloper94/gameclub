<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'summa' => 'required|numeric|min:1',
        ]);

        $payment = new Payment();
        $payment->user_id = $request->user_id;
        $payment->summa = $request->summa;
        $payment->payment_date = Carbon::now();
        $payment->save();

        return redirect()->route('admin.dashboard')->with('success', 'To\'lov muvaffaqiyatli qo\'shildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(Request $request)
    {
        // So'rovda yuborilgan to'lov ID'larini olish
        $paymentIds = $request->input('payments', []);

        if (empty($paymentIds)) {
            return response()->json(['success' => false, 'message' => 'Tanlangan to\'lovlar mavjud emas.']);
        }

        // To'lovlarni statusini yangilash
        DB::table('payments')
            ->whereIn('id', $paymentIds)
            ->update(['status' => false]);

            return redirect()->back()->with('status', 'To\'lovlar muvaffaqiyatli bekor qilindi.');
    }
}
