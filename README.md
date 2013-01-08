<h1>Checkpoints</h1>
Useful if you have a peicemeal script that takes a while to run. Lets say you're debugging step 3 of a total of 10, you only need each step to run once, and step 3 keeps on failing. No need to run step 1 or 2 again. Depending on how your script is setup, you might have to comment out code, run pieces of code snippets seperatly ect.

Or lets say your scripts have run succesfully but you need to run step x again but not the rest?

Simply delete the associated checkpoint, and rerun your checkpoints. If the checkpoint exists, it'll continue on until all checkpoints are run.

[![Build Status](https://travis-ci.org/kcmerrill/checkpoints.png?branch=master)](https://travis-ci.org/kcmerrill/checkpoints)