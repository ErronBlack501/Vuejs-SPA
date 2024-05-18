<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::select(['id', 'design', 'price', 'quantity'])->get()->toArray(),
            'totalAmount' => Product::selectRaw('SUM(price * quantity) AS total_amount')->first()->total_amount,
            'minAmount' => Product::selectRaw('MIN(price * quantity) AS min_total_amount')->first()->min_total_amount,
            'maxAmount' => Product::selectRaw('MAX(price * quantity) AS max_total_amount')->first()->max_total_amount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'design' => 'required|alpha:ascii|max:255|unique:products',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        Product::create($validated);

        Session()->flash('success', 'Product has been created successfully');

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'design' => $product->design,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'design' => 'required|alpha:ascii|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $product = Product::findOrFail($product->id);
        $product->design = $validated['design'];
        $product->price = $validated['price'];
        $product->quantity = $validated['quantity'];
        $product->save();

        Session()->flash('success', 'Product has been modified successfully');

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {

        $product->delete();

        return redirect()->route('products.index');
    }
}
