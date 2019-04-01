<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\MenuItemRepository;
use Exdeliver\Causeway\Infrastructure\Repositories\MenuRepository;
use Illuminate\Http\Request;

/**
 * Class MenuService
 * @package Domain\Services
 */
class MenuService extends AbstractService
{
    /**
     * @var MenuItemRepository
     */
    protected $menuitemRepository;

    /**
     * SoundService constructor.
     * @param MenuRepository $menuRepository
     * @param MenuItemRepository $menuItemRepository
     */
    public function __construct(MenuRepository $menuRepository, MenuItemRepository $menuItemRepository)
    {
        $this->menuitemRepository = $menuItemRepository;
        $this->repository = $menuRepository;
    }

    /**
     * @param array $match
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreateItem(array $match, Request $request)
    {
        $this->repository = $this->menuitemRepository;

        $request->request->add([
            'en' => $request->only(['label', 'url']),
        ]);

        return parent::updateOrCreate($match, $request->only(['menu_id', 'access_level', 'en']));
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function render(string $name)
    {
        try {
            $menu = $this->repository->where('name', '=', $name)->firstOrFail();
            return $menu->items;
        } catch (\Exception $e) {
            \Log::warning('Missing menu called: ' . $name);
            return [];
        }
    }
}