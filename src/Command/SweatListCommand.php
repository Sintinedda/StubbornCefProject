<?php

namespace App\Command;

use APP\Entity\SweatShirt;
use App\Repository\SweatShirtRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sweats-list',
    description: 'List all the existing sweat-shirts',
)]
class SweatListCommand extends Command
{
    public function __construct(
        private readonly SweatShirtRepository $sweats
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            -> setHelp('This command allow you to get the full sweat-shirts list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $allSweats = $this -> sweats -> findAll('SELECT * FROM sweat_shirt');

        $createSweatArray = static function (SweatShirt $sweat): array {
            return [
                $sweat -> getId(),
                $sweat -> getName(),
                $sweat -> getPrice(),
                $sweat -> isIsTop(),
                $sweat -> getStockXs(),
                $sweat -> getStockS(),
                $sweat -> getStockM(),
                $sweat -> getStockL(),
                $sweat -> getStockXl()
            ];
        };

        $sweatsAsPlainArrays = array_map($createSweatArray, $allSweats);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io -> table(
            ['ID', 'Name', 'Price', 'Top', 'Stock XS', 'Stock S', 'Stock M', 'Stock L', 'Stock XL'],
            $sweatsAsPlainArrays
        );

        $sweatsAsTable = $bufferedOutput -> fetch();
        $output -> write($sweatsAsTable);

        return Command::SUCCESS;
    }
}