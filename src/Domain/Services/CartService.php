<?php

namespace Exdeliver\Causeway\Domain\Services;

use Akaunting\Money\Money;
use Exdeliver\Causeway\Domain\Entities\Cart\Item;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods\ShippingMethods;
use Illuminate\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class CartService
 * @package Domain\Services
 */
class CartService extends ShopCalculationService
{
    const DEFAULT_INSTANCE = 'default';

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var
     */
    private $instance;

    /**
     * CartService constructor.
     * @param SessionManager $session
     * @param Dispatcher $events
     */
    public function __construct(SessionManager $session, Dispatcher $events)
    {
        $this->session = $session;
        $this->events = $events;

        $this->instance(self::DEFAULT_INSTANCE); // set instance for this cart service, our sessions will depend on this
    }

    /**
     * @param null $instance
     * @return $this
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;

        $this->instance = sprintf('%s.%s', 'cart', $instance);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param null $collection
     */
    public function setCollection($collection = null)
    {
        $set = collect([]);
        if (count($collection) > 0) {
            foreach ($collection as $collect) {
                $set->push(new Item($collect));
            }
        }
        $this->putCollection($set);
    }

    /**
     * @param null $collection
     */
    public function putCollection($collection = null)
    {
        $collection = $collection->toArray();

        $this->session->put($this->instance, $collection);
    }

    /**
     * @return mixed
     */
    public function currentInstance()
    {
        return str_replace('cart.', '', $this->instance);
    }

    /**
     * @param array $conditions
     */
    public function conditions(array $conditions)
    {
        if (isset($conditions) && count($conditions) > 0) {
            foreach ($conditions as $condition) {
                $condition->type = 'discount';
                $collection = $this->addDiscount($condition->toArray());
            }
        }
    }

