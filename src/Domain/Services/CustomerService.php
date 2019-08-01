<?php

namespace Exdeliver\Causeway\Domain\Services;

use Carbon\Carbon;
use Exception;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer;
use Exdeliver\Causeway\Infrastructure\Repositories\ContactRepository;
use Exdeliver\Causeway\Infrastructure\Repositories\CustomerRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class CustomerService.
 */
final class CustomerService extends AbstractService
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var ContactRepository
     */
    protected $contactRepository;

    /**
     * CustomerService constructor.
     *
     * @param CustomerRepository $customerRepository
     * @param ContactRepository  $contactRepository
     */
    public function __construct(CustomerRepository $customerRepository, ContactRepository $contactRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @return mixed
     *
     * @throws Throwable
     */
    public function saveCustomer()
    {
        try {
            $customer = DB::transaction(function () {
                $customer = $this->customerRepository->create([]);

                return $customer;
            });

            return $customer;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param Customer $customer
     * @param array    $params
     * @param string   $contactType
     * @param bool     $primaryContact
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function saveContact(Customer $customer, array $params, string $contactType = 'general', bool $primaryContact = true)
    {
        $params = (object) $params;

        try {
            $contact = DB::transaction(function () use ($customer, $params, $contactType, $primaryContact) {
                $contactPrefix = '';
                if ('shipping' === $contactType) {
                    $contactPrefix = 'shipping_';
                }

                $contact = $this->contactRepository->create([
                    'customer_id' => $customer->id,
                    'primary' => $primaryContact,
                    'type' => $contactType,
                    'gender' => $params->{$contactPrefix.'gender'} ?? null,
                    'company' => $params->{$contactPrefix.'company'} ?? null,
                    'first_name' => $params->{$contactPrefix.'first_name'} ?? null,
                    'last_name' => $params->{$contactPrefix.'last_name'} ?? null,
                    'birth_date' => (isset($params->birth) && count($params->birth) > 0) ? Carbon::parse($params->birth['year'].'-'.$params->birth['month'].'-'.$params->birth['day']) : null,
                    'email' => $params->{$contactPrefix.'email'} ?? null,
                    'address' => $params->{$contactPrefix.'address'} ?? null,
                    'address_number' => $params->{$contactPrefix.'address_number'} ?? null,
                    'address_suffix' => $params->{$contactPrefix.'address_suffix'} ?? null,
                    'zipcode' => $params->{$contactPrefix.'zipcode'} ?? null,
                    'city' => $params->{$contactPrefix.'city'} ?? null,
                    'country' => $params->{$contactPrefix.'country'} ?? null,
                ]);

                return $contact;
            });

            return $contact;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
