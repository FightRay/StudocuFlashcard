<?php

namespace App\Traits;

trait ModelCreateOrUpdate
{
    /**
     * Create or update a record based on the provided data.
     *
     * @param array $data
     * @return static
     */
    public static function createOrUpdate(array $data)
    {
        // Assuming there's a unique identifier like 'id' in the data array
        if (isset($data['id'])) {
            // Update existing record
            $instance = static::findOrFail($data['id']);
            $instance->update($data);
        } else {
            // Create new record
            $instance = static::create($data);
        }

        return $instance;
    }
}