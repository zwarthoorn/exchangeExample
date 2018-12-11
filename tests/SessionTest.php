<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Panther\PantherTestCase;

class SessionTest extends PantherTestCase
{
    private const SESSION_TITLE = 'make vue your home';

    use ReloadDatabaseTrait;

    public function testGiveFeedback(){


    }
}
