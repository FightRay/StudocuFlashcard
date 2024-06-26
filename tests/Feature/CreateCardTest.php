<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_card() : void
    {
        $questionOptionNumber = 'Please type the option number to continue';
        $enterToContinue = 'Press enter to continue...';
        $question = 'What is the highest mountain on Earth?';
        $answer = 'Mount Everest';

        $this->artisan('flashcard:interactive')
            ->expectsQuestion($questionOptionNumber, 1)
            ->expectsOutput('Create a new flashcard')
            ->expectsQuestion('Please type the question', 'What is the highest mountain on Earth?')
            ->expectsQuestion('Please type the answer to the question', 'Mount Everest')
            ->expectsQuestion($enterToContinue, '')
            ->expectsOutput('Flashcard has been created.')
            ->expectsQuestion($questionOptionNumber, 0)
            ->assertExitCode(0);

        $this->assertDatabaseHas('cards', [
            'question' => $question,
            'answer' => $answer
        ]);
    }
}
