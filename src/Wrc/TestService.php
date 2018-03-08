<?php

declare(strict_types=1);

namespace Wrc;

use Symfony\Component\Console\Output\OutputInterface;
use Wrc\Api\ForeignApiHandler;
use Wrc\Api\UnableToGetContentException;
use Wrc\Command\AddressList;

class TestService implements TestServiceInterface
{
    private $foreignApiHandler;

    public function __construct(ForeignApiHandler $foreignApiHandler)
    {
        $this->foreignApiHandler = $foreignApiHandler;
    }

    public function process(AddressList $addressList, OutputInterface $output): string
    {
        if ($addressList->hasAddresses() === true) {
            try {
                $drivetoHomepageResult = $this->foreignApiHandler->handleReadable($addressList->getFirstAddress()->getUrl());
            } catch (UnableToGetContentException $e) {
                $output->writeln($e->getMessage());
                try {
                    $drivetoHomepageResult = $this->foreignApiHandler->handleReadable($addressList->getSecondAddress()->getUrl());
                } catch (UnableToGetContentException $e) {
                    $output->writeln($e->getMessage());

                    throw new \InvalidArgumentException(
                        'Neither of the two addresses given contain any text'
                    );
                }
            }

            return $drivetoHomepageResult->getContents();
        }

        throw new \InvalidArgumentException(
            'No addresses given'
        );
    }
}
