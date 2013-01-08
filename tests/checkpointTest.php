<?php
require_once __DIR__ . '/../src/kcmerrill/utility/checkpoints.php';

class checkpointTest extends PHPUnit_Framework_TestCase
{
    public $checkpoints = false;

    public function setUp()
    {
        $this->checkpoints = new kcmerrill\utility\checkpoints(uniqid('checkpoint-'));
    }

    public function testIsObject()
    {
        $this->assertTrue(is_object($this->checkpoints));
    }

    public function testSetGetName()
    {
        $this->checkpoints->setName('new_checkpoints_name');
        $this->assertEquals('new_checkpoints_name', $this->checkpoints->getName());
    }

    public function testSetGetBaseDir()
    {
        $this->checkpoints->setBaseDir('idonotexist');
        //Notice the backslash?
        $this->assertEquals('idonotexist/' , $this->checkpoints->getBaseDir());

        $this->checkpoints->setBaseDir('idoexistithink/');
        $this->assertEquals('idoexistithink/', $this->checkpoints->getBaseDir());
        $this->assertEquals('idoexistithink/', $this->checkpoints->getBaseDir());
    }

    public function testGeneralUse()
    {
        $checkpoint_name = 'kcmerrillwazhere';
        $checkpoints = new kcmerrill\utility\checkpoints($checkpoint_name);
        $this->assertEquals($checkpoint_name, $checkpoints->getName());

        $checkpoints->step_one(function(){
            echo 'Welcome to Step 1!';
        });

        $checkpoints->step_two(function(){
            echo 'Welcome to Step 2!';
        });

        $checkpoints->step_three(function(){
            echo 'Welcome to Step 3!';
        });

        $checkpoints->step_four(function(){
            echo 'Welcome to Step 4!';
        });

        $this->assertEquals('Welcome to Step 1!', file_get_contents($checkpoints->getFullFilePath('step_one')));
        $this->assertEquals('Welcome to Step 2!', file_get_contents($checkpoints->getFullFilePath('step_two')));
        $this->assertEquals('Welcome to Step 3!', file_get_contents($checkpoints->getFullFilePath('step_three')));
        $this->assertEquals('Welcome to Step 4!', file_get_contents($checkpoints->getFullFilePath('step_four')));

        $checkpoints->step_one(function(){
            echo 'This should not be executed, because step_one has already run!';
        });

        $this->assertEquals('Welcome to Step 1!', file_get_contents($checkpoints->getFullFilePath('step_one')));
    }
}
