<?php

declare(strict_types=1);

namespace App\Requests;

use App\Enums\Project;
use App\Exceptions\ValidationException;

class PayoutRequest extends BaseRequest
{
    /**
     * Base simple validation
     */
    public function validate()
    {
        $errors = [];

        if (!isset($this->content['payment_id'])) {
            $errors['payment_id'] = ['required'];
        }

        if (!isset($this->content['amount'])) {
            $errors['amount'] = ['required'];
        }

        if (!isset($this->content['currency'])) {
            $errors['currency'] = ['required'];
        }

        if (!isset($this->content['pan'])) {
            $errors['pan'] = ['required'];
        }

        if (!isset($this->content['project_id'])) {
            $errors['project_id'] = ['required'];
        }

        $project = Project::tryFrom($this->content['project_id']);

        if ($project === null) {
            $errors['project_id'] = ['wrong project'];
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $this->content;
    }
}
