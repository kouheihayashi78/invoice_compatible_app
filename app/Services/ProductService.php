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
     * @param array $productInfo
     * @return void
     */
    public function create(array $productInfo): void
    {
        $product = new Product($productInfo);
        $product->fill([
            'product_name' => $productInfo['name'],
            'product_code' => $productInfo['code'],
            'product_price' => $productInfo['price'],
            'product_tax' => $productInfo['tax']
        ])->save();

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
