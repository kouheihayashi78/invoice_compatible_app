<?php
namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderService implements OrderServiceInterface
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * オーダー一覧を取得
     *
     * @return AnonymousResourceCollection|null
     */
    public function index(): ?AnonymousResourceCollection
    {
        $result = OrderResource::collection(Order::paginate(5));
        return $result;
    }

    /**
     * オーダー一覧を取得
     *
     * @param Order $order
     *
     * @return OrderResource|null
     */
    public function show($order): ?OrderResource
    {
        $result = new OrderResource($order);
        return $result;
    }

    /**
     * オーダー登録
     *
     * @param array $orderInfo
     * @return void
     */
    public function create(array $orderInfo): void
    {
        $order = new Order($orderInfo);
        $order->fill(
            [
                'order_customer_id' => $orderInfo['customer_id'],
                'order_product_id1' => $orderInfo['product_id1'],
                'order_num1' => $orderInfo['num1'],
                'order_product_id2' => $orderInfo['product_id2'],
                'order_num2'=> $orderInfo['num2'],
                'order_product_id3' => $orderInfo['product_id3'],
                'order_num3' => $orderInfo['num3'],
                'order_day' => date('Y-m-d H:i:s')
            ]
        )->save();

    }

    /**
     * オーダー編集
     *
     * @param Order $order
     * @param array $orderRecord
     * @return void
     */
    public function update($order, array $orderRecord): void
    {
        $order->update([
            'order_customer_id' => $orderRecord['customer_id'],
            'order_product_id1' => $orderRecord['product_id1'],
            'order_num1' => $orderRecord['num1'],
            'order_product_id2' => $orderRecord['product_id2'],
            'order_num2'=> $orderRecord['num2'],
            'order_product_id3' => $orderRecord['product_id3'],
            'order_num3' => $orderRecord['num3'],
            'order_day' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * オーダー削除
     *
     * @param Order $order
     * @return void
     */
    public function delete(Order $order): void
    {
        $order->delete();
    }

    /**
     * オーダー検索
     * 顧客名、商品名で検索する
     *
     * @param string|null $search_str
     * @return AnonymousResourceCollection|null
     */
    public function search(string|null $search_str): ?AnonymousResourceCollection
    {
        $result = $this->order::whereHas('customer', function($query) use ($search_str) {
            $query->where('customer_name', 'LIKE', '%'.$search_str.'%');
        })->orWhereHas('product1', function($query) use ($search_str){
            $query->where('product_name', 'LIKE', '%'.$search_str.'%');
        })->orWhereHas('product2', function($query) use ($search_str){
            $query->where('product_name', 'LIKE', '%'.$search_str.'%');
        })->orWhereHas('product3', function($query) use ($search_str){
            $query->where('product_name', 'LIKE', '%'.$search_str.'%');
        })->orderBy('order_id', 'asc')->paginate(5);

        return OrderResource::collection($result);
    }
}
