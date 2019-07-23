<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Domain\Entities\Shop\Category;
use Exdeliver\Causeway\Infrastructure\Repositories\ShopCategoryRepository;

/**
 * Class ShopCategoryService
 */
final class ShopCategoryService extends AbstractService
{
    /**
     * ShopCategoryService constructor.
     * @param ShopCategoryRepository $shopCategoryRepository
     */
    public function __construct(ShopCategoryRepository $shopCategoryRepository)
    {
        $this->repository = $shopCategoryRepository;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return mixed
     */
    public function saveCategory(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->update($id, $params);
        }

        return $this->create($params);
    }

    /**
     * @param $direction
     * @param Category $category
     * @return int
     */
    public function setCategorySequence($direction, Category $category)
    {
        $categoriesByParent = Category::where('parent_id', $category->parent_id);

        foreach ($categoriesByParent->get() as $item) {
            if (isset($item->id)) {
                $condition = Category::findOrFail($item->id);
                $condition->sequence = $item->sequence ?? 0;
                $condition->save();
            }
        }

        $sequence = (int)$category->sequence;

        switch ($direction) {
            case 'up':
                $sequence--;
                break;
            case 'down':
                $sequence++;
                break;
        }

        $existingSequenceCategory = $categoriesByParent->where('sequence', $sequence)->first();

        if (isset($existingSequenceCategory)) {
            switch ($direction) {
                case 'up':
                    $sequence--;
                    break;
                case 'down':
                    $sequence++;
                    break;
            }
        }

        $category->sequence = $sequence;

        $category->save();
    }
}