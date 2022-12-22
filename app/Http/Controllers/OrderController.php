<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index',compact('orders'));
    }
    public function create()
    {
        $menus = Menu::all();
        return view('order', compact('menus'));
    }

    public function store(Request $request)
    {
        $rules = [
            'status' => 'required|not_in:none'
        ];
        $validated = $request->validate($rules);
        Order::create($validated);

        $menucount = Menu::all()->count();
        $orderId = Order::all()->last()->id;
        for($i = 1; $i<=$menucount; $i++){
            if($request['quantity'.$i]>0){
                DB::table('order_menu')->insert([
                    'order_id' => $orderId,
                    'menu_id' => $request['id'.$i],
                    'quantity' => $request['quantity'.$i],
                ]);
            }
        }
        $request->session()->flash('Berhasil',"Berhasil Menambahkan Order Makanan {$orderId}!");
        return redirect(route('main.index'));
    }

    public function show(Order $order)
    {
        $datas = DB::select('SELECT oms.menu_id,m.nama,m.rekomendasi,oms.quantity,m.harga FROM order_menu om LEFT JOIN menus m ON om.menu_id = m.id WHERE om.order_id = ?',[$order->id]);

        $priceList = DB::select('SELECT m.rekomendasi,oms.quantity*m.harga gross_price FROM order_menu om JOIN menus m ON om.menu_id = m.id WHERE om.order_id = ?',[$order->id]);
        $price = 0;
        foreach($priceList as $pl){
            if($pl->rekomendasi){
                $price += round($pl->gross_price*0.9,2);
                // dump($price);
            }else{
                $price+=$pl->gross_price;
                // dump($price);
            }
        }
        $price = round($price*1.11,2);

        return view('orders.show', compact('order','data','price'));
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('order.index'))->with('berhasil', "Berhasil Menghapus Nomor Orderan {$order['id']}!");
    }
}
