<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Domain\Entities\Menu\MenuComposite;
use Exdeliver\Causeway\Infrastructure\Repositories\MenuItemRepository;
use Exdeliver\Causeway\Infrastructure\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class MenuService
 * @package Domain\Services
 */
final class MenuService extends AbstractService
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
     * @param int|null $id
     * @param Request $request
     * @return Model
     */
    public function updateOrCreateItem(Request $request, int $id = null)
    {
        $language = $request->language ?? Lang::locale();

        $this->repository = $this->menuitemRepository;

        $request->request->add([
            $language => $request->only(['label', 'url']),
        ]);

        return $this->repository->updateOrCreateTranslation(
            $id,
            $request->only(['menu_id', 'access_level', $language]),
            $language
        );
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function render(string $name, $template = null)
    {
        try {
            $menu = $this->repository->where('name', '=', $name)->firstOrFail();

            $menuCollection = new MenuComposite();
            if ($template !== null) {
                if (!view()->exists('menu.custom.' . $template)) {
                    return "Missing blade file: menu.custom.{$template}";
                }
                $menuCollection->setTemplate($template);
            }

            foreach ($menu->items as $item) {
                $menuCollection->addItem($item);
            }

            return $menuCollection->render();

        } catch (\Exception $e) {
            \Log::warning('Missing menu called: ' . $name);
            return null;
        }
    }
}
