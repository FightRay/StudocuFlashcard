<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidateInput
{
    /**
     * Ask function that validates input by the rules presented
     * 
     * @return mixed
     */
    protected function askValid($question, array $rules) : mixed
    {
        $value = $this->ask($question);
        $validator = Validator::make(['input' => $value], ['input' => $rules]);

        while ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            $value = $this->ask($question);
            $validator = Validator::make(['input' => $value], ['input' => $rules]);
        }

        return $value;
    }
}