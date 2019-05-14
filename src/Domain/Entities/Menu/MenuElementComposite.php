<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Interfaces\MenuItemInterface;
use Exdeliver\Causeway\Domain\Common\Interfaces\RenderableInterface;

/**
 * Class MenuElementComposite
 * @package Exdeliver\Causeway\Domain\Entities\Menu
 */
class MenuElementComposite implements MenuItemInterface, RenderableInterface
{
    /**
     * @var MenuItemInterface
     */
    protected $item;

    /**
     * MenuElementComposite constructor.
     * @param MenuItemInterface $item
     */
    public function __construct(MenuItemInterface $item)
    {
        if (count($item->items) > 0) {
            $items = $item->items->map(function ($item) {
                $item = new MenuElementComposite($item);
                return $item;
            });
            $item->items = $items;
        }

        $this->item = $item;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): string
    {
        return view('causeway::layouts.partials._menu_item', [
            'item' => $this->item,
        ]);
    }

    /**
     * @return bool
     */
    public function isSubmenu()
    {
        return $this->item->isSubmenu();
    }
}