<?php
namespace App\Services;

use app\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    /**
     * 商品一覧を取得
     *
     * @param array $search
     * @return Collection|null
     */
    public function index(array $search): ?Collection;

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
     * @param int $productId
     */
    public function delete(Product $product, int $productId): void;

}
