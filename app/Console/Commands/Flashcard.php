<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CommonConsoleTrait;
use App\Traits\ValidateInput;
use App\Models\MenuItem;

class Flashcard extends Command
{
    use CommonConsoleTrait;
    use ValidateInput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flashcard Main Interactive Menu';

    /**
     * Menu items for the interactive CLI menu.
     *
     * @var array
     */
    protected array $menuItems;

    /**
     * Display the main menu
     */
    protected function displayMenu() : void
    {
        if (!isset($this->menuItems)) {
            $this->menuItems = MenuItem::all()->keyBy('id')->toArray();
        }

        $this->info('Studocu Flashcard App');          
        $this->info($this::$COLOR_BLUE . 'by Ray Bouhin\r\n');

        $this->info('Main Menu');
        foreach ($this->menuItems as $key => $item) {
            $this->info("{$key}. {$item['name']}");
        }
        $this->info('0. Exit');
        $this->info($this::$COLOR_RED . 'In order to exit the application at any point, type \'exit\'.');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $this->clear();

        while (true) {
            $this->displayMenu();
            $maxChoice = array_key_last($this->menuItems) ?? 0;
            $choice = $this->askValid('Please type the option number to continue', ['required', 'integer', 'min:0', "max:{$maxChoice}"]);

            if ($choice == 0) {
                $this->info('Bye.');
                return Command::SUCCESS;
            }


            // Get and call the corresponding menu item action
            $this->call("flashcard:{$this->menuItems[$choice]['action']}");

            $this->enterToContinue();
            $this->clear();
        }

        return Command::SUCCESS;
    }
}
