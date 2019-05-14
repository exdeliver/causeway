<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Interfaces\RenderableInterface;
use Illuminate\Contracts\Support\Arrayable;

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
     * @return \Illuminate\Contracts\View\View
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
     * @param Arrayable $item
     */
    public function addItem(Arrayable $item)
    {
        $this->items[] = $item;
    }
}