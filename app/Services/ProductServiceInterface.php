<?php
namespace App\Services;

use app\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * 商品一覧を取得
     *
     * @return LengthAwarePaginator|null
     */
    public function index(): ?LengthAwarePaginator;

    /**
     * 商品登録
     *
     * @param array $productInfo
     * @return void
     */
    public function create(array $productInfo): void;

    /**
     * 商品編集
     *
     * @param Product $product
     * @param array $productRecord
     */
    public function update($product, array $productRecord): void;

    /**
     * 商品削除
     *
     * @param Product $product
     */
    public function delete(Product $product): void;

    /**
     * 商品検索
     *
     * @param string|null $search_str
     * @return LengthAwarePaginator|null
     */
    public function search(string|null $search_str): ?LengthAwarePaginator;

    /**
     * すべての商品取得
     *
     * @return AnonymousResourceCollection|null
     */
    public function allProducts(): ?AnonymousResourceCollection;

    /**
     * 商品検索
     *
     * @param string|null $search_str
     * @return AnonymousResourceCollection|null
     */
    public function searchProductName(string|null $search_str): ?AnonymousResourceCollection;
}
