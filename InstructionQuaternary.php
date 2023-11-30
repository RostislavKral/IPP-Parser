<?php
/**
 * @Author: Rostislav Kral(xkralr06)
 */
declare(strict_types=1);

namespace IPPCode23\Instruction;


class InstructionQuaternary extends Instruction
{
    /**
     * @class InstructionQuaternary
     * @package IPPCode23\Instruction
     * */


    /** Makes the specific Instruction
     * @return \DOMNode
     */
    function make(): \DOMNode
    {
        if(count($this->operandes) !== 3) exit(23);


        if($this->opcode === 'JUMPIFEQ' || $this->opcode === 'JUMPIFNEQ') $arg1Properties = $this->checkOperand($this->operandes[0], 'label');
        else $arg1Properties = $this->checkOperand($this->operandes[0], 'var');
        $arg2Properties = $this->checkOperand($this->operandes[1], 'symbol');
        $arg3Properties = $this->checkOperand($this->operandes[2], 'symbol');


        $this->argsNodes[0]->setAttribute('type', $arg1Properties['type']);
        $this->argsNodes[0]->nodeValue = str_replace("\n", "", $arg1Properties['val']);

        $this->argsNodes[1]->setAttribute('type', $arg2Properties['type']);
        $this->argsNodes[1]->nodeValue = str_replace("\n", "", $arg2Properties['val']);

        $this->argsNodes[2]->setAttribute('type', $arg3Properties['type']);
        $this->argsNodes[2]->nodeValue = str_replace("\n", "", $arg3Properties['val']);

        $this->element->setAttribute('order', (string)$this->order);
        $this->element->setAttribute('opcode', $this->opcode);

        $this->element->appendChild($this->argsNodes[0]);
        $this->element->appendChild($this->argsNodes[1]);
        $this->element->appendChild($this->argsNodes[2]);


        return $this->element;
    }
}
