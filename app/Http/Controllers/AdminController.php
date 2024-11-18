<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $category = Category::latest()->paginate(config('common.default_show_new'));
        $users = User::latest()->paginate(config('common.default_show_new'));
        $products = Product::latest()->paginate(config('common.default_show_new'));

        return view('admin.index', compact('category', 'users', 'products'));
    }
}
