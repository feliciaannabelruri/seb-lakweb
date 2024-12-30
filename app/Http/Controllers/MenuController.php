<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use App\Models\ToppingCategory;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Ambil semua topping yang dikelompokkan berdasarkan kategori
        // tanpa filter is_available dan stock
        $toppingCategories = ToppingCategory::with('toppings')->get();

        // Ambil semua topping (jika masih diperlukan untuk backward compatibility)
        $toppings = Topping::all();

        return view('menu.index', compact('toppingCategories', 'toppings'));
    }
}