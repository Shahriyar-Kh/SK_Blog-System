<?php

namespace App;

enum UsersStatus: string
{
    // add users status here
    case Pending='pending';
    case Active='active';
    case Inactive='inactive';
    case Rejected='rejected';

}
