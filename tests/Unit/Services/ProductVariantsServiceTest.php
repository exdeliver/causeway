<?php

namespace Exdeliver\Causeway\Tests\Unit\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\Variant;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants\VariantValue;
use Exdeliver\Causeway\Domain\Services\ProductVariantsService;
use Exdeliver\Causeway\Tests\TestCase;
use Faker\Factory;

class ProductVariantsServiceTest extends TestCase
{
    /**
     * @test
     */
    public function generate_product_variants()
    {
        $faker = Factory::create();

        $productTitle = $faker->name;
        $product = factory(Product::class)->create([
            'title' => $productTitle,
            'slug' => str_slug($productTitle),
        ]);

        $variantSize = factory(Variant::class)->create([
            'name' => 'size',
            'product_id' => $product->id,
            'sequence' => 1,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'small',
            'variant_id' => $variantSize->id,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'medium',
            'variant_id' => $variantSize->id,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'large',
            'variant_id' => $variantSize->id,
        ]);

        $variantColor = factory(Variant::class)->create([
            'name' => 'color',
            'product_id' => $product->id,
            'sequence' => 2,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'red',
            'variant_id' => $variantColor->id,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'blue',
            'variant_id' => $variantColor->id,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'yellow',
            'variant_id' => $variantColor->id,
        ]);

        $variantSleeve = factory(Variant::class)->create([
            'name' => 'sleeve',
            'product_id' => $product->id,
            'sequence' => 3,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'long',
            'variant_id' => $variantSleeve->id,
        ]);

        factory(VariantValue::class)->create([
            'variant_value' => 'short',
            'variant_id' => $variantSleeve->id,
        ]);

        $this->assertCount(3, $product->variants->toArray());
        $this->assertEquals(8, $product->variants()->withCount('values')->get()->sum('values_count'));

        /** @var ProductVariantsService $productVariantService */
        $productVariantService = app(ProductVariantsService::class);
        $generatedVariants = $productVariantService->generateVariants($product);

        $products = $productVariantService->createVariantProducts($generatedVariants, $product);
        $this->assertCount(18, $generatedVariants);
        $this->assertCount(18, $products);
    }
}