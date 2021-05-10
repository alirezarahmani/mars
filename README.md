How To Install:
===
You just need to run ``composer install`` and make sure you have PHP 8.

How To Run:
===

This is anatomy of command: first to arguments are top coordination of plateau, down coordination are `0,0` and X, Y are positions of the mars rover:
> php console mars:rover {plateau X} {plateau Y} [ {X} {Y} {Heading} {Movements} ]

A sample command:

> php console mars:rover 5 5 1 2 N LMLMLMLMM 3 3 E MMRMMRMRRM

out put:

> 1 3 N
> 
> 5 1 E


Tests:
===
Tests are written with `PHPunit` and you can find them in the `tests` folder.

Technical Debt:
===
I use CQRs architecture for this assignment but, I do not use command Bus, I just created Command and handler. The main reason for this is because the task description said you should not spend more than 3 hours on this.  

