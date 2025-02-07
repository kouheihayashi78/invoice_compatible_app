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
     * オーダー登録
     *
     * @param array $orderInfo
     * @return void
     */
    public function create(array $orderInfo): void
    {

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
    }

    /**
     * オーダー削除
     *
     * @param Order $order
     * @return void
     */
    public function delete(Order $order): void
    {
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
