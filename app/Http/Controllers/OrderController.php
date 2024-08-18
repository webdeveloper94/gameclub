<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Porder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order_id = $request->query('order_id');
        $game_number = $request->query('game_number');
        $user = Auth::user();
        $orders = Order::where('id', $order_id)->where('user_id', $user->id)->get();
        $porders = Porder::where('order_id', $order_id)->where('user_id', $user->id)->get();
        return view('total', [
            'orders' => $orders,
            'porders' => $porders,
            'game_number' => $game_number
        ]);

        //return view('total');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        $user = Auth::id();
        $game_id = $game->id;
        $start_time = $game->start_time;
        $end_time = $game->end_time;
        $status = 'ochiq';

        $start_time = Carbon::parse($game->start_time);
        $end_time = Carbon::parse($game->end_time);
        $game_summ = $end_time->diffInHours($start_time)*-($game->price);
        //dd();

        $order = new Order();
        $order -> user_id = $user;
        $order -> game_id = $game_id;
        $order -> start_time = $start_time;
        $order -> end_time = $end_time;
        $order -> status = $status;
        $order -> game_summ = $game_summ;
        $order->save();
        return Redirect::route('dashboard');


        //dd($game_id);
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
