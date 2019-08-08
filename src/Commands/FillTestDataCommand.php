<?php

namespace Exdeliver\Causeway\Commands;

use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Domain\Services\ShopProductService;
use Faker\Generator as Faker;
use Illuminate\Console\Command;

class FillTestDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'causeway:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates test data';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $category = Category::first();

        /** @var ShopProductService $productService */
        $productService = app(ShopProductService::class);
        $faker = app(Faker::class);

        for ($i = 0; $i < 10000; $i++) {

            $product = $productService->saveProduct([
                "pid" => $faker->uuid,
                "title" => $faker->name,
                "description" => $faker->text,
                "gross_price" => "50.00",
                "special_price" => "0.00",
                "vat" => "21.00",
                "quantity" => "100",
                "weight" => null,
                "slug" => str_slug($faker->name),
            ]);

            $product->categories()->sync($category->id);
        }
    }
}
