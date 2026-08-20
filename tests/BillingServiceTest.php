<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

final class BillingServiceTest extends TestCase
{
    public function testWritesPartnerSummaryFileWhoseNameIncludesCurrentDate(): void
    {
        // TODO: implement — real temp dir; basename includes date('Y-m-d')
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testWrittenFileContainsBreakdown(): void
    {
        // TODO: implement — file contents reflect calculator breakdown
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testNotifiesAfterSuccessfulWrite(): void
    {
        // TODO: implement — mock Notifier; expects once after real write
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testDoesNotNotifyWhenWriteFails(): void
    {
        // TODO: implement — bad output dir; Notifier never called
        $this->markTestIncomplete('Competitor implements this test');
    }

    public function testDoesNotWriteOrNotifyWhenUsageIsInvalid(): void
    {
        // TODO: implement — negative uses → no file, no notify
        $this->markTestIncomplete('Competitor implements this test');
    }
}
