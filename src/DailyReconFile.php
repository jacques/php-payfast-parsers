<?php
/**
 * Parse the CSV file PatFast emails daily for the Settlement Information.
 *
 * @author    Jacques Marnweeck <jacques@siberia.co.za>
 * @copyright 2018 Jacques Marneweck.  All rights strictly reserved.
 * @license   MPLv2
 */

namespace Jacques\PayFast\Parsers;

use Carbon\Carbon;
use League\Csv\Reader;

class DailyReconFile
{
    protected $filename = null;

    protected $expectedHeaders = [
        'Date',
        'Type',
        'Sign',
        'Party',
        'Name',
        'Description',
        'Currency',
        'Funding Type',
        'Gross',
        'Fee',
        'Net',
        'Balance',
        'M Payment ID',
        'PF Payment ID',
    ];

    protected $expectedHeadersReceipts = [
        'Date',
        'Type',
        'Sign',
        'Party',
        'Name',
        'Description',
        'Currency',
        'Funding Type',
        'Gross',
        'Fee',
        'Net',
        'Balance',
        'M Payment ID',
        'PF Payment ID',
        'Custom_int1',
        'Custom_str1',
        'Custom_int2',
        'Custom_str2',
        'Custom_int3',
        'Custom_str3',
        'Custom_int4',
        'Custom_str4',
        'Custom_int5',
        'Custom_str5',
    ];

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        if (is_null($filename)) {
            throw new \InvalidArgumentException('Please pass in the filename of the file to parse.');
        }

        if (!file_exists($filename)) {
            throw new \RuntimeException('Please ensure the file exists.');
        }

        $this->filename = $filename;
    }

    public function parse()
    {
        $csv = Reader::createFromPath($this->filename, 'r');

        $headers = $csv->fetchOne();
        /**
         * PayFast send two different formatted files depending if we have received
         * any payments.
         */
        if (
            $headers != $this->expectedHeaders &&
            $headers != $this->expectedHeadersReceipts
        ) {
            throw new \Exception(
                'Please check the file is a PayFast Daily Reconciliation file.'
            );
        }

        $results = $csv->setOffset(1)->fetchAssoc([
            'date',
            'type',
            'sign',
            'party',
            'name',
            'description',
            'currency',
            'funding_type',
            'gross',
            'fee',
            'net',
            'balance',
            'm_payment_id',
            'pf_payment_id',
            'custom_int1',
            'custom_str1',
            'custom_int2',
            'custom_str2',
            'custom_int3',
            'custom_str3',
            'custom_int4',
            'custom_str4',
            'custom_int5',
            'custom_str5',
        ]);

        $rows = [];
        foreach ($results as $row) {
            $rows[] = $row;
        }

        return ($rows);
    }
}
