<?php

use App\Models\Item;
use Inertia\Inertia;
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

    $itemsNotDone=Item::where('done', 0)->cursor();
    $itemsDone=Item::where('done', 1)->cursor();

    return Inertia::render('Items', [
        'itemsNotDone' => $itemsNotDone,
        'itemsDone' => $itemsDone,
    ]);
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
