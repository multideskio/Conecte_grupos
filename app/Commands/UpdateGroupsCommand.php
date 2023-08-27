<?php // app/Commands/UpdateGroupsCommand.php

// app/Commands/UpdateGroupsCommand.php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\GroupService;

class UpdateGroupsCommand extends BaseCommand
{
    protected $groupService;

    public function __construct()
    {
        //$this->groupService = new GroupService('64e1b07d5b16d_instance_1', 1); // Replace with your instance name
    }

    protected $group = 'custom';
    protected $name = 'update-groups';
    protected $description = 'Update groups and participants';

    public function run(array $params)
    {
        CLI::write('Updating groups and participants...');
        //$this->groupService->listGroups(true);
        CLI::write('Update completed.');
    }
    
    // You can also use the protected getArguments() method if needed.
}
