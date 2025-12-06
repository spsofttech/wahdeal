<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartNodeServer extends Command
{
    protected $signature = 'node:server';
    protected $description = 'Start Node.js chat server';
    
    public function handle()
    {
        $path = base_path('server.js'); // path to your Node.js server
        $process = new Process(['node', $path]);
        $process->start();

        $this->info('Node.js chat server started.');
        return Command::SUCCESS;
    }
}