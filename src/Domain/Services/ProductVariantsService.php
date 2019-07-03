<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantProduct;
use Illuminate\Support\Collection;

/**
 * Class ProductVariantsService
 * @package Exdeliver\Causeway\Domain\Services
 */
final class ProductVariantsService
{
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

            $newProductVariant = Product::create([
                'title' => $title,
                'slug' => str_slug($title),
                'type' => Product::VARIANT_PRODUCT['type'],
                'active' => 0,
                'quantity' => $product->quantity,
                'gross_price' => $product->gross_price,
                'vat' => $product->vat,
            ]);

            foreach ($variantType as $type => $value) {
                $variantProduct = new VariantProduct();
                $variantProduct->variant_value_id = $value['id'];
                $variantProduct->variant_product_id = $newProductVariant->id;
            }

            $generatedProducts[] = $newProductVariant;
        }

        return $generatedProducts;
    }
}
