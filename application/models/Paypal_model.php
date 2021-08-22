<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/paypal/vendor/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

class Paypal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->client_id = $this->general_settings->paypal_client_id;
        $this->client_secret = $this->general_settings->paypal_client_secret;
        $this->currency = $this->general_settings->currency;
        $this->paypal_store_name = $this->general_settings->paypal_store_name;

        //set API context
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($this->client_id, $this->client_secret)
        );

        $this->apiContext->setConfig(
            array(
                'mode' => 'live',
            )
        );
    }

    //create paypal payment
    public function create_payment($product_id, $price, $plan_type, $day_count, $m_type)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item_name = trans("product_promoting_payment");
        if (empty($this->paypal_store_name)) {
            $this->paypal_store_name = "Paypal";
        }

        $item = new Item();
        $item->setName($item_name)
            ->setCurrency($this->currency)
            ->setQuantity(1)
            ->setSku($product_id)
            ->setPrice($price);
        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($this->get_purchased_plan($plan_type, $day_count))
            ->setInvoiceNumber(uniqid());
        $baseUrl = base_url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . "execute-paypal-payment?success=true&product_id=" . $product_id . "&price=" . $price . "&plan_type=" . $plan_type . "&day_count=" . $day_count . "&m_type=" . $m_type)
            ->setCancelUrl($baseUrl . "execute-paypal-payment?success=false&product_id=" . $product_id . "&price=" . $price . "&plan_type=" . $plan_type . "&day_count=" . $day_count . "&m_type=" . $m_type);

        //create web profile
        $flowConfig = new \PayPal\Api\FlowConfig();
        $flowConfig->setLandingPageType("Billing");
        $flowConfig->setBankTxnPendingUrl(base_url());
        $flowConfig->setUserAction("commit");
        $flowConfig->setReturnUriHttpMethod("GET");
        $presentation = new \PayPal\Api\Presentation();
        $presentation->setBrandName($this->paypal_store_name)
            ->setReturnUrlLabel("Return")
            ->setNoteToSellerLabel("Thanks!");
        $inputFields = new \PayPal\Api\InputFields();
        $inputFields->setAllowNote(true)
            ->setNoShipping(1)
            ->setAddressOverride(0);
        $webProfile = new \PayPal\Api\WebProfile();
        $webProfile->setName($this->paypal_store_name . "-" . uniqid())
            ->setFlowConfig($flowConfig)
            ->setPresentation($presentation)
            ->setInputFields($inputFields)
            ->setTemporary(true);

        $createProfileResponse = $webProfile->create($this->apiContext);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setExperienceProfileId($createProfileResponse->getId())
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $request = clone $payment;
        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            $this->session->set_flashdata('error', trans("msg_payment_error"));
            return base_url() . "pricing/" . $product_id . "?m_type=$m_type";
        }

        return $payment->getApprovalLink();
    }

    //execute paypal payment
    public function execute_payment()
    {
        $response = $this->input->get('success', true);
        $product_id = $this->input->get('product_id', true);
        $price = $this->input->get('price', true);
        $plan_type = $this->input->get('plan_type', true);
        $day_count = $this->input->get('day_count', true);
        $m_type = $this->input->get('m_type', true);

        if ($response == false) {
            $this->session->set_flashdata('error', trans("msg_payment_error"));
            return base_url() . "pricing/" . $product_id . "?m_type=$m_type";
        }

        $paymentId = $this->input->get('paymentId', true);
        $payerId = $this->input->get('PayerID', true);

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $transaction = new Transaction();
        $amount = new Amount();

        $amount->setCurrency($this->currency);
        $amount->setTotal($price);
        $transaction->setAmount($amount);
        $execution->addTransaction($transaction);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            $data = array(
                'payment_method' => "Paypal",
                'payment_id' => $payment->getId(),
                'user_id' => user()->id,
                'product_id' => $product_id,
                'currency' => $payment->getTransactions()[0]->getAmount()->currency,
                'payment_amount' => $payment->getTransactions()[0]->getAmount()->total,
                'payer_email ' => $payment->getPayer()->getPayerInfo()->email,
                'payment_status' => $payment->getState(),
                'purchased_plan' => $this->get_purchased_plan($plan_type, $day_count),
                'created_at' => date("Y-m-d H:i:s"),
            );

            //add payment to database
            $this->load->model("payment_model");
            if ($m_type == "new") {
                if ($this->payment_model->add_payment($data)) {
                    $this->product_model->add_to_promoted_products($product_id, $this->get_purchased_plan($plan_type, $day_count), $day_count);
                    $this->session->set_flashdata('success', trans("msg_add_product_success"));
                    return base_url() . "sell-now";
                } else {
                    $this->session->set_flashdata('error', trans("msg_payment_database_error"));
                    return base_url() . "sell-now";
                }
            } else {
                if ($this->payment_model->add_payment($data)) {
                    $this->product_model->add_to_promoted_products($product_id, $this->get_purchased_plan($plan_type, $day_count), $day_count);
                    $this->session->set_flashdata('success', trans("msg_payment_success"));
                    return base_url() . "pricing/" . $product_id . "?m_type=$m_type";
                } else {
                    $this->session->set_flashdata('error', trans("msg_payment_database_error"));
                    return base_url() . "pricing/" . $product_id . "?m_type=$m_type";
                }
            }

        } catch (Exception $ex) {
            $this->session->set_flashdata('error', trans("msg_payment_error"));
            return base_url() . "pricing/" . $product_id . "?m_type=$m_type";
        }
    }

    public function get_purchased_plan($plan_type, $day_count)
    {
        if ($plan_type == "daily") {
            return trans("daily_plan") . " (" . $day_count . " " . trans("days") . ")";
        } elseif ($plan_type == "monthly") {
            return trans("monthly_plan") . " (" . $day_count . " " . trans("days") . ")";
        } else {
            return "";
        }
    }


}