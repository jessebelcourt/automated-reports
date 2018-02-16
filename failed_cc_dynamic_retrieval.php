<?php
require 'init.php';

$failed_cc_transaction = new FailedTransaction($db);
$start_date = $_GET['startdate'];
$end_date = $_GET['enddate'];

get_failed_cc_transaction_domains($start_date, $end_date, $failed_cc_transaction, $db);

function get_failed_cc_transaction_domains($start_date, $end_date, $failed_cc_transaction, $db)
{
    $transactions = $failed_cc_transaction->get_failed_cc_transaction_domains($start_date, $end_date);
    $results = array();
    if (is_array($transactions))
    {
        $unique_clients = array();
        foreach($transactions as $transaction)
        {
            $transaction['balance'] = round(floatval($transaction['balance']), 2);
            if (!in_array($transaction['client_id'], $unique_clients))
            {
                $transaction['payment_since_cc_failure'] = $failed_cc_transaction->payment_since_cc_failure($transaction['date'], $transaction['domain_id']);
                $unique_clients[$transaction['client_id']] = NULL;

            }
            array_push($results, $transaction);
        }
    }
    else
    {
        log_message('error',__FUNCTION__ . 'in ' . __FILE__ . ' - no failed cc transactions were retrieved.');
    }
    echo json_encode($results);
}
