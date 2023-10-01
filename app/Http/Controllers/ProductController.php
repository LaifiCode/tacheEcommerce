<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
        ]);

        $product = Product::create($data);

        return response()->json(['message' => 'Produit ajouté avec succès'], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'category_id' => 'integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $product->update($data);

        return response()->json(['message' => 'Produit mis à jour avec succès'], 200);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produit supprimé avec succès'], 200);
    }

    public function listProducts()
    {
        $products = Product::all();

        return response()->json($products, 200);
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Product::query();

        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $products = $query->get();

        return response()->json($products, 200);
    }
}
