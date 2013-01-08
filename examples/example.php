<?php
require_once __DIR__ . '/../src/kcmerrill/utility/checkpoints.php';

/*
 * Checkpoint name is simple_example. Because we didn't give a second param(the base dir)
 * The checkpoints will be stored in the current working directory.
 * 
 */
$checkpoints = new kcmerrill\utility\checkpoints('simple_example');

//Create a checkpoint called 'step_one';
//All of STDOUT will be stored in <CWD>/simple_example/step_one.ckpt
//In this case, Welcome to Step 1!
$checkpoints->step_one(function() {
            echo 'Welcome to Step 1!';
        });

        
//ect ..
$checkpoints->step_two(function() {
            echo 'Welcome to Step 2!';
        });

$checkpoints->step_three(function() {
            echo 'Welcome to Step 3!';
        });

$checkpoints->step_four(function() {
            echo 'Welcome to Step 4!';
        });
        
        
/* Now, run this again, and you'll notice nothing will execute because the checkpoints exist.
 * Then, go and delete one of the checkpoints, and run it again ...
*/