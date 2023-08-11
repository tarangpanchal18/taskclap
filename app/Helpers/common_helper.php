<?php

function createSlug($string) {
    if ($string) {
        $string = strtolower($string);
        $string = str_replace(' ', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace('/', '', $string);

        return $string;
    }
}

function formatNumber ($value, $decimal = 2) {
    if ($value)
        return number_format($value, $decimal);
}

function formatDate ($date, $format = "d-m-Y") {
    if ($date)
        return date($format, strtotime($date));
}

function generate_badge($label) {
    switch ($label) {
        case 'Started':
            echo "<span class='badge badge-info'>$label<span>";
            break;
        case 'Placed':
        case 'Pending':
            echo "<span class='badge badge-warning'>$label<span>";
            break;
        case 'Active':
        case 'Completed':
        case 'Yes':
            echo "<span class='badge badge-success'>$label<span>";
            break;
        case 'Cancelled':
        case 'Failed':
        case 'Rejected':
        case 'InActive':
        case 'No':
            echo "<span class='badge badge-danger'>$label<span>";
            break;
        default: echo "<span class='badge badge-primary'> N/A <span>"; break;
    }
}

/**
 * Returns the order commission based on order object
 * @param Object $order
 */
function getOrderCommission($order): float
{
    if (! $order->orderDetail) {
        return 0;
    }
    $total = $materialCharge = $additionalCharge = $commissionAmt = 0;
    foreach ($order->orderDetail as $orderDetail) {
        $total += $orderDetail->product_price;
        $materialCharge += $orderDetail->material_charge_actual;
        $additionalCharge += $orderDetail->additional_charge;
        //Finding Commission Amount
        $baseAmount = ($orderDetail->product_price + $orderDetail->additional_charge + ($orderDetail->material_charge - $orderDetail->material_charge_actual));
        $commissionAmt += ($baseAmount * $orderDetail->product_commission) / 100;
    }

    return (float)number_format($commissionAmt, 2);
}

/**
 * Retrive cart Items From cookies
 */
function getCartItems(): array
{
    $cartItems = $_COOKIE['cartDetail'];
    if (empty($cartItems)) {
        return [];
    }

    $cartItems = json_decode($cartItems, true);
    foreach($cartItems as $cart) {
        $returnArr[$cart['productId']] = $cart['qty'];
    }

    return $returnArr;
}

/**
     * Generates a secure encrypted data
     * @return mixed
     */
    function encryptData(mixed $data)
    {
        return base64_encode($data);
    }

    /**
     * Decrypt the encrypted data
     * @return mixed
     */
    function decryptData(mixed $data)
    {
        return base64_decode($data);
    }

    /**
     * Format date as per the given format
     * @return string
     */
    function formatDt(string $date, $format = "d-M-Y")
    {
        return date($format, strtotime($date));
    }

    /**
     * Get Client IP Address
     * Ref. https://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
     */
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

