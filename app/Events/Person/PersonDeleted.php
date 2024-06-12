<?php

namespace App\Events\Backend\Person;

use Illuminate\Queue\SerializesModels;

/**
 * Class PersonDeleted.
 */
class PersonDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $person;

    /**
     * @param $person
     */
    public function __construct($person)
    {
        $this->person = $person;
    }
}
