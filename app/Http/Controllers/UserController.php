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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();
    // Paginate payments instead of using get()
    $payments = Payment::where('user_id', $users->id)->paginate(10); // Change 10 to your desired number of items per page
    return view('userprofile', compact('users', 'payments'));
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required|min:12',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->number = $request->input('phone');
        $user->save();
        return redirect()->back()->with('success', 'Foydalanuvchi yaratildi.');



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $users = User::findOrFail($id);
    // Paginate payments instead of using get()
    $payments = Payment::where('user_id', $id)->paginate(10); // Change 10 to your desired number of items per page
    return view('admin.showuser', compact('users', 'payments'));
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

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Foydalanuvchi muvaffaqiyatli o\'chirildi.');
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        //dd($request->new_password);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Parol muvaffaqiyatli yangilandi.');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->type = 'blok';
        $user->save();

        return redirect()->back()->with('success', 'Foydalanuvchi muvaffaqiyatli bloklandi.');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->type = 'user';
        $user->save();

        return redirect()->back()->with('success', 'Foydalanuvchi muvaffaqiyatli bloklandi.');
    }


    public function profile(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Parol o\'zgartirildi.');
        } else {
            return redirect()->back()->with('success', 'Eski parol xato kiritildi.');
        }
}


}
