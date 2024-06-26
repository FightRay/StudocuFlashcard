<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CommonConsoleTrait;

class Reset extends Command
{
    use CommonConsoleTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets user answer data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $user = $this->askUser();

        $deleted = $user->answers()->delete();
        $this->info($deleted > 0 ? 'All user data has been reset.' : $this::$COLOR_RED . 'Could not delete any records. (Is there anything to delete?)');

        return Command::SUCCESS;
    }
}
