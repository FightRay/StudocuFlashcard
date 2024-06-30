# StudocuFlashcard by Ray
Welcome to the StudocuFlashcard respository.
Made as a home assignment for Studocu, built using Laravel.
Create, list and practice flashcards in an interactive CLI application!
The application allows practice progress for multiple users.

## Project setup
Run the following commands before launching the project.
Make sure to edit the database properties in the `.env` files to match your own,
and your local php installation to have mysql and sqlite modules enabled.
```
composer install
cp .env.example .env
cp .env.testing.example .env.testing
php artisan key:generate
php artisan migrate
php artisan test // Test if it works
```

If you want to user docker with sail, install it into the project,
and use `sail artisan` instead of `php artisan`.
Make sure to configure database information in the `docker-compose.yml` as well.
Navigate to the project folder and run:
```
composer require laravel/sail --dev
php artisan sail:install
sail up
```

### Main command for the interactive menu
```
php artisan flashcard:interactive
```

### Sub commands for individual actions
```
php artisan flashcard:create // Create a new flashcard
php artisan flashcard:list // List all flashcards
php artisan flashcard:practice // Practice flashcards (also creates a user)
php artisan flashcard:stats // Displays statistics
php artisan flashcard:reset // Resets user answer data
```

### Adding new menu items
In order to add a new menu item, just add an item to the array
in the `create_menu_items_table` migration file at
```
database/migrations/2024_06_26_001830_create_menu_items_table.php
```
The action name will be the command's signature text followed after `flashcard:`
Then, create a new command to add functionality:
```
php artisan make:command YourCommand
```
Edit your command's signature to match (must be preceded by `flashcard:`)
```
protected $signature = 'flashcard:YourCommand';
```


### Run all tests
```
php artisan test
```
