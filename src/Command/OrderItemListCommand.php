<?php

namespace App\Command;

use App\Entity\OrderItem;
use App\Repository\OrderItemRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:orderitems-list',
    description: 'List all the existing ordered items',
)]
class OrderItemListCommand extends Command
{
    public function __construct(
        private readonly OrderItemRepository $orderItems
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allow you to get the full ordered items list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $allOrderItems = $this->orderItems->findAll('SELECT * FROM order_item');

        $createOrderItemArray = static function (OrderItem $orderItem): array {
            return [
                $orderItem->getId(),
                $orderItem->getSweat()->getName()
            ];
        };

        $orderItemsAsPlainArrays = array_map($createOrderItemArray, $allOrderItems);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io -> table(
            ['ID', 'Product'],
            $orderItemsAsPlainArrays
        );

        $adminsAsTable = $bufferedOutput -> fetch();
        $output -> write($adminsAsTable);

        return Command::SUCCESS;
    }
}
