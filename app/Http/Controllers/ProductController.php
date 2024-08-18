<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Qo'shilgan qator
use Illuminate\Http\Request;
use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->where('status', 'active')->get();
        return view('products', compact('products'));
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
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->total = $request->input('total');
        $product->status = 'active';
        $product->user_id = Auth::id(); // Foydalanuvchi ID sini olish
        //dd($request->input('name'));
        $product->save();

        return redirect()->route('products.index')->with('success', 'Bo\'lim muvaffaqiyatli qo\'shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //dd($id);
        $product = Product::findOrFail($id);
        $product->status = 'inactive';
        $product->save();
        return redirect()->route('products.index')->with('success', 'Maxsulot muvaffaqiyatli tahrirlandi');
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
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->total = $request->input('total');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Maxsulot muvaffaqiyatli tahrirlandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
        public function inactive($id){

        }

}
