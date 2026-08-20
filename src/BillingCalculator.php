<?php

namespace App;

final class BillingCalculator
{
    /** @return array<string, int|string> */
    public function summarise(SubscriptionPlan $plan, int $uses): array
    {
        if ($uses < 0) {
            throw new \InvalidArgumentException('Usage must be >= 0');
        }

        $overageUses = max(0, $uses - $plan->includedQuota);
        $overageFee = $overageUses * $plan->overageRateYuan;
        $percent = $plan->matchTier($uses)['discountPercent'] ?? 0;
        $discountYuan = (int) floor($overageFee * $percent / 100);

        return [
            'planCode' => $plan->code,
            'uses' => $uses,
            'quota' => $plan->includedQuota,
            'overageUses' => $overageUses,
            'baseFeeYuan' => $plan->monthlyBaseFeeYuan,
            'overageFeeYuan' => $overageFee,
            'discountPercent' => $percent,
            'discountYuan' => $discountYuan,
            'totalYuan' => $plan->monthlyBaseFeeYuan + $overageFee - $discountYuan,
        ];
    }
}
