<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Category;
use App\Client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index()
    {
        //
    }


    public function create(Client $client)
    {
        $categories=Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.create',compact('client','categories','orders'));
    }


    public function store(Request $request,Client $client)
    {
//        dd($request->all());
        $request->validate([
            'products'=>'required|array',
//            'quantities'=>'required|array',
        ]);

        $this->attach_order($request,$client);

        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    public function show(Order $order)
    {
        //
    }


    public function edit(Client $client,Order $order)
    {
        $categories=Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit',compact('client','order','categories','orders'));
    }


    public function update(Request $request,Client $client, Order $order)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->detach_order($order);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    public function destroy(Order $order)
    {
        //
    }

    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }
    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();

    }//end of detach order
}
