<?php
declare(strict_types=1);

namespace Strativ\Console\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{
    private const OPTION_NAME = 'name';
    protected function configure(): void
    {
        $this->setName('say:hello:run');
        $this->setDescription('Say hello to the world');
        $this->addOption(
            self::OPTION_NAME,
            null,
            InputOption::VALUE_OPTIONAL,
            'Name of the person to say hello to'
        );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = 0;

        $name = $input->getOption(self::OPTION_NAME);

        if ($name) {
            $output->writeln("<info>Hello, $name!</info>");
        } else {
            $output->writeln("<info>No name was provided</info>");
        }

        try {
            if (rand(0, 1)) {
                throw new LocalizedException(__('Something went wrong'));
            }
        } catch (LocalizedException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
            return 1;
        }

        return 0;
    }
}
