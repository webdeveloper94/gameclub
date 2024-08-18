<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Qo'shilgan qator
use Carbon\Carbon;
use App\Models\Porder;
use Illuminate\Http\Request;

class PorderController extends Controller
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
        $validatedData = $request->validate([
            'game_id' => 'required|integer',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Process the order and save to the database
        foreach ($validatedData['products'] as $product) {
            Porder::create([
                'user_id' => auth()->id(),
                'order_id' => Order::where('game_id', $validatedData['game_id'])->where('status', 'ochiq')->first()->id,
                'product_id' => $product['id'],
                'product_total' => $product['quantity'],
                'product_summ' => Product::find($product['id'])->price * $product['quantity'],
            ]);
        }

        return response()->json(['message' => 'Order created successfully'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->where('status', 'active')->get();
        return view('product', compact('products', 'id'));

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
    public function cancel(Request $request)
{
    $orders = $request->input('orders', []);
    if (!empty($orders)) {
        foreach ($orders as $order) {
            $porder = Porder::find($order['id']);
            if ($porder) {
                $initialTotal = $porder->product_total;  // Mahsulotning boshlang'ich soni
                $unitPrice = $porder->product_summ / $initialTotal;  // Bir dona mahsulotning narxi

                if ($initialTotal > $order['quantity']) {
                    $porder->product_total -= $order['quantity'];
                    $porder->product_summ = $unitPrice * $porder->product_total;  // Yangi jami summa
                    $porder->save();
                } else {
                    $porder->delete();
                }
            }
        }
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}


}
