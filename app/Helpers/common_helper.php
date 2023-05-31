<?php

function formatNumber ($value, $decimal = 2) {
    return number_format($value, $decimal);
}

function formatDate ($date, $format = "d-m-Y") {
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
 * @return float
 *
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

    return number_format((float)$commissionAmt, 2);
}
