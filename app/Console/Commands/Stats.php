<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Card;
use App\Models\Answer;

class Stats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display statistics';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $this->info('Flashcard User Statistics');
        $cards = Card::all(['id', 'question', 'answer'])->keyBy('id')->toArray();
        $numUsers = User::count();

        if (sizeof($cards) === 0 || $numUsers === 0) {
            $this->info('There are no statistics available at the moment.');
            return Command::SUCCESS;
        }

        $maxAnswers = count($cards) * $numUsers;
        $numCorrect = Answer::where('correct', true)->count();

        // Calculate answer/correct answer percentages, based on the amount of users and answers
        $answered = abs((Answer::count() / $maxAnswers) * 100);
        $correct = abs(($numCorrect / $maxAnswers) * 100);

        $this->table(['Total Questions', 'Answered %', 'Correct %'], [[count($cards), "{$answered}%", "{$correct}%"]]);

        return Command::SUCCESS;
    }
}
