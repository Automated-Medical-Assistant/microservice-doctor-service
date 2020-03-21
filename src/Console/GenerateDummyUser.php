<?php declare(strict_types=1);

namespace App\Console;

use MessageInfo\RoleDataProvider;
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
        $role = new RoleDataProvider();
        $users = [
            [
                'userId' => 1,
                'email' => 'test1@doctor.com',
                'role' => $role->getDoctor(),
                'stateIso' => 'NW',
            ],
            [
                'userId' => 2,
                'email' => 'test2@doctor.com',
                'role' => $role->getDoctor(),
                'stateIso' => 'BY',
            ],
            [
                'userId' => 3,
                'email' => 'test1@testcenter.com',
                'role' => $role->getTestCenter(),
                'stateIso' => 'NW',
            ],
            [
                'userId' => 4,
                'email ' => 'test2@testcenter.com',
                'role' => $role->getTestCenter(),
                'stateIso' => 'BY',
            ],
            [
                'userId' => 5,
                'email' => 'test1@labor.com',
                'role' => $role->getLabor(),
                'stateIso' => 'NW',
            ],
            [
                'userId' => 6,
                'email' => 'test1@labor.com',
                'role' => $role->getLabor(),
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
