<?php
/**
 * @Author: Rostislav kral (xkralr06)
 *
 * */
declare(strict_types=1);

namespace IPPCode23;

use DOMDocument;
use DOMElement;
use DOMException;
use IPPCode23\Instruction\Instruction;
use IPPCode23\Instruction\InstructionFactory;

/**
 * This class is wrapping up the whole program.
 * @class Analyzer
 * @package IPPCode23
 */
class Analyzer
{

    /**
     * @var DOMDocument
     */
    private DOMDocument $xml;
    /**
     * @var DOMElement|false
     */
    private DOMElement|bool $root;
    /**
     * @var int
     */
    private int $order = 1;

    /**
     * @var Operands
     */
    private Operands $operands;

    /**
     * @throws DOMException
     */
    public function __construct()
    {
        //Init of the XML document
        $this->xml = new DOMDocument('1.0', 'UTF-8');
        $this->root = $this->xml->createElement('program');
        $this->root->setAttribute('language', 'IPPcode23');
        $this->xml->appendChild($this->root);
        $this->operands = new Operands();
    }


    /**
     * @param string $instruction
     * @param array $arguments of the instruction
     * @return void
     * @throws DOMException
     */
    public function makeInstruction(string $instruction, array $arguments): void
    {
        // Parse comments
        $arguments = $this->_deleteCommentsFromArgs($arguments);
        $this->_escapeSequencesCheck($arguments);

        $argsNodes = [
            $this->xml->createElement('arg1'),
            $this->xml->createElement('arg2'),
            $this->xml->createElement('arg3')
        ];

        $element = $this->root->appendChild($this->xml->createElement('instruction'));
        //Factory design pattern for creating different instructions
        $instructionFactory = new InstructionFactory($instruction, $this->order, $arguments, $element, $argsNodes);
        $instructionProduct = $instructionFactory->produce();

        $this->order++;
        $this->root->appendChild($instructionProduct);
    }

    /**
     * @param array $args
     * @return array
     */
    private function _deleteCommentsFromArgs(array $args): array
    {
        $arguments = [];
        foreach ($args as $arg) {

            if (!$this->operands->isComment($arg)) {
                if (str_contains($arg, '#')) {
                    $arguments[] = substr($arg, 0, strpos($arg, "#"));
                    break;
                }
                else $arguments[] = $arg;
            }
            else break;
        }

        return $arguments;
    }

    private function _escapeSequencesCheck(array $args)
    {
        foreach ($args as $arg) {
            if(str_contains($arg, "\\")) {
                $str = explode('\\', $arg);
                for ($i = 1; $i < count($str); $i++) {
                    if (!preg_match('/[0-9][0-9][0-9][a-zA-Z0-9]*/', $str[$i])) exit(23);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function print(): void
    {
        $tmp = $this->xml->saveXML();
        $this->xml->formatOutput = true;
        $this->xml->loadXML($tmp);
        echo $this->xml->saveXML();
    }

    /**
     * @return Operands
     */
    public function getOperands(): Operands
    {
        return $this->operands;
    }


}
