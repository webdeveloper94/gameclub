<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Qo'shilgan qator
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = Auth::user();
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    if ($start_date && $end_date) {
        $orders = Order::whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)])
                        ->with(['game', 'porders'])
                        ->where('user_id', $user->id)
                        ->orderBy('id', 'desc') // ID bo'yicha kamayish tartibida saralash
                        ->get();
    } else {
        // If no date filters are provided, use today's date
        $today = Carbon::today();
        $orders = Order::whereDate('created_at', $today)
                        ->where('user_id', $user->id)
                        ->where('status', 'yopiq')
                        ->with(['game', 'porders'])
                        ->orderBy('id', 'desc') // ID bo'yicha kamayish tartibida saralash
                        ->get();
    }

    return view('reports', compact('orders'));
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
}
