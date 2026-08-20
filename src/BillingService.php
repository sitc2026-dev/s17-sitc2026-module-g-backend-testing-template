<?php

namespace App;

/**
 * Partner billing export — no database, no external libraries.
 * Uses date() and file_put_contents() directly.
 */
class BillingService
{
    private BillingCalculator $calculator;
    private DocumentFactory $documents;

    public function __construct(
        private string $outputDir,
        private Notifier $notifier,
    ) {
        $this->calculator = new BillingCalculator();
        $this->documents = new DocumentFactory();
    }

    /** @return array{filename: string, path: string, breakdown: array<string, int|string>} */
    public function exportPartnerSummary(
        string $partnerId,
        string $partnerName,
        string $periodYm,
        SubscriptionPlan $plan,
        int $uses,
        string $notifyEmail,
    ): array {
        $breakdown = $this->calculator->summarise($plan, $uses);

        $document = $this->documents->create([
            'kind' => 'partner_summary',
            'periodYm' => $periodYm,
            'partnerId' => $partnerId,
            'partnerName' => $partnerName,
            'breakdown' => $breakdown,
        ]);

        $filename = $document->filenameFor(date('Y-m-d'));
        $path = rtrim($this->outputDir, '/\\') . DIRECTORY_SEPARATOR . $filename;

        if (file_put_contents($path, $document->render()) === false) {
            throw new \RuntimeException('Failed to write ' . $path);
        }

        $this->notifier->notify($notifyEmail, 'Exported: ' . $filename);

        return [
            'filename' => $filename,
            'path' => $path,
            'breakdown' => $breakdown,
        ];
    }
}
