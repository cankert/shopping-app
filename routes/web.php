<?php

use App\Imports\CategoryImport;
use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

    $itemsNotDone=Item::with(['product'])->where('done', 0)->get();
    $itemsDone=Item::with('product')->where('done', 1)->get();
    $itemsDone->sortBy('name');

    $categories= Category::all();
    $categories->sortByDesc('order');

    $groupedProducts = [];
    foreach ($categories as $category) {
        $groupedProducts[$category->name] = [];
    }

    foreach($itemsNotDone as $item) {
        array_push($groupedProducts[$item->product->category->name], $item);
    }

    return Inertia::render('Items', [
        'itemsNotDone' => $groupedProducts,
        'itemsDone' => $itemsDone,
        'categories' => $categories,
    ]);
})->name('items');

Route::get('/product', function () {
    $categories= Category::all();
    $categories->sortBy('order');
    return Inertia::render('Product', [
        'categories' => $categories,
    ]);
})->name('product');

Route::post('/product', function (Request $request) {
    Product::create(
        [
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]
    );
    return Redirect::route('post_product');
})->name('post_product');

Route::get('/demo', function () {
    Excel::import(new CategoryImport, 'categories.xlsx');
    Excel::import(new ProductImport, 'products.xlsx');
    //$categories = Category::factory()->count(3)->create();
    //$products = Product::factory()->count(3)->create();
});

Route::get('/products', function () {

    $products=Product::with('category')->get();
    return Inertia::render('Products', [
        'products' => $products,
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
    return Redirect::route('products');
});

Route::post('/items/plus/{id}', function ($id) {
    $item = Item::find($id);
    if($item) {
        $item->quantity++;
        $item->save();
    }
    return Redirect::route('items');
});

Route::post('/items/minus/{id}', function ($id) {
    $item = Item::find($id);
    if($item && $item->quantity > 1) {
        $item->quantity--;
        $item->save();
    }
    return Redirect::route('items');
});

Route::patch('/items/{id}/update', function (Request $request, $id) {
    $item = Item::find($id);
    $item->update([
        'done' => $request->done
    ]);
    return Redirect::route('items');
});
