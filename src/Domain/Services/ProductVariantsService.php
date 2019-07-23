<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\ValueTypes;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\Variant;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantProduct;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantValue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductVariantsService
 * @package Exdeliver\Causeway\Domain\Services
 */
final class ProductVariantsService
{
    /**
     * @param array $request
     * @param Product $product
     * @return array
     * @throws \Throwable
     */
    public function saveVariants(array $request, Product $product): ?array
    {
        dd($request);
        $variants = $request->variant;
        $variantProduct = $request->variantProduct;

        try {
            $variantsCollection = $product->getVariantsCollection();
            if (count($variantsCollection) > 0 && count($variantsCollection) !== count($variants)) {
                Product::where('parent_product_id', $product->id)->delete();
                $product->variants()->delete();
            }

            $generatedVariants = DB::transaction(function () use ($variants, $product) {
                $result = [];
                foreach ($variants as $sequence => $variant) {
                    $variantType = Variant::updateOrCreate([
                        'product_id' => $product->id,
                        'slug' => str_slug($variant['name']),
                    ],
                        [
                            'name' => $variant['name'],
                            'sequence' => $variant['sequence'] ?? $sequence,
                            'value_type' => key(ValueTypes::TEXT),
                        ]);

                    foreach ($variant['values'] as $valueSequence => $value) {
                        VariantValue::updateOrCreate([
                            'variant_id' => $variantType->id,
                            'slug' => str_slug($variant['name'] . ' ' . $value['name']),
                        ],
                            [
                                'variant_value' => $value['name'],
                                'sequence' => $value['sequence'] ?? $valueSequence,
                            ]);
                    }
                }

                return $this->createVariantProducts($this->generateVariants($product), $product);
            });

            return $generatedVariants;

        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * Create variant products.
     *
     * @param Collection $generatedVariants
     * @param Product $product
     * @return array
     */
    public function createVariantProducts(Collection $generatedVariants, Product $product): array
    {
        $generatedProducts = [];

        foreach ($generatedVariants as $variantType) {

            $variantValuesName = array_column($variantType, 'variant_value');

            $title = $product->title . ' ' . implode(', ', $variantValuesName);

            $newProductVariant = Product::updateOrCreate([
                'slug' => str_slug($title),
                'parent_product_id' => $product->id,
            ],
                [
                    'title' => $title,
                    'type' => Product::VARIANT_PRODUCT['type'],
                    'active' => 0,
                    'quantity' => $product->quantity,
                    'gross_price' => $product->gross_price / 100,
                    'special_price' => $product->special_price / 100,
                    'vat' => $product->vat,
                ]);

            $generatedProducts[] = $newProductVariant;
        }

        return $generatedProducts;
    }

    /**
     * Generate product variants.
     *
     * @param Product $product
     * @return Exception|Collection
     * @throws Exception
     */
    public function generateVariants(Product $product)
    {
        $variants = $product->variants()->orderBy('sequence')->get();

        if (count($variants) === 0) {
            throw new Exception('Cannot generate variants, because its empty.');
        }

        $variantValues = [];

        foreach ($variants as $variant) {
            $variantValues[$variant->name] = $variant->values->toArray();
        }

        try {
            return collect(generateArrayCombinations($variantValues));
        } catch (Exception $e) {
            logger()->error('Could not generate a variant combination with these values.', [$e]);
            throw new \Exception('Error generating variant combinations.');
        }
    }
}
