#!/usr/bin/env php
<?php

/**
 * Build a date range for the previous quarter
 * @return array: sd - start date of quarter; ed - end date of quarter; q - quarter
 */
function get_current_quarter_date_range()
{
    $today = new DateTime();
    $month = (int) $today->format('m');
    $year = (int) $today->format('Y');

    //Check what the current quarter is
    if($month >= 1 && $month <=3)
    {
        return build_date_range_arr(4, $year, 1);
    }
    else if($month >= 4 && $month <= 6)
    {
        return build_date_range_arr(1, $year);
    }
    else if($month >= 7 && $month <= 9)
    {
        return build_date_range_arr(2, $year);
    }
    else
    {
        return build_date_range_arr(3, $year);
    }
}

/**
 * @param $quarter: current quarter
 * @param $year: year of date range
 * @param $start_month: first month of quarter
 * @param $current_year_offset: subtracted from $year in date calculation
 * @return array: sd - start date of quarter; ed - end date of quarter; q - quarter
 */
function build_date_range_arr($quarter, $year, $current_year_offset=0)
{
    $start_month = ($quarter * 3) - 2;
    $formatted_date_string = '%d-%02d-%02d';
    $end_month = $start_month + 2;
    $sd = sprintf($formatted_date_string, $year - $current_year_offset, $start_month, 1);
    $ld = (int) date('t', strtotime(sprintf($formatted_date_string, $year - $current_year_offset, $end_month, 1)));
    $ed = sprintf($formatted_date_string, $year - $current_year_offset, $end_month, $ld);
    return array('sd'=>$sd, 'ed'=>$ed, 'q'=>$quarter);
}

// Send an email every quarter with a link to where the spreadsheet can be downloaded.
$date_range = get_current_quarter_date_range();
$message = "This is a list of failed credit card transactions {$date_range['sd']} and {$date_range['ed']} during quarter {$date_range['q']}\n";
$message .= "http://$office_domain/failed_cc_transactions.php?startdate={$date_range['sd']}&enddate={$date_range['ed']}";

mail($email_address, "Failed credit card transactions during quarter {$date_range['q']}", $message);
