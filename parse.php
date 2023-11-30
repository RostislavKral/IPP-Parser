<?php
declare(strict_types=1);
ini_set('display_errors', 'stderr');
require 'autoload.php';
if($argc > 1)
{
    if($argv[1] === "--help") echo "Usage\n\n\n";
    else exit(10);

    exit(0);
}


$lineNumber = 0;
$header = false;
$instructionNumber = 1;

$analyzer = new \IPPCode23\Analyzer();

while ($line = fgets(STDIN)){
    //echo $line;

    $instruction = explode(' ', $line);
    //  print_r($instruction);
    if (ctype_space($instruction[0])) continue;



    if($analyzer->getOperands()->isComment($instruction[0])) continue;
    $instruction[0] = trim($instruction[0]);

    if($lineNumber===0) {
        if (str_contains($line, '#')) {
            $line = substr($line, 0, strpos($line, "#"));
        }
        $line = trim($line);

        if($line != '.IPPcode23') exit(21);

        $header = true;
        $lineNumber++;
        continue;
    }


    if($header) {
        foreach ($instruction as $operand => $val) {
            if ($val === '') unset($instruction[$operand]);
        }
    }

    //print_r($instruction);
    $analyzer->makeInstruction(strtoupper($instruction[0]), array_slice($instruction, 1));

    $lineNumber++;

}

$analyzer->print();

exit(0);
