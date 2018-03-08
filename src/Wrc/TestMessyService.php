<?php

declare(strict_types=1);

namespace Wrc;

use Symfony\Component\Console\Output\OutputInterface;
use Wrc\Api\ForeignApiHandler;
use Wrc\Command\AddressList;

class TestMessyService implements TestServiceInterface
{
    private $foreignApiHandler;

    public function __construct(ForeignApiHandler $foreignApiHandler)
    {
        $this->foreignApiHandler = $foreignApiHandler;
    }

    public function process(AddressList $addressList, OutputInterface $output): ?string
    {
        $drivetoHomepageResultContents = null;
        if ($addressList->hasAddresses() === true) {
            $drivetoHomepageResult = $this->foreignApiHandler->handleMessy($addressList->getFirstAddress()->getUrl());
            if (array_key_exists('result', $drivetoHomepageResult)) {
                if ($drivetoHomepageResult['result'] === null) {
                    $output->writeln($drivetoHomepageResult['error']);
                    $drivetoHomepageResult = $this->foreignApiHandler->handleMessy($addressList->getSecondAddress()->getUrl());
                    if (array_key_exists('result', $drivetoHomepageResult)) {
                        if ($drivetoHomepageResult['result'] === null) {
                            $output->writeln($drivetoHomepageResult['error']);

                            throw new \InvalidArgumentException(
                                'Neither of the two addresses given contain any text'
                            );
                        } else {
                            $drivetoHomepageResultContents = $drivetoHomepageResult['result'];
                        }
                    }
                } else {
                    $drivetoHomepageResultContents = $drivetoHomepageResult['result'];
                }
            }

            return $drivetoHomepageResultContents;
        }

        throw new \InvalidArgumentException(
            'No addresses given'
        );
    }
}
