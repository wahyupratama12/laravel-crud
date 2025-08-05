<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Produk::create($request->all());
        return redirect()->route('produk.index');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $produk->update($request->all());
        return redirect()->route('produk.index');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index');
    }

    public function showBuyForm($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.buy', compact('produk'));
    }

    public function processPurchase(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $produk->stok,
        ]);

        Purchase::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'quantity' => $request->input('quantity'),
        ]);

        $produk->decrement('stok', $request->input('quantity'));

        return redirect()->route('produk.index')->with('success', 'Purchase successful!');
    }

    public function myPurchases()
    {
        $purchases = Purchase::with('produk') // eager load produk info
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('purchase.purchases', compact('purchases'));
    }

}
