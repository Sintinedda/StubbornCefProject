<?php

namespace App\Command;

use APP\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:users-list',
    description: 'List all the existing users',
)]
class UserListCommand extends Command
{
    public function __construct(
        private readonly UserRepository $users
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            -> setHelp('This command allow you to get the full users list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $allUsers = $this -> users -> findAll('SELECT * FROM user');

        $createUserArray = static function (User $user): array {
            return [
                $user -> getId(),
                $user -> getName(),
                $user -> getEmail(),
                $user -> getDeliveryAddress()
            ];
        };

        $usersAsPlainArrays = array_map($createUserArray, $allUsers);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io -> table(
            ['ID', 'Name', 'Email', 'Delivery Address'],
            $usersAsPlainArrays
        );

        $usersAsTable = $bufferedOutput -> fetch();
        $output -> write($usersAsTable);

        return Command::SUCCESS;
    }
}
