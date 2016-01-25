<?php

namespace tests\Console\Commands\Note;

use AbuseIO\Models\Note;
use Illuminate\Support\Facades\Artisan;
use TestCase;

/**
 * Class EditCommandTest.
 */
class EditCommandTest extends TestCase
{
    /**
    * @expectedException RuntimeException
    * @expectedExceptionMessage Not enough arguments (missing: "id").
    */
    public function testWithoutId()
    {
         Artisan::call('note:edit');
    }

    public function testWithInvalidId()
    {
        $exitCode = Artisan::call(
            'note:edit',
            [
                'id' => '10000',
            ]
        );
        $this->assertEquals($exitCode, 0);
        $this->assertContains('Unable to find note with this criteria', Artisan::output());
    }

    public function testWithHidden()
    {
        $this->assertFalse((bool) Note::find(1)->hidden);

        $exitCode = Artisan::call(
            'note:edit',
            [
                'id' => '1',
                '--hidden' => 'true',
            ]
        );
        $this->assertEquals($exitCode, 0);
        $this->assertContains('The note has been updated', Artisan::output());

        $this->assertTrue((bool) Note::find(1)->hidden);

        $this->seed('NotesTableSeeder');
    }

    public function testEnabled()
    {
        $this->assertFalse((bool) Note::find(1)->viewed);

        $exitCode = Artisan::call(
            'note:edit',
            [
                'id' => '1',
                '--viewed' => 'true',
            ]
        );
        $this->assertEquals($exitCode, 0);
        $this->assertContains('The note has been updated', Artisan::output());
        /*
         * I use the seeder to re-initialize the table because Artisan:call is another instance of DB
         */
        $this->assertTrue((bool) Note::find(1)->viewed);

        $this->seed('NotesTableSeeder');
    }
}