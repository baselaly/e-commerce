<?php

namespace App\Services\Payment;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaypalService implements PaymentInterface
{
    private $api_context;

    public function __construct()
    {
        $paypal_configuration = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    /**
     * @param mixed $carts
     * 
     * @return array
     */
    public function pay($carts): array
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = array();
        $totalAmount = 0;
        foreach ($carts as $cart) {
            $item = new Item();
            $item->setName($cart->product->name)
                ->setCurrency('USD')
                ->setQuantity($cart->quantity)
                ->setPrice($cart->product->price);

            array_push($items, $item);
            $totalAmount += $cart->total;
        }

        $item_list = new ItemList();
        $item_list->setItems($items);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($totalAmount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Checkout Your Cart From E-commerce');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('success.paypal')) // replace by vue frontend route
            ->setCancelUrl(route('cancel.paypal')); // replace by vue frontend route

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $result = $payment->create($this->_api_context);
            $links = $result->links;
            $approveLink = null;
            foreach ($links as $link) {
                if ($link->rel === 'approval_url') {
                    $approveLink = $link->href;
                }
            }

            return [
                'message' => 'Approve your payment via paypal',
                'payment_method' => 'paypal',
                'approval_link' => $approveLink
            ];
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param array $paymentData
     * 
     * @return void
     */
    public function executePayment(array $paymentData): void
    {
        $payment = Payment::get($paymentData['paymentId'], $this->api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($paymentData['PayerID']);
        $result = $payment->execute($execution, $this->api_context);
        if (!$result->getState() === 'approved') {
            throw new \Exception('Transaction Failed!');
        }
    }
}
