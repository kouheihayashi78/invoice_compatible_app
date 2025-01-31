<?php
namespace App\Services;

use app\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    /**
     * 商品一覧を取得
     *
     * @return Collection|null
     */
    public function index(): ?Collection;

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
     * @return Collection|null
     */
    public function search(string|null $search_str): ?Collection;

}
