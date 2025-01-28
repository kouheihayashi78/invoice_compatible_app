<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService implements ProductServiceInterface
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * 商品一覧を取得
     *
     * @param array $search
     * @return Collection|null
     */
    public function index(array $search): ?Collection
    {
        return $this->product::get();
    }

    /**
     * 商品登録
     *
     * @param array $productRecord
     * @return Product
     */
    public function create(array $productRecord): Product
    {
    }

    /**
     * 商品編集
     *
     * @param Product $product
     * @param array $productRecord
     * @return void
     */
    public function edit(Product $product, array $productRecord): void
    {

    }

    /**
     * 商品削除
     *
     * @param Product $product
     * @param integer $productId
     * @return void
     */
    public function delete(Product $product, int $productId): void
    {

    }
}
