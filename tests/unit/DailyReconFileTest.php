<?php declare(strict_types=1);
/**
 * Parse the CSV file PatFast emails daily for the Settlement Information.
 *
 * @author    Jacques Marnweeck <jacques@siberia.co.za>
 * @copyright 2018-2020 Jacques Marneweck.  All rights strictly reserved.
 * @license   MPLv2
 */

namespace Jacques\PayFast\Parsers\Tests\Unit;

class DailyReconFileTest extends \PHPUnit\Framework\TestCase
{
    protected array $keys = [
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
    ];

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    public function testOthosPaymentForAirtime(): void
    {
        $parser = new \Jacques\PayFast\Parsers\DailyReconFile(__DIR__.'/../data/payfast-11875039-20170805.csv');
        $results = $parser->parse();

        self::assertIsArray($results);
        self::assertCount(2, $results);

        for ($i = 0; $i < 2; $i++) {
            foreach ($this->keys as $key) {
                self::assertIsArray($results[$i]);
                self::assertCount(24, $results[$i]);
                self::assertArrayHasKey($key, $results[$i]);
            }
        }

        /*
         * 0
         */
        self::assertEquals('2017-08-04 11:14:23', $results['0']['date']);
        self::assertEquals('TOPUP', $results['0']['type']);
        self::assertEquals('CREDIT', $results['0']['sign']);
        self::assertEquals('My Bank Account', $results['0']['party']);
        self::assertEquals('Account topup from FNB', $results['0']['name']);
        self::assertEmpty($results['0']['description']);
        self::assertEquals('ZAR', $results['0']['currency']);
        self::assertEquals('INSTANT_EFT', $results['0']['funding_type']);
        self::assertEquals('1,140.00', $results['0']['gross']);
        self::assertEquals('0.00', $results['0']['fee']);
        self::assertEquals('1,140.00', $results['0']['net']);
        self::assertEquals('1,140.00', $results['0']['balance']);
        self::assertEmpty($results['0']['m_payment_id']);
        self::assertEmpty($results['0']['pf_payment_id']);
        self::assertNull($results['0']['custom_int1']);
        self::assertNull($results['0']['custom_str1']);
        self::assertNull($results['0']['custom_int2']);
        self::assertNull($results['0']['custom_str2']);
        self::assertNull($results['0']['custom_int3']);
        self::assertNull($results['0']['custom_str3']);
        self::assertNull($results['0']['custom_int4']);
        self::assertNull($results['0']['custom_str4']);
        self::assertNull($results['0']['custom_int5']);
        self::assertNull($results['0']['custom_str5']);

        /*
         * 1
         */
        self::assertEquals('2017-08-04 11:14:24', $results['1']['date']);
        self::assertEquals('FUNDS_SENT', $results['1']['type']);
        self::assertEquals('DEBIT', $results['1']['sign']);
        self::assertEquals('Othos Telecommunications', $results['1']['party']);
        self::assertEquals('R1000 Othos Credit', $results['1']['name']);
        self::assertEquals('R1000 of Othos Credit', $results['1']['description']);
        self::assertEquals('ZAR', $results['1']['currency']);
        self::assertEquals('INSTANT_EFT', $results['1']['funding_type']);
        self::assertEquals('-1,140.00', $results['1']['gross']);
        self::assertEquals('0.00', $results['1']['fee']);
        self::assertEquals('-1,140.00', $results['1']['net']);
        self::assertEquals('0.00', $results['1']['balance']);
        self::assertEquals('O4073', $results['1']['m_payment_id']);
        self::assertEquals('8867954', $results['1']['pf_payment_id']);
        self::assertNull($results['1']['custom_int1']);
        self::assertNull($results['1']['custom_str1']);
        self::assertNull($results['1']['custom_int2']);
        self::assertNull($results['1']['custom_str2']);
        self::assertNull($results['1']['custom_int3']);
        self::assertNull($results['1']['custom_str3']);
        self::assertNull($results['1']['custom_int4']);
        self::assertNull($results['1']['custom_str4']);
        self::assertNull($results['1']['custom_int5']);
        self::assertNull($results['1']['custom_str5']);
    }
}
