<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User; // User modelini qo'shing
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $users = User::with(['payments' => function ($query) {
        $query->orderBy('id', 'desc')->where('status', true);
    }])->get();

    // Har bir foydalanuvchi uchun eng so'nggi to'lovni olish
    $users->each(function ($user) {
        $lastPayment = $user->payments->first();
        $user->last_payment = $lastPayment;
    });

    return view('admin.dashboard', compact('users'));
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
        //
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

    public function export($id)
{
    $payments = Payment::where('user_id', $id)->get();

    return Excel::download(new PaymentsExport($payments), 'payments.xlsx');
}
}
