<?php

public function get_failed_cc_transaction_domains($start_date, $end_date)
    {
        $query =
            "SELECT
                failed_cc_table_accounts.id AS id,
                failed_cc_table_accounts.amt AS amt,
                failed_cc_table_accounts.failed_account_id AS trans_id,
                failed_cc_table_accounts.entry_id AS entry_id,
                failed_cc_table_accounts.failed_attempt_date AS date,
                hidden_name.type AS type,
                hidden_name.thing AS thing,
                hidden_name.status AS status,
                failed_cc_table.client_id AS cl_id,
                failed_cc_table.amt AS total_transaction_amt,
                c.tcharges - COALESCE(p.tpayments, 0) AS balance
            FROM failed_cc_table_accounts
            LEFT JOIN hidden_name ON failed_cc_table_accounts.entry_id=hidden_name.id
            LEFT JOIN failed_cc_table ON failed_cc_table_accounts.failed_account_id=failed_cc_table.id
            LEFT JOIN (
                        SELECT
                            fees.entry_id AS id,
                            SUM(fees.amt) AS tfees
                        FROM fees
                        WHERE fees.entry_id = entry_id
                        GROUP BY fees.entry_id
                        ) AS c ON failed_cc_table_accounts.entry_id=c.id
            LEFT JOIN (
                        SELECT money_in.entry_id AS id,
                        SUM(money_in.amt) AS tmoney_in
                        FROM money_in
                        WHERE money_in.entry_id = entry_id
                        GROUP BY money_in.entry_id
                        ) AS p ON failed_cc_table_accounts.entry_id=p.id
            WHERE failed_cc_table_accounts.failed_attempt_date >= '$start_date'
            AND failed_cc_table_accounts.failed_attempt_date <= '$end_date'";
        $this->db->query($query);
        return $this->db->hash_with_key('id');
    }