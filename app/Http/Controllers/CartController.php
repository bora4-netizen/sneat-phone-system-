<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
  function __construct()
  {
      $this->middleware('auth');
      $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
      $this->middleware('permission:order-create', ['only' => ['create','store']]);
      $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:order-delete', ['only' => ['destroy']]);
  }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $availableProducts = Product::available()->first();
        $cart = new Cart();
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->price = $request->price;
        $cart->save();
        return redirect()->route('orders.create', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Get the cart item ID from the request
        $cartItemId = $request->input('cartItemId');
        $cartUserId = Auth::user()->id;
        // Check if the user is authorized to delete this cart item (you may add your own authorization logic)

        // Find the cart item by its ID
        $cartItem = Cart::where('user_id', $cartUserId)->where('product_id', $cartItemId)->first();

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        // Check if the authenticated user owns the cart item (you may add your own ownership verification logic)
        if ($cartItem->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        // Delete the cart item
        Cart::where('user_id', $cartUserId)->where('product_id', $cartItemId)->delete();
        $totalCartsPrice = Cart::where('user_id', Auth::user()->id)
          ->whereHas('productAvailable')
          ->sum('price');

        return response()->json([
          'message' => 'Cart item deleted successfully.',
          'total' => $totalCartsPrice,
        ]);
    }
}
