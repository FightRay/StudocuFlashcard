<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CommonConsoleTrait;
use App\Models\Card;
use App\Models\Answer;

class Practice extends Command
{
    use CommonConsoleTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Practice flashcards';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $cards = Card::all(['id', 'question', 'answer'])->keyBy('id')->toArray();

        if (sizeof($cards) === 0) {
            $this->info('There are currently no cards available to practice.');
            return Command::SUCCESS;
        }

        $user = $this->askUser();

        $this->info('Welcome to the flashcard Practice space.');

        while (true) {
            $answers = $user->answers->keyBy('card_id')->toArray();
            $tableData = [];

            // Create the table structure in an array
            $completed = 0;
            foreach ($cards as $card) {
                $data = [
                    'id' => $card['id'],
                    'question' => $card['question'],
                    'status' => isset($answers[$card['id']]) ? ($answers[$card['id']]['correct'] ? 'Correct' : 'Incorrect') : 'N/A'
                ];

                if ($data['status']  === 'Correct') {
                    $completed++;
                }

                array_push($tableData, $data);
            }

            // Calculate percent completed
            $completed = abs(($completed / count($cards))  * 100);

            $this->info($this::$COLOR_RED . 'Type \'0\' to return to the main menu.');
            $this->table(['id', 'question', 'status'], $tableData);
            $this->info("{$completed}% Completed.");

            $maxId = array_key_last($cards);
            $minId = 0; //array_key_first($cards);
            $practiceId = -1;

            // Ask for the card ID to practice while making sure it exists, in case there are gaps
            while (!isset($cards[$practiceId])) {
                if ($practiceId > -1) {
                    if ($practiceId == 0) {
                        break 2;
                    }
                    $this->info($this::$COLOR_RED . 'Invalid option. Please try again.');
                }
                $practiceId = $this->askValid('Please type the card ID you would like to practice', ['required', 'integer', "min:{$minId}", "max:{$maxId}"]);
            }

            $practiceCard = $cards[$practiceId];
            $userAnswer = $this->askValid($practiceCard['question'], ['required', 'string', 'min:1', 'max:255']);
            $correct = strtolower($userAnswer) === strtolower($practiceCard['answer']);

            $answerData =  [
                'user_id' => $user->id,
                'card_id' => $practiceId,
                'answer' => $userAnswer,
                'correct' => $correct
            ];

            if (isset($answers[$practiceId])) {
                $answerData['id'] = $answers[$practiceId]['id'];
            }

            Answer::createOrUpdate($answerData);

            $this->info($correct ? 'Correct!' : 'Incorrect.');

            // Reload the user model so the updated answers show up in the next iteration
            $user->refresh();

            $this->enterToContinue();
        }

        return Command::SUCCESS;
    }
}
