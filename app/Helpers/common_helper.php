<?php

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
            echo "<span class='badge badge-success'>$label<span>";
            break;
        case 'Cancelled':
        case 'Failed':
        case 'Rejected':
        case 'InActive':
            echo "<span class='badge badge-danger'>$label<span>";
            break;
        default: echo "<span class='badge badge-primary'> N/A <span>"; break;
    }
}
