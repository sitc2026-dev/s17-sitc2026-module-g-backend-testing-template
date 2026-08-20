<?php

namespace Tests;

use App\SubscriptionPlan;
use PHPUnit\Framework\TestCase;

final class DiscountTierTest extends TestCase
{
    public function testSelectsHighestMatchingTierForUsageCount(): void
    {
        // TODO: implement — SubscriptionPlan::matchTier
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testReturnsNoTierWhenUsageIsBelowAllThresholds(): void
    {
        // TODO: implement
        $this->markTestIncomplete('Competitor implements this test');
    }
}
