<?php

namespace App\Traits;

use App\Models\User;

trait CommonConsoleTrait
{
    use ValidateInput;

    // Define colors for a nicer console
    static string $COLOR_RED = "\033[31m";
    static string $COLOR_BLUE = "\033[34m";

    protected function enterToContinue() : void {
        $this->ask('Press enter to continue...');
    }

    /**
     * Overrides the original ask function in order to close
     * the app with the input 'exit'
     * 
     * @param string $question
     * @return mixed
     */
    public function ask($question, $default = null) : mixed
    {
        $result = parent::ask($question, $default);

        if ($result == 'exit') {
            $this->exitApp();
        }
        
        return $result;
    }

    /**
     * Return a new/existing user based on username
     * 
     * @return User
     */
    protected function askUser() : User  {
        $username = $this->askValid('What is your Username?', ['required', 'string', 'min:3', 'max:255']);
        $user = User::where('name', $username)->first();
        if ($user === null) {
            $user = User::create(['name' => $username]);
        }

        return $user;
    }

    /**
     * Clears the console UI
     */
    protected function clear() : void {
        echo "\e[H\e[J";
    }

    /**
     * Exit the application
     */
    protected function exitApp() : void {
        $this->info('Bye.');
        exit(0);
    }
}