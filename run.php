#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * CLI entrypoint — demo partner billing export (PHP stdlib only).
 *
 *   php run.php
 */

require __DIR__ . '/autoload.php';

use App\BillingService;
use App\Notifier;
use App\SubscriptionPlan;

$outDir = __DIR__ . '/out';
if (!is_dir($outDir) && !mkdir($outDir, 0777, true) && !is_dir($outDir)) {
    fwrite(STDERR, "Cannot create {$outDir}\n");
    exit(1);
}

$plan = new SubscriptionPlan(
    code: 'FLEET-A',
    monthlyBaseFeeYuan: 1000,
    includedQuota: 100,
    overageRateYuan: 10,
    discountTiers: [
        ['minUses' => 150, 'discountPercent' => 10],
        ['minUses' => 200, 'discountPercent' => 20],
    ],
);

$notifier = new class extends Notifier {
    public function notify(string $recipient, string $message): void
    {
        fwrite(STDOUT, "[notify → {$recipient}] {$message}\n");
    }
};

$service = new BillingService($outDir, $notifier);

$result = $service->exportPartnerSummary(
    partnerId: 'swift-rice',
    partnerName: 'SwiftRice Delivery',
    periodYm: '2026-03',
    plan: $plan,
    uses: 180,
    notifyEmail: 'accountant@swaploop.test',
);

echo "SwapLoop billing export\n";
echo "File: {$result['path']}\n";
echo "Total: {$result['breakdown']['totalYuan']} CNY\n";
echo "---\n";
echo file_get_contents($result['path']);
