<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Interfaces\MenuItemInterface;
use Exdeliver\Causeway\Domain\Common\Interfaces\RenderableInterface;

/**
 * Class MenuComposite
 * @package Exdeliver\Causeway\Domain\Entities\Menu
 */
class MenuComposite implements RenderableInterface
{
    /**
     * @var RenderableInterface
     */
    protected $items;

    /**
     * @return string
     */
    public function render(): string
    {
        $items = collect($this->items)
            ->filter(function ($item) {
                return $item->parent_id === null;
            })->map(function ($item) {
                $item = new MenuElementComposite($item);
                return $item;
            });

        return view('causeway::layouts.partials._menu', [
            'items' => $items,
        ]);
    }

    /**
     * @param MenuItemInterface $item
     */
    public function addItem(MenuItemInterface $item)
    {
        $this->items[] = $item;
    }
}