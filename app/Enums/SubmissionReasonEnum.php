<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum SubmissionReasonEnum: string
{
    use LazyEnum;

    case idea = 'idea';
    case issue = 'issue';
    case book_problem = 'book_problem';
    case book_adding = 'book_adding';
    case other = 'other';
}
