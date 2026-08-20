<?php

namespace App;

abstract class BillingDocument
{
    public function __construct(public readonly string $periodYm)
    {
    }

    abstract public function kind(): string;

    abstract public function render(): string;

    abstract public function filenameFor(string $dateYmd): string;
}

final class PartnerSummary extends BillingDocument
{
    /** @param array<string, int|string> $breakdown */
    public function __construct(
        string $periodYm,
        public readonly string $partnerId,
        public readonly string $partnerName,
        public readonly array $breakdown,
    ) {
        parent::__construct($periodYm);
    }

    public function kind(): string
    {
        return 'partner_summary';
    }

    public function render(): string
    {
        $lines = ["partner={$this->partnerId}", "name={$this->partnerName}", "period={$this->periodYm}"];
        foreach ($this->breakdown as $key => $value) {
            $lines[] = "{$key}={$value}";
        }

        return implode("\n", $lines) . "\n";
    }

    public function filenameFor(string $dateYmd): string
    {
        return "partner-{$this->partnerId}-{$this->periodYm}-{$dateYmd}.txt";
    }
}

final class FinanceCsv extends BillingDocument
{
    /** @param list<array{partnerId: string, partnerName: string, breakdown: array<string, int|string>}> $rows */
    public function __construct(string $periodYm, private readonly array $rows)
    {
        parent::__construct($periodYm);
    }

    public function kind(): string
    {
        return 'finance_csv';
    }

    public function render(): string
    {
        $out = ["partnerId,partnerName,period,plan,uses,totalYuan"];
        foreach ($this->rows as $row) {
            $b = $row['breakdown'];
            $out[] = "{$row['partnerId']},{$row['partnerName']},{$this->periodYm},{$b['planCode']},{$b['uses']},{$b['totalYuan']}";
        }

        return implode("\n", $out) . "\n";
    }

    public function filenameFor(string $dateYmd): string
    {
        return "finance-{$this->periodYm}-{$dateYmd}.csv";
    }
}

final class DocumentFactory
{
    /** @param array<string, mixed> $config */
    public function create(array $config): BillingDocument
    {
        $kind = $config['kind'] ?? '';
        $periodYm = (string) ($config['periodYm'] ?? '');

        return match ($kind) {
            'partner_summary' => new PartnerSummary(
                $periodYm,
                (string) ($config['partnerId'] ?? ''),
                (string) ($config['partnerName'] ?? ''),
                $config['breakdown'] ?? [],
            ),
            'finance_csv' => new FinanceCsv($periodYm, $config['rows'] ?? []),
            default => throw new \InvalidArgumentException('Unknown document kind: ' . $kind),
        };
    }
}
