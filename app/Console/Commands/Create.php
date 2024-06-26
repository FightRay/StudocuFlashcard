<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;
use App\Traits\CommonConsoleTrait;

class Create extends Command
{
    use CommonConsoleTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new flashcard';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $this->info('Create a new flashcard');
        $card = [];
        $card['question'] = $this->askValid('Please type the question', ['required', 'string', 'min:3', 'max:255']);

        // Check if this kind of card already exists
        $exists = Card::where('question', $card['question'])->count();
        if ($exists > 0) {
            $this->info('This question already exists in another card, please type a different one.');
            return Command::SUCCESS;
        }

        $card['answer'] = $this->askValid('Please type the answer to the question', ['required', 'string', 'min:1', 'max:255']);
        
        Card::create($card);

        $this->info('Flashcard has been created.');

        return Command::SUCCESS;
    }
}
