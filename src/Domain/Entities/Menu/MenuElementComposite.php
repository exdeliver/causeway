<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Interfaces\MenuItemInterface;
use Exdeliver\Causeway\Domain\Common\Interfaces\RenderableInterface;

/**
 * Class MenuElementComposite
 * @package Exdeliver\Causeway\Domain\Entities\Menu
 */
class MenuElementComposite implements RenderableInterface
{
    /**
     * @var MenuItemInterface
     */
    public $item;

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
     * @param boolean $sub
     * @return string
     */
    public function render(bool $sub = false): string
    {
        $this->item->isSub = $sub;

        return view('causeway::layouts.partials._menu_item', [
            'item' => $this->item,
        ]);
    }
}