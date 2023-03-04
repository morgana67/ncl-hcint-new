<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SuggestProduct;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function add(Request $request){
        $product = Product::find($request->product_id);
        $productInfo = [
            'id' => $request->product_id,
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->quantity,
            'weight' => 0,
            'options' => [
                'type' => $product->type,
                'slug' => $product->slug,
            ]
        ];
        $add = true;
        foreach(Cart::content() as $cartItem) {
            if($cartItem->id == $product->id && $product->type == 'bundle') {
                $add = false;
                Cart::update($cartItem->rowId, ['qty' => 1]); // Will update the id, name and price
            }
        }
        if($add) Cart::add($productInfo);

        return redirect()->route('cart.view')->with(['productInfo' => $productInfo]);
    }

    public function addMultiple(Request $request){
        $products = Product::whereIn('id',$request->product_id)->get();
        $arrayCart = array();
        foreach ($products as $product){
            $arrayCart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => !empty($product->sale_price) ? $product->sale_price : $product->price,
                'qty' => 1,
                'weight' => 0
            ];
        }
        Cart::add($arrayCart);
        return redirect()->route('cart.view');
    }

    public function view(){
        $cart = Cart::content();
        $idProducts = array();
        foreach ($cart as $item){
            $idProducts[] = $item->id;
        }
        $suggestProducts = array();
        if(count($idProducts) > 0 ){
            $suggestProducts = SuggestProduct::whereIn('product_id',$idProducts)->with('product')->get();
        }

        $mandatoryProducts = Product::active()->additionalType()->where('mandatory',1)->get();
        $additionalProducts = Product::active()->additionalType()->where('mandatory',0)->get();
        $productAddToCart = session('productInfo') ?? false;
        return view('front.cart.view',compact('cart','mandatoryProducts','additionalProducts','suggestProducts', 'productAddToCart'));
    }

    public function update(Request $request){
        Cart::update($request->rowId, ['qty' => $request->qty]);
        return back();
    }

    public function remove(Request $request){
        $productInCart = Cart::get($request->rowId);
        if($productInCart->options->type == 'bundle') {
            if(isset($request->removeBundle)) {
                Cart::remove($request->rowId);
                return back();
            }
            $bundleProducts = Product::find($productInCart->id)->productBundle;
            $arrCart = [];
            foreach($bundleProducts as $bundleProduct) {
                if($bundleProduct->product_id != $request->productId) {
                    $product = $bundleProduct->product;
                    $arrCart[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => !empty($product->sale_price) ? $product->sale_price : $product->price,
                        'qty' => 1,
                        'weight' => 0,
                        'options' => [
                            'type' => $product->type,
                            'slug' => $product->slug,
                        ]
                    ];
                }
            }
            Cart::remove($request->rowId);
            Cart::add($arrCart);
        } else {
            Cart::remove($request->rowId);
        }
        return back();
    }

    public function removeAll(Request $request) {
        Cart::destroy();
        return back();
    }

}
