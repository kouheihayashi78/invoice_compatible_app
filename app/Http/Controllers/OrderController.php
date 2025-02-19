<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\ProductService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public $orderService;
    public $productService;

    public function __construct(
        OrderService $orderService,
        ProductService $productService
    )
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_str = null;
        if(empty($request->input('search_str'))){
            $orders = $this->orderService->index();
        } else {
            $search_str = $request->input('search_str');
            $orders = $this->orderService->search($search_str);
        }
        return Inertia::render('Orders/Index', compact('orders', 'search_str'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // すべての商品取得
        $products = $this->productService->allProducts();
        // わざわざサービス作るのが面倒だったので、ここでカスタマーデータ取得処理記述
        $customers = CustomerResource::collection(Customer::all());

        return Inertia::render('Orders/Create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $this->orderService->create($data);
        return redirect()->route('order.index')->with('success', 'オーダーの登録に成功しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, Request $request)
    {
        $order = $this->orderService->show($order);
        $page = $request->input('page');
        $search_str = $request->input('search_str');

        return Inertia::render('Orders/Show', compact('order', 'page', 'search_str'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $products = $this->productService->allProducts();
        $customers = CustomerResource::collection(Customer::all());

        return Inertia::render('Orders/Edit', compact('order', 'products', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->orderService->update($order, $request->validated());
        return redirect()->route('order.index')->with('success', 'オーダーの編集が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderService->delete($order);

        return redirect()->route('order.index')->with('successDel', 'オーダーの削除が完了しました。');
    }

    /**
     * Display the specified resource.
     */
    public function generatePdf(Order $order)
    {
        $orderResource = $this->orderService->show($order);
        $pdf = PDF::loadView('orders.pdf', [
            'order' => $order,
            'normal_tax' => $orderResource->additional['normal_tax'],
            'reduced_tax' => $orderResource->additional['reduced_tax'],
            'total' => $orderResource->additional['total'],
            'normal_tax_total' => $orderResource->additional['normal_tax_total'],
            'reduced_tax_total' => $orderResource->additional['reduced_tax_total'],
        ])
        ->set_option('compress', 1)
        ->setPaper('a4', 'portrait');
        $fileName = '請求書.pdf';

        return $pdf->download($fileName);
    }

}
