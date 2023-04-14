<?php

namespace App\Exception;

use Exception;

class ExpenseWithoutParticipantsException extends Exception {
    public function __construct()
    {
        parent::__construct('An expense must have at least 1 participant');
    }
}
