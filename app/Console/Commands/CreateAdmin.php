<?php

namespace App\Console\Commands;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Console\Command;
use Validator;

class CreateAdmin extends Command
{
    protected $signature = 'administrator:create {email} {password}';

    protected $description = 'Creates a new Administrator';

    private $repository = NULL;

    private function getValidator()
    {
        return $validator = Validator::make($this->arguments(), [
            'email' => 'email|unique:users',
        ]);
    }

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function handle()
    {
        $validator = $this->getValidator();

        if ($validator->fails())
        {
            return print(implode("\n", $validator->errors()->all()) . "\n");
        }

        $this->repository->store($this->arguments());
        print("user " . $this->argument('email') . " created.\n");
    }
}
