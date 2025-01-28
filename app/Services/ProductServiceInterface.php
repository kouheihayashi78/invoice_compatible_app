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
     * @param array $productRecord
     * @return Product
     */
    public function create(array $productRecord): Product;

    /**
     * 商品編集
     *
     * @param Product $product
     * @param array $productRecord
     */
    public function edit(Product $product, array $productRecord): void;

    /**
     * 商品削除
     *
     * @param Product $product
     * @param int $productId
     */
    public function delete(Product $product, int $productId): void;

}
