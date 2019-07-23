<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Domain\Contracts\Services\Shipping;
use Exdeliver\Causeway\Domain\Entities\Shop\Customers\Contact;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use MyParcelNL\Sdk\src\Model\MyParcelConsignment;

/**
 * Class MyParcelService
 * @package Domain\Services
 */
class MyParcelService extends AbstractApiService implements Shipping
{
    public const TYPE = 'myParcel';

    public const PACKAGE_DEFAULT = 1;
    public const MAILBOX_PACKAGE = 2;
    public const LETTER = 3;
    public const DIGITAL_STAMP = 4;

    /**
     * @var MyParcelConsignment
     */
    protected $myParcelConsignment;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $myParcelKey;

    /**
     * MollieService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if (env('APP_ENV') === 'production') {
            $this->myParcelKey = env('MYPARCEL_LIVE_API_KEY', null);
        } else {
            $this->myParcelKey = env('MYPARCEL_LIVE_API_KEY', null);
        }

        if (isset($this->myParcelKey)) {
            $this->setKey($this->myParcelKey);
        }

        $this->myParcelConsignment = (new MyParcelConsignment())
            ->setApiKey($this->getKey());
    }

    /**
     * @param Order $order
     * @param Contact $sendTo
     * @return MyParcelConsignment
     * @throws \MyParcelNL\Sdk\src\Exception\MissingFieldException
     */
    public function createConsignment(Order $order, Contact $sendTo)
    {
        return $this->myParcelConsignment
            ->setReferenceId('Order ' . $order->id)
            // Recipient/address: https://myparcelnl.github.io/api/#7_B
            ->setPerson($sendTo->full_name)// Name
            ->setEmail($sendTo->email ?? null)// E-mail address
            ->setPhone($sendTo->phone ?? null)// Phone number
            ->setCompany($sendTo->company ?? null)// Company
            // OR send the street data separately:
            ->setStreet($sendTo->address)// Street
            ->setNumber((string)$sendTo->address_number)// Number
            ->setNumberSuffix($sendTo->address_number_suffix ?? null)// Suffix
            ->setCity($sendTo->city)// City
            ->setPostalCode($sendTo->zipcode)// Postal code
            ->setCountry($sendTo->country)// Country
            ->setPackageType(self::PACKAGE_DEFAULT)
            // Options (https://myparcelnl.github.io/api/#6_A_3)
            ->setOnlyRecipient(false)// Deliver the package only at address of the intended recipient. This option is required for Morning and Evening delivery types.
            ->setSignature(true)// Recipient must sign for the package. This option is required for Pickup and Pickup express delivery types.
            ->setReturn(true)// Return the package to the sender when the recipient is not home.
            ->setLargeFormat(false)// Must be specified if the dimensions of the package are between 100x70x50 and 175x78x58 cm.
            ->setInsurance(250)// Allows a shipment to be insured up to certain amount. Only packages (package type 1) can be insured.
            ->setLabelDescription('Order ' . $order->id)// This description will appear on the shipment label for non-return shipments.
            // Delivery: https://myparcelnl.github.io/api/#8
//            ->setDeliveryType()
//            ->setDeliveryDate()
            // Set pickup location
            ->setPickupLocationName('Supermarkt')
            ->setPickupStreet('Straatnaam')
            ->setPickupNumber('32')
            ->setPickupPostalCode('1234 AB')
            ->setPickupCity('Hoofddorp')
            // Physical properties
            ->setPhysicalProperties(['weight' => 73]);
        // Array with physical properties of the shipment. Currently only used to set the weight in grams for digital stamps (which is required)
        // Non-EU shipment attributes: see https://myparcelnl.github.io/api/#7_E
//            ->setInvoice()
//            ->setContents()
//            ->addItem()
        // Convert pickup data from checkout
        // You can use these if you use the following code in your checkout: https://github.com/myparcelnl/checkout
//            ->setDeliveryDateFromCheckout()
//            ->setPickupAddressFromCheckout();
    }
}