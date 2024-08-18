<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ViewgameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $games = Game::where('user_id', $user->id)->where('view', 'true')->get();
        $sections = Section::where('user_id', $user->id)->get();
        return view('games', compact('games', 'sections'));
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
         // Validate the request
    $validatedData = $request->validate([
        'game_number' => 'required|string',
        'price' => 'required|numeric',
        'game_type' => 'required|string',
        'user_id' => 'required|exists:users,id'
    ]);

    // Create a new game instance
    $game = new Game();
    $game->game_number = $validatedData['game_number'];
    $game->price = $validatedData['price'];
    $game->game_type = $validatedData['game_type'];
    $game->user_id = $validatedData['user_id']; // Assign the logged in user's ID
    $game->time_status = 'vaqt';
    $game->status = 'yopiq';
    $game->save();

    // Redirect back with success message
    return redirect()->route('viewgames.index')->with('success', 'O\'yin muvaffaqiyatli qo\'shildi');
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
        $game = Game::findOrFail($id);
        $game->view = 'false';
        $game->save();
        return Redirect::route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);

    // O'yinni o'chirish
    $game->delete();

    // Muvaffaqiyatli xabar bilan qaytish
    return redirect()->route('viewgames.index')->with('success', 'O\'yin muvaffaqiyatli o\'chirildi');
    }
}
