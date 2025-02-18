<?php
namespace App\Services;

use App\Http\Resources\OrderResource;
use app\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface OrderServiceInterface
{
    /**
     * オーダー一覧を取得
     *
     * @return AnonymousResourceCollection|null
     */
    public function index(): ?AnonymousResourceCollection;

    /**
     * オーダー詳細を取得
     *
     * @param Order $order
     *
     * @return OrderResource|null
     */
    public function show($order): ?OrderResource;

    /**
     * オーダー登録
     *
     * @param array $orderInfo
     * @return void
     */
    public function create(array $orderInfo): void;

    /**
     * オーダー編集
     *
     * @param Order $order
     * @param array $orderRecord
     */
    public function update($order, array $orderRecord): void;

    /**
     * オーダー削除
     *
     * @param Order $order
     */
    public function delete(Order $order): void;

    /**
     * オーダー検索
     *
     * @param string|null $search_str
     * @return AnonymousResourceCollection|null
     */
    public function search(string|null $search_str): ?AnonymousResourceCollection;

}
