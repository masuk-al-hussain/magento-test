<?php

namespace Strativ\Cron\Cron;

use Psr\Log\LoggerInterface;

class MyTask
{
    /**
     * @var LoggerInterface $logger
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute the cron job
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->info('Cron job executed successfully');
    }
}
