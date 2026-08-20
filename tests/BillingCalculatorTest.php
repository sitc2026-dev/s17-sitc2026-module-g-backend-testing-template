<?php

namespace Tests;

use App\BillingCalculator;
use PHPUnit\Framework\TestCase;

final class BillingCalculatorTest extends TestCase
{
    private BillingCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new BillingCalculator();
    }

    public function testCalculatesBaseFeeOnlyWhenUsesStayWithinQuota(): void
    {
        // TODO: implement
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testCalculatesOverageWithoutDiscountWhenNoTierMatches(): void
    {
        // TODO: implement
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testAppliesVolumeDiscountToOverageOnly(): void
    {
        // TODO: implement
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testRejectsNegativeUsage(): void
    {
        // TODO: implement
        $this->markTestIncomplete('Competitor implements this test');
    }
}
