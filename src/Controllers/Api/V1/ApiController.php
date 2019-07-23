<?php

namespace Exdeliver\Causeway\Controllers\Api\V1;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Cart\Domain\Services\CartService;
use Exdeliver\Causeway\Domain\Services\CustomerService;
use Exdeliver\Causeway\Domain\Services\OrderService;
use Exdeliver\Causeway\Domain\Services\PaymentService;
use Exdeliver\Causeway\Domain\Services\UserService;
use Laravel\Passport\ClientRepository;
use Lcobucci\JWT\Parser;

/**
 * Class ApiController
 * @package App\Http\Controllers\Api\V1
 */
class ApiController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var OrganisationService
     */
    protected $organisationService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * @var User
     */
    protected $user;

    /**
     * ApiController constructor.
     *
     * @param ClientRepository $clientRepository
     * @param UserService $userService
     * @param CustomerService $customerService
     * @param OrderService $orderService
     * @param CartService $cartService
     * @param PaymentService $paymentService
     */
    public function __construct(ClientRepository $clientRepository, UserService $userService, CustomerService $customerService, OrderService $orderService, CartService $cartService, PaymentService $paymentService)
    {
        $this->clientRepository = $clientRepository;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
        $this->user = $this->getUser();
    }

    /**
     * Get user through clientId.
     *
     * @return User
     */
    private function getUser()
    {
        if (request()->bearerToken() !== null) {
            $clientId = (new Parser())->parse(request()->bearerToken())->getClaim('aud');
            $client = $this->clientRepository->find($clientId);

            return $this->userService->repository->find((int)$client->user_id);
        }
        return null;
    }

    /**
     * Process API payment
     */
    public function payment()
    {
        try {
            $order = Order::where('payment_id', request()->id)->firstOrFail();

            $this->paymentService->validate($order);

            $status = $order->is_paid;
            if ($status === true) {
                $this->orderService->sendPaymentConfirmationToCustomer($order);
            }

            return response()->json(['status' => $status]);

        } catch (\Exception $e) {
            throw new \Exception('API could\'nt validate payment. Error: ' . $e->getMessage());
        }
    }
}