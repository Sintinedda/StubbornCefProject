<?php

namespace App\Command;

use APP\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:admins-list',
    description: 'List all the existing admins',
)]
class AdminListCommand extends Command
{
    public function __construct(
        private readonly AdminUserRepository $admins
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            -> setHelp('This command allow you to get the full admins list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $allAdmins = $this -> admins -> findAll('SELECT * FROM admin_user');

        $createAdminArray = static function (AdminUser $admin): array {
            return [
                $admin -> getId(),
                $admin -> getName(),
                $admin -> getEmail()
            ];
        };

        $adminsAsPlainArrays = array_map($createAdminArray, $allAdmins);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io -> table(
            ['ID', 'Name', 'Email'],
            $adminsAsPlainArrays
        );

        $adminsAsTable = $bufferedOutput -> fetch();
        $output -> write($adminsAsTable);

        return Command::SUCCESS;
    }
}
