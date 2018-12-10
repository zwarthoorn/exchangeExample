<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Panther\PantherTestCase;

class SessionTest extends PantherTestCase
{
    private const SESSION_TITLE = 'make vue your home';

    use ReloadDatabaseTrait;

    public function testGiveFeedback(){

        $client = static::createPantherClient();

        $crawler = $client->request('GET','/');

        $this->assertSame('SymfonyCon Schedule', $crawler->filter('h1:first-of-type')->text());

        $crawler = $client->clickLink(self::SESSION_TITLE);
        $this->assertSame(self::SESSION_TITLE, $crawler->filter('h1:first-of-type')->text());

        $client->waitFor('#feedback div p');
        $this->assertSame('no Feedback Yet', $crawler->filter('#feedback div p')->text());

        $client->getMouse()->clickTo('.vue-star-rating-pointer:nth-of-type(5)');
        $crawler = $client->submitForm('Post',[
            'author' => 'walter',
            'comment' => 'a awsome vue',
        ]);

        $client->waitFor('#feedback li');

        $this->assertContains('a awsome vue' , $crawler->filter('#feedback li')->text());

        $this->assertNotSame('no Feedback Yet', $crawler->filter('#feedback div p')->text());

        $client->takeScreenshot('/tmp/panther.png');
    }
}
