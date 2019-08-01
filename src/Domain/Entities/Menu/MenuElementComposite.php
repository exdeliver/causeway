<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Interfaces\MenuItemInterface;
use Exdeliver\Causeway\Domain\Common\Interfaces\RenderableInterface;
use Illuminate\Contracts\View\View;

/**
 * Class MenuElementComposite.
 */
class MenuElementComposite implements MenuItemInterface, RenderableInterface
{
    /**
     * @var MenuItemInterface
     */
    protected $item;

    /**
     * @var
     */
    protected $template;

    /**
     * MenuElementComposite constructor.
     *
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
     * @return View
     */
    public function render(): string
    {
        if (null !== $this->template && view()->exists('site::menu._'.$this->template.'_item')) {
            return view('site::menu._'.$this->template.'_item', [
                'item' => $this->item,
            ]);
        }

        return view('site::menu._default_item', [
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

    /**
     * @param string|null $template
     *
     * @return $this
     */
    public function setTemplate(string $template = null)
    {
        $this->template = $template;

        return $this;
    }
}
