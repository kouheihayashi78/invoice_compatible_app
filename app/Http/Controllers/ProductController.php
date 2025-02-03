<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_str = null;
        if(empty($request->input('search_str'))) {
            $productList = $this->productService->index();
        } else {
            $search_str = $request->input('search_str');
            $productList = $this->productService->search($search_str);
        }
        return Inertia::render('Products/Index', compact('productList', 'search_str'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $this->productService->create($data);
        return redirect()->route('product.index')->with('success', '登録が完了しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Modelを指定するこのやり方はルートモデルバインディング
     * routeの/{product} の部分が $productにバインドされるので、ここは合わせる
     * LaravelがProductのproduct_idに対応するレコードを取得し、$productに該当レコードのインスタンスを渡してくれる
     * わざわざinputで取り出してModelから取得する記述をしないでいいので、シンプル！！！
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());
        return redirect()->route('product.index')->with('success', '編集が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return redirect()->route('product.index');
    }
}
