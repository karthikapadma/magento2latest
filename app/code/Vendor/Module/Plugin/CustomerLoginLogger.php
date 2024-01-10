<?php
namespace Vendor\Module\Plugin;

use Magento\Customer\Model\AccountManagement;
use Psr\Log\LoggerInterface;

class CustomerLoginLogger
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function aroundAuthenticate(AccountManagement $subject, \Closure $proceed, $username, $password)
    {
        $result = null;
///var_dump("sss");exit;
        try {
            // Call the original method
            $result = $proceed($username, $password);

            // Log customer login attempt
            $this->logger->info('Customer Login Attempt: Email - ' . $username . ', Result - Success');
        } catch (\Exception $e) {
            // Log failed login attempt
            $this->logger->error('Customer Login Attempt: Email - ' . $username . ', Result - Failed. Error: ' . $e->getMessage());

            // Re-throw the exception after logging
            throw $e;
        }

        return $result;
    }
}
