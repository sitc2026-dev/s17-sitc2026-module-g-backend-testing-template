<?php

namespace App;

final class SubscriptionPlan
{
    /** @param list<array{minUses: int, discountPercent: int}> $discountTiers */
    public function __construct(
        public readonly string $code,
        public readonly int $monthlyBaseFeeYuan,
        public readonly int $includedQuota,
        public readonly int $overageRateYuan,
        public readonly array $discountTiers = [],
    ) {
    }

    /** @return array{minUses: int, discountPercent: int}|null */
    public function matchTier(int $uses): ?array
    {
        $best = null;
        foreach ($this->discountTiers as $tier) {
            if ($uses >= $tier['minUses'] && ($best === null || $tier['minUses'] > $best['minUses'])) {
                $best = $tier;
            }
        }

        return $best;
    }
}
