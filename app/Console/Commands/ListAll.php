<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;

class ListAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all available flashcards';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $keys = ['id', 'question', 'answer'];
        $cards = Card::all($keys)->toArray();

        $this->table($keys, $cards);

        return Command::SUCCESS;
    }
}
