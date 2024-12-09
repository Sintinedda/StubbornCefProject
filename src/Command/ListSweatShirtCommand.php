<?php

namespace App\Command;

use App\Entity\SweatShirt;
use App\Repository\SweatShirtRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-sweatshirts',
    description: 'List all the existing sweat-shirts',
)]
class ListSweatShirtCommand extends Command
{
    public function __construct(
        private readonly SweatShirtRepository $sweatShirts
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allow you to get the sweat-shirts list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $allSweatShirts = $this -> sweatShirts -> findAll('SELECT * FROM sweat_shirt');
        
        $createSweatShirtArray = static function (SweatShirt $sweatShirt): array {
            return [
                $sweatShirt -> getId(),
                $sweatShirt -> getName(),
                $sweatShirt -> getPrice(),
                $sweatShirt -> getSweatSizes(),
                $sweatShirt -> isTop()
            ];
        };

        $sweatShirtsAsPlainArrays = array_map($createSweatShirtArray, $allSweatShirts);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io -> table(
            ['ID', 'Name', 'Price', 'Sizes', 'Top'],
            $sweatShirtsAsPlainArrays
        );

        $sweatShirtsAsTable = $bufferedOutput -> fetch();
        $output -> write($sweatShirtsAsTable);

        return Command::SUCCESS;
    }
}
