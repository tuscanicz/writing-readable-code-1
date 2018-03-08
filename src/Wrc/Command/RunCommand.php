<?php

declare(strict_types=1);

namespace Wrc\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wrc\File\FileWriter;
use Wrc\File\UnableToWriteFileException;
use Wrc\TestServiceInterface;

class RunCommand extends Command
{
    private $tmpDir;
    private $testService;
    private $fileWriter;

    public function __construct(string $tmpDir, TestServiceInterface $testService, FileWriter $fileWriter)
    {
        $this->tmpDir = $tmpDir;
        $this->testService = $testService;
        $this->fileWriter = $fileWriter;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('run');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $addressList = new AddressList(
            [
                new Address('https://www.xdriveto.cz:443'),
                new Address('https://www.driveto.cz:443')
            ]
        );
        $contents = $this->testService->process($addressList, $output);
        try {

            $this->fileWriter->writeFile(
                $this->tmpDir . DIRECTORY_SEPARATOR . 'contents.html',
                $contents
            );
            $output->writeln('finished');

        } catch (UnableToWriteFileException $e) {
            $output->writeln('Could request contents: ' . $e->getMessage());
        }
    }
}
