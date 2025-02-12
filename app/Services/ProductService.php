<?php
namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator|null
     */
    public function index(): ?LengthAwarePaginator
    {
        return $this->product->paginate(5);
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
    public function update($product, array $productRecord): void
    {
        $product->update([
            'product_name' => $productRecord['name'],
            'product_code' => $productRecord['code'],
            'product_price' => $productRecord['price'],
            'product_tax' => $productRecord['tax'],
        ]);
    }

    /**
     * 商品削除
     *
     * @param Product $product
     * @return void
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }

    /**
     * 商品検索
     *
     * @param string|null $search_str
     * @return LengthAwarePaginator|null
     */
    public function search(string|null $search_str): ?LengthAwarePaginator
    {
        $result = $this->product->where('product_name', 'LIKE', '%'.$search_str.'%')
            ->orWhere('product_code', 'LIKE', '%'.$search_str.'%')
            ->orWhere('product_price', '=', $search_str)
            ->orWhere('product_tax', '=', $search_str)
            ->paginate(5);
        return $result;
    }

    /**
     * すべての商品取得
     *
     * @return AnonymousResourceCollection|null
     */
    public function allProducts(): ?AnonymousResourceCollection
    {
        return ProductResource::collection($this->product->all());
    }

    /**
     * 商品名検索
     *
     * @param string|null $search_str
     * @return AnonymousResourceCollection|null
     */
    public function searchProductName(string|null $search_str): ?AnonymousResourceCollection
    {
        $result = $this->product->where('product_name', 'LIKE', '%'.$search_str.'%')->orderBy('product_code', 'ASC')->get();
        return ProductResource::collection($result);
    }

}
