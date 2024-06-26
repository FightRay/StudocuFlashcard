<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Card;

class PracticeCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_practice_card() : void
    {
        $cardMount = Card::create([
            'question' => 'What is the highest mountain on Earth?',
            'answer' => 'Mount Everest'
        ]);

        $cardContinent = Card::create([
            'question' => 'What is the largest continent on Earth?',
            'answer' => 'Asia'
        ]);

        $questionOptionNumber = 'Please type the option number to continue';
        $enterToContinue = 'Press enter to continue...';
        $typeCardId = 'Please type the card ID you would like to practice';

        $this->artisan('flashcard:interactive')
            ->expectsQuestion($questionOptionNumber, 3)
            ->expectsQuestion('What is your Username?', 'Ray')
            ->expectsOutput('Welcome to the flashcard Practice space.')
            ->expectsOutput('0% Completed.')
            ->expectsQuestion($typeCardId, $cardMount->id)
            ->expectsQuestion($cardMount->question, $cardMount->answer)
            ->expectsOutput('Correct!')
            ->expectsQuestion($enterToContinue, '')
            ->expectsQuestion($typeCardId, $cardContinent->id)
            ->expectsQuestion($cardContinent->question, 'Africa')
            ->expectsOutput('Incorrect.')
            ->expectsQuestion($enterToContinue, '')
            ->expectsQuestion($typeCardId, 0)
            ->expectsQuestion($enterToContinue, '')
            ->expectsQuestion($questionOptionNumber, 0)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Ray'
        ]);

        $this->assertDatabaseHas('cards', $cardMount->only(['id', 'question', 'answer']));
        $this->assertDatabaseHas('cards', $cardContinent->only(['id', 'question', 'answer']));
    }
}
