<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi', 'gambar']);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path; // Simpan path relatif
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi', 'gambar']);

        // Jika ada file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            // Upload baru
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        // Hapus gambar jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
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

        return redirect()->route('produk.index')->with('success', 'Pembelian berhasil! Terima kasih telah berbelanja.');
    }

    public function myPurchases()
    {
        $purchases = Purchase::with('produk')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('purchase.purchases', compact('purchases'));
    }
}
