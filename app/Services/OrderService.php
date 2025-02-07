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
        $result = $this->order->where('order_name', 'LIKE', '%'.$search_str.'%')
            ->orWhere('order_code', 'LIKE', '%'.$search_str.'%')
            ->orWhere('order_price', '=', $search_str)
            ->orWhere('order_tax', '=', $search_str)
            ->paginate(5);
        return $result;
    }
}
