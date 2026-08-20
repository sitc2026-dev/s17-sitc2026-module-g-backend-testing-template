<?php

namespace App;

class Notifier
{
    public function notify(string $recipient, string $message): void
    {
        echo $recipient . ': ' . $message . PHP_EOL;
    }
}
