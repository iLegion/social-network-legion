<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Log;

class LoggerService
{
    private Log $log;

    private const TYPES = [
        Post::class => 'post-operations'
    ];

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function info(string $type, string $message, array $context = []): bool
    {
        if (!$this->checkType($type)) return false;

        $this->log::channel(self::TYPES[$type])->info($message, $context);

        return true;
    }

    private function checkType(string $type): bool
    {
        return array_key_exists($type, self::TYPES);
    }
}