    /**
     * @param array $params
     */
    public function addDiscount(array $params)
    {
        $collection = $this->getCollection(); // get current collection

        // filter for unique discount
        $collection = $collection->filter(function ($item) use ($params) {
            if (($item->type == $params['type']) && ($item->id == $params['id'])) {
                return false;
            }
            return true;
        });

        $collection->push(new DiscountItem($params));

        $this->putCollection($collection);
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getCollection()
    {
        $content = $this->session->has($this->instance) ? collect($this->session->get($this->instance)) : new Collection;

        return $content;
    }

    /**
     * @param int $id
     * @param array $params
     * @return bool|mixed
     * @throws \Exception
     */
    public function update($id, array $params)
    {
        $collection = $this->getCollection();

        $product = $collection->where('id', $id)->first();

        $product->update($params);

        if (!$product) {
            throw new \Exception('Cannot update a non existing product');
        }

        $collection = $collection->where('id', '!=', $id);

        $collection->push($product);

        $this->events->fire('product.updated', $id);

        $this->putCollection($collection);

        return true;
    }

    /**
     * Find item by id
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function get($id)
    {
        $content = $this->items();

        $result = $content->where('id', $id)->first();

        if (!$result) {
            throw new \Exception('Could not find cart entry with id: ' . $id);
        }

        return $result;
    }

    /**
     * @return null
     */
    public function clear()
    {
        $this->session->remove($this->instance);

        return null;
    }

    /**
     * @return integer
     */
    public function items_gross_total()
    {
        $collection = $this->calculations();

        return $collection->sum('total_gross_price');
    }

    /**
     * @return integer
     */
    public function items_vat_total()
    {
        $collection = $this->calculations();

        return $collection->sum('vat_price');
    }

    /**
     * @return float|int
     */
    public function serviceFee()
    {
        return $this->items()->where('type', 'fee')->sum('total_vat_price');
    }

    /**
     * @return int
     */
    public function totalBeforeDiscount()
    {
        return $this->subtotal() + $this->vatTotal();
    }

    /**
     * @return integer
     */
    public function subtotal()
    {
        $collection = $this->calculations();

        $subtotal = $collection->where('type', 'item')->sum('total_gross_price');

        $discounts = ($this->discounts()->sum('discount_price') > 0) ? $this->discounts()->sum('discount_price') : 0;

        return $subtotal - $discounts;
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function discounts()
    {
        $collection = $this->getCollection();

        $vatItemsTotal = $this->calculations()->sum('total_gross_price');

        $collection = $collection->where('type', '=', 'discount')->map(function ($item) use ($vatItemsTotal) {
            $item = (object)$item;

            $item->subject_total = $vatItemsTotal;
            $result = null;

            if ($item->discount_type === 'fixed') {
                $result = $item->discount_amount;

            } elseif ($item->discount_type === 'percentage' || $item->discount_type == 'percent') {
                $result = (($vatItemsTotal / 100) * $item->discount_amount);
            }

            $item->discount_price = $result;
            $item->vat_price = $result;

            return $item;
        });

        return $collection;
    }

    /**
     * @return integer
     */
    public function vatTotal()
    {
        return $this->discountedTotal()->sum('amount');
    }

    /**
     * @return array|Collection
     */
    public function discountedTotal()
    {
        $collection = $this->items();

        $totalVatPrice = $collection->sum('total_gross_price');

        $discount = $this->discounts();

        $ratos = [];

        if (isset($discount) && count($discount) > 0) {
            $discount = $discount->sum('discount_price');
        } else {
            $discount = 0;
        }

        $total_per_vat = [];

        if (count($collection) > 0) {
            foreach ($collection as $item) {
                if (!isset($total_per_vat[$item->vat])) {
                    $total_per_vat[$item->vat] = ($discount > 0) ? $item->total_gross_price : $item->vat_total;
                } else {
                    $total_per_vat[$item->vat] += ($discount > 0) ? $item->total_gross_price : $item->vat_total;
                }
            }
        }

        if (isset($total_per_vat)) {
            foreach ($total_per_vat as $vat => $amount) {
                if (isset($discount) && $discount > 0) {
                    $subjectDiscount = ($discount / $totalVatPrice) * $amount;
                    $vatAmount = ($amount - $subjectDiscount) * ($vat / 100);
                } else {
                    $vatAmount = $amount;
                }
                if (isset($vatAmount) && $vatAmount > 0) {
                    $ratos[] = [
                        'vat_total' => $amount,
                        'vat' => $vat,
                        'formatted_vat' => __('VAT') . ' ' . ($vat + 0) . '%',
                        'amount' => $vatAmount ?? 0,
                        'formatted_amount' => Money::EUR($vatAmount ?? 0)->format(),
                    ];
                }
            }
        }

        $ratos = collect($ratos);

        return $ratos;
    }

    /**
     * @param string $productId
     * @param int $quantity
     * @return mixed
     * @throws \Exception
     */
    public function validateAndAddToCart(string $productId, int $quantity = 0)
    {
        $product = Product::findOrFail($productId);

        $this->findRemoveProduct($productId);

        $productData = [
            'product_id' => $productId,
            'name' => $product->title,
            '_link' => route('shop.product', ['slug' => $product->slug]),
            'type' => 'item',
            'gross_price' => $product->gross_price,
            'special_price' => ($product->special_price > 0 && $product->special_price < $product->gross_price) ? $product->special_price : null,
            'vat' => $product->vat,
            'weight' => $product->weight ?? null,
            'quantity' => $quantity,
        ];

        $this->add($productData);

        return $product;
    }

    /**
     * @param string $shippingMethodId
     * @param int $quantity
     * @return mixed
     * @throws \Exception
     */
    public function validateShippingMethodAndAddToCart(string $shippingMethodId, int $quantity = 1)
    {
        $shippingMethod = ShippingMethods::findOrFail($shippingMethodId);

        $findExistingProduct = $this->find([
            'type' => 'shippingmethod',
        ]);

        if (count($findExistingProduct) > 0) {
            foreach ($findExistingProduct as $product) {
                $this->remove((string)$product->id);
            }
        }

        // Apply free shipping when threshold reached.
        if (($shippingMethod->total_free_shipping_threshold !== null && $shippingMethod->total_free_shipping_threshold > 0) && $this->subtotal() > $shippingMethod->total_free_shipping_threshold) {
            $shippingMethod->gross_price = 0;
        }

        $productData = [
            'product_id' => $shippingMethodId,
            'name' => $shippingMethod->label,
            'type' => 'shippingmethod',
            'gross_price' => $shippingMethod->gross_price,
            'special_price' => ($shippingMethod->special_price > 0 && $shippingMethod->special_price < $shippingMethod->gross_price) ? $shippingMethod->special_price : null,
            'vat' => $shippingMethod->vat,
            'quantity' => $quantity,
        ];

        $this->add($productData);

        return $shippingMethod;
    }

    /**
     * @param string $productId
     * @param string $type
     * @throws \Exception
     */
    public function findRemoveProduct(string $productId, $type = 'item'): void
    {
        $findExistingProduct = $this->find([
            'type' => $type,
            'product_id' => $productId,
        ]);

        if (count($findExistingProduct) > 0) {
            foreach ($findExistingProduct as $product) {
                $this->remove((string)$product->id);
            }
        }
    }

    /**
     * Find items by data
     * @param $data
     * @return array|bool
     */
    public function find(array $data)
    {
        $valid = true;

        $content = $this->all();

        try {
            foreach ($data as $key => $value) {

                $valid = $content->where($key, '=', $value)->all();

                if (!$valid) {
                    $valid = false;
                }
            }
        } catch (\Exception $e) {
            $valid = false;
        }

        if ($valid !== false) {
            return $valid;
        }

        return [];
    }

    /**
     * returns all entries in cart also discounts
     *
     * @return Collection
     */
    public function all()
    {
        $collection = $this->getCollection();

        $collection = $collection->map(function ($item) {
            $item = (object)$item;
            return $item;
        });

        return $collection->sortBy('type')->reverse();
    }

    /**
     * @param int $id
     * @return bool|void
     * @throws \Exception
     */
    public function remove($id)
    {
        try {
            $collection = $this->getCollection();

            $collection = $collection->where('id', '!=', $id);

            $this->events->fire('product.removed', $id);

            $this->putCollection($collection);

        } catch (\Exception $e) {
            throw new \Exception($e->getTraceAsString());
        }
    }

    /**
     * @param array $params
     * @return bool
     * @throws \Exception
     */
    public function add(array $params)
    {
        if (!$params['type']) {
            throw new \Exception('A type is required before adding to cart');
        }

        // discounts should be processed different because of their special calculations in order to support percentage discounts
        // all other products will be processed here
        $collection = $this->addItem($params);

        if (count($collection) > 0) {
            $this->checkRequirements($collection->toArray());
        }

        $params = $this->processArray($collection);

        $collection = (object)$params;

        try {
            $this->events->fire('product.added', $params);

            $this->putCollection($collection);

        } catch (\Exception $e) {
            throw new \Exception($e->getTraceAsString());
        }

        return true;
    }

    /**
     * @param array $params
     * @return Collection|\Illuminate\Support\Collection
     */
    public function addItem(array $params)
    {
        $collection = $this->getCollection(); // get current collection

        $collection->push(new Item($params));

        return $collection;
    }

    /**
     * @param array $params
     * @throws \Exception
     */
    public function checkRequirements(array $params)
    {
        if (count($params) > 0) {
            foreach ($params as $item) {

                if ($item->type != 'discount' && !$item->product_id) {
                    throw new \Exception('Product ID is required'); // must be unique for discounts
                }

                if ($item->type != 'discount') {

                    if (is_null($item->gross_price)) {
                        throw new \Exception('Product gross price is required');
                    }

                    if (is_null($item->vat)) {
                        throw new \Exception('Product vat is required');
                    }

                    if (!$item->quantity) {
                        $item->quantity = 0;
                    }
                }

                if (!$item->name) {
                    throw new \Exception('Product name is required');
                }
            }
        }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function processArray($params)
    {
        $params = $params->map(function ($param) {
            $param->id = (string)Str::uuid();
            $param->quantity = $param->quantity ?? 1;
            return $param;
        });

        return $params;
    }

    /**
     * Get Summary.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary()
    {
        $data = [
            'status' => true,
            'items' => $this->items()->toJson(),
            'subtotal_before_discount' => Money::EUR($this->subtotal_before_discount() ?? 0)->format(),
            'subtotal' => Money::EUR($this->subtotal() ?? 0)->format(),
            'vattotal' => Money::EUR($this->vatTotal() ?? 0)->format(),
            'vats' => $this->vats(),
            'quantity' => $this->quantity() ?? 0,
            'discounts' => $this->discounts(),
            'discount_total' => Money::EUR($this->discountTotal())->format(),
            'total' => Money::EUR($this->total() ?? 0)->format(),
        ];

        return json_encode($data);
    }

    /**
     * @return integer
     */
    public function subtotal_before_discount()
    {
        $collection = $this->calculations();

        $subtotal = $collection->where('type', 'item')->sum('total_gross_price');

        return $subtotal;
    }

    /**
     * @return string
     */
    public function vats()
    {
        return $this->discountedTotal();
    }

    /**
     * @return integer
     */
    public function quantity()
    {
        $collection = $this->items()->where('type', 'item');

        return $collection->sum('quantity');
    }

    /**
     * @return integer
     */
    public function weight()
    {
        $collection = $this->items()->where('type', 'item');

        return $collection->sum('weight');
    }

    public function discountTotal()
    {
        return ($this->discounts()->sum('discount_price') > 0) ? $this->discounts()->sum('discount_price') : 0;
    }

    /**
     * @return integer
     */
    public function total()
    {
        return ($this->subtotal() + $this->grossServiceFee()) + $this->discountedTotal()->sum('amount');
    }

    /**
     * @return float|int
     */
    public function grossServiceFee()
    {
        return $this->items()->where('type', 'fee')->sum('total_gross_price');
    }
}