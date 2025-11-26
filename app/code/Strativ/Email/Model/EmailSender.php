<?php

namespace Strativ\Email\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;

class EmailSender
{
    private const string TEMPLATE_ID = 'strativ_email_template';

    private $transportBuilder;
    private $scopeConfig;

    public function __construct(
        TransportBuilder     $transportBuilder,
        ScopeConfigInterface $scopeConfig,
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    public function send($email, $customerName)
    {
        try {
            $from = [
                'email' => $this->scopeConfig->getValue('trans_email/ident_support/email', ScopeInterface::SCOPE_STORE),
                'name' => $this->scopeConfig->getValue('trans_email/ident_support/name', ScopeInterface::SCOPE_STORE),
            ];

            $templateVars = [
                'customer_name' => $customerName,
                'customer_message' => 'This is a test email from the Strativ module.',
            ];

            $transport = $this->transportBuilder
                ->setTemplateIdentifier(self::TEMPLATE_ID)
                ->setTemplateOptions([
                    'area' => 'frontend',
                    'store' => 1,
                ])
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($email)
                ->getTransport();

            $transport->sendMessage();
            return true;
        } catch (MailException $e) {
            return $e->getMessage();
        }
    }
}
