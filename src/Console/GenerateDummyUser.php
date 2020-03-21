<?php declare(strict_types=1);

namespace App\Console;

use MessageInfo\UserAPIDataProvider;
use MessageInfo\UserListAPIDataProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class GenerateDummyUser extends Command
{
    protected static $defaultName = 'generator:dummy:user';

    /**
     * @var \Symfony\Component\Messenger\MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @param \Symfony\Component\Messenger\MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Test message');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = [
            [
                'id' => 1,
                'test1@doctor.com',
                'role' => 'doctor',
                'stateIso' => 'NW',
            ],
            [
                'id' => 2,
                'test2@doctor.com',
                'role' => 'doctor',
                'stateIso' => 'BY',
            ],
            [
                'id' => 3,
                'test1@testcenter.com',
                'role' => 'testCenter',
                'stateIso' => 'NW',
            ],
            [
                'id' => 4,
                'test2@testcenter.com',
                'role' => 'testCenter',
                'stateIso' => 'BY',
            ],
            [
                'id' => 5,
                'test1@labor.com',
                'role' => 'labor',
                'stateIso' => 'NW',
            ],
            [
                'id' => 6,
                'test1@labor.com',
                'role' => 'labor',
                'stateIso' => 'BY',
            ],
        ];
        $userListAPIDataProvider = new UserListAPIDataProvider();
        foreach ($users as $user) {
            $userAPIDataProvider = new UserAPIDataProvider();
            $userAPIDataProvider->fromArray($user);
            $userListAPIDataProvider->addUser($userAPIDataProvider);
        }

        file_put_contents(__DIR__ .'/../../demo-data.json', json_encode($userListAPIDataProvider->toArray()));

        $this->messageBus->dispatch($userListAPIDataProvider);

        return 0;
    }
}
