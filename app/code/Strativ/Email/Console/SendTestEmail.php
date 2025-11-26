<?php

// CLI Command to test sending email

namespace Strativ\Email\Console;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Strativ\Email\Model\EmailSender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendTestEmail extends Command
{
    /**
     * @var EmailSender
     */
    protected EmailSender $emailSender;

    /**
     * @var State
     */
    protected State $state;

    /**
     * @param EmailSender $emailSender
     * @param State $state
     */
    public function __construct(
        EmailSender $emailSender,
        State       $state
    ) {
        $this->emailSender = $emailSender;
        $this->state = $state;
        parent::__construct();
    }

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('email:sendtest')
            ->setDescription('Send a test email')
            ->addArgument('email', InputArgument::REQUIRED, 'Recipient Email');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            // Set area code to frontend
            $this->state->setAreaCode(Area::AREA_FRONTEND);
        } catch (\Exception $e) {
        }

        $email = $input->getArgument('email');
        $result = $this->emailSender->send($email, 'Test Customer');

        if ($result === true) {
            $output->writeln("<info>Test email sent successfully to $email</info>");
            return 0;
        } else {
            $output->writeln("<error>Failed to send email: $result</error>");
            return 1;
        }
    }
}
