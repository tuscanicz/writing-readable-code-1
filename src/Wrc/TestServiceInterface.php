<?php

declare(strict_types=1);

namespace Wrc;

use Symfony\Component\Console\Output\OutputInterface;
use Wrc\Command\AddressList;

interface TestServiceInterface
{
    public function process(AddressList $addressList, OutputInterface $output);
}
