<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Qo'shilgan qator
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user = Auth::user();
         $games = Game::where('user_id', $user->id)->where('view', 'true')->orderBy('status')->get();
         $products = Product::where('user_id', $user->id)->get();
         return view('dashboard', compact('games', 'products'));

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
    public function show()
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
        $id = $request->input('id');
        $summa = $request->input('summa');
        $time_status = 'vaqt';

        //$end_time = Carbon::now()->addHours(2);
        // $hours = ($start_time->diffInHours($end_time))*60;
        // dd($hours);

        $game = Game::findOrFail($id);
        if ($summa != '') {
            $price_minute = $game->price/60;
        $end_time = $summa/$price_minute;
        $game->end_time = Carbon::now()->addMinutes($end_time);
        } else {
            $game->end_time = Carbon::now()->addHours(12);
            $time_status = 'Ochiq';
        }




        //dd($end_time);
        $game->time_status = $time_status;
        $game->status = 'ochiq';
        $game->start_time = Carbon::now();


        $game->save();

    // return Redirect::route('orders.create');
    return Redirect::route('orders.show', $game->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
