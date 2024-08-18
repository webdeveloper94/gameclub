<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Porder;
use Illuminate\Support\Facades\Redirect;
class CloseController extends Controller
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
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');
        $hours_diff = $request->query('hours_diff');
        $price = $request->query('price');

        return view('view', [
            'orders' => $orders,
            'porders' => $porders,
            'game_number' => $game_number,
            'start_time' =>$start_time,
            'end_time' => $end_time,
            'hours_diff' => $hours_diff,
            'price' => $price
        ]);
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
        //dd($id);
        $game = Game::findOrFail($id);
        $order = Order::where('game_id', $id)->where('status', 'ochiq')->first();
        $start_time = Carbon::parse($game->start_time);
        $end_time = Carbon::now();
        $hours_diff = $end_time->diffInHours($start_time);
        $game_summ = -$hours_diff*$game->price;
        return Redirect::route('closes.index', [
                                'order_id' => $order->id,
                                'game_number' => $game->game_number,
                                'price' => $game->price,
                                'start_time' =>$start_time,
                                'end_time' => $end_time,
                                'hours_diff' => $hours_diff
                            ]);
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
        $id = $request->input('id');
        $game = Game::findOrFail($id);
        $game->end_time = Carbon::now();
        $game->status = 'yopiq';
        $game->save();

        $order = Order::where('game_id', $id)->where('status', 'ochiq')->first();
        $start_time = Carbon::parse($game->start_time);
        $end_time = Carbon::now();
        $hours_diff = $end_time->diffInHours($start_time);
        $game_summ = -$hours_diff*$game->price;
        //dd($hours_diff);

        $order->game_summ = $game_summ;
        $order->end_time = Carbon::now();
        $order->status = 'yopiq';
        $order->save();
        //dd($order->start_time);

        //return Redirect::route('orders.index');
        //return Redirect::route('orders.create');
        return Redirect::route('orders.index', ['order_id' => $order->id, 'game_number' => $game->game_number]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showReport(string $id)
{
    $order = Order::findOrFail($id);
    $game = Game::findOrFail($order->game_id);

    $start_time = Carbon::parse($game->start_time);
    $end_time = Carbon::now();
    $hours_diff = $end_time->diffInHours($start_time);
    $game_summ = -$hours_diff * $game->price;

    return Redirect::route('show.total', [
        'id' => $order->id, // id parametrini yuborish
        'order_id' => $order->id,
        'game_number' => $game->game_number,
        'price' => $game->price,
        'start_time' => $start_time->toDateTimeString(),
        'end_time' => $end_time->toDateTimeString(),
        'hours_diff' => $hours_diff
    ]);
}



    public function showTotal(Request $request){

        $order_id = $request->query('order_id');
        $game_number = $request->query('game_number');
        $user = Auth::user();
        $orders = Order::where('id', $order_id)->where('user_id', $user->id)->get();
        $porders = Porder::where('order_id', $order_id)->where('user_id', $user->id)->get();
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');
        $hours_diff = $request->query('hours_diff');
        $price = $request->query('price');

        return view('showreport', [
            'orders' => $orders,
            'porders' => $porders,
            'game_number' => $game_number,
            'start_time' =>$start_time,
            'end_time' => $end_time,
            'hours_diff' => $hours_diff,
            'price' => $price
        ]);

    }
}
