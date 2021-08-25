<?php

use App\Models\Category;
use App\Models\Item;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/items', function () {

    $itemsNotDone=Item::with(['product'])->where('done', 0)->get();
    $itemsDone=Item::with('product')->where('done', 1)->get();

    $groupedProducts = [];
    foreach($itemsNotDone as $item) {
        $firstProduct = !array_key_exists($item->product->category->name, $groupedProducts);
        if($firstProduct) {
            $groupedProducts[$item->product->category->name]= [];
        }
        array_push($groupedProducts[$item->product->category->name], $item);
    }

    $categories= Category::all();
    $categories->sortBy('order');

    return Inertia::render('Items', [
        'itemsNotDone' => $groupedProducts,
        'itemsDone' => $itemsDone,
        'categories' => $categories,
    ]);
})->name('items');

Route::get('/products', function () {

    $products=Product::with('category')->get();

    $groupedProducts = [];
    foreach($products as $product) {
        $firstProduct = !array_key_exists($product->category->name, $groupedProducts);
        if($firstProduct) {
            $groupedProducts[$product->category->name]= [];
        }
        array_push($groupedProducts[$product->category->name], $product);
    }
    $categories= Category::all();
    $categories->sortBy('order');
    return Inertia::render('Products', [
        'products' => $groupedProducts,
        'categories' => $categories,
    ]);
})->name('products');

Route::post('/items/add/{id}', function ($id) {
    //check if product is already on list
    $item = Item::where('product_id', $id)->first();
    if($item) {
        if($item->done == 1) {
            $item->done = 0;
            $item->quantity = 1;
        } else {
            $item->quantity = $item->quantity + 1;
        }
        $item->save();
    } else {
        // add a new item with connected product
        $item = Item::create([
            'product_id' => $id,
            'quantity' => 1,
            'done' => 0,
        ]);
    }
    return redirect('products');
});

Route::patch('/items/{id}/update', function (Request $request, $id) {
    $item = Item::find($id);
    $item->update([
        'done' => $request->done
    ]);
    return redirect('/items');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
