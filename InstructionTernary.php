<?php
/**
 * @Author Rostislav Kral(xkralr06)
 */
declare(strict_types=1);

namespace IPPCode23\Instruction;


class InstructionTernary extends Instruction
{
    /**
     * @class InstructionTernary
     * @package IPPCode23\Instruction
     */


    /**
     * @return \DOMNode|void
     */
    function make()
    {
        if(count($this->operandes) !== 2) exit(23);
        //TODO: OSetrit READ
        $arg1Properties = $this->checkOperand($this->operandes[0], 'var');

        $this->argsNodes[0]->setAttribute('type', $arg1Properties['type']);
        $this->argsNodes[0]->nodeValue = str_replace("\n", "", $arg1Properties['val']);

        if($this->opcode !== 'READ') {
            $arg2Properties = $this->checkOperand($this->operandes[1], 'symbol');
        } else {
            $arg2Properties = $this->checkOperand($this->operandes[1], 'type');

        }

        $this->argsNodes[1]->setAttribute('type', $arg2Properties['type']);

        $this->argsNodes[1]->nodeValue = str_replace("\n", "", $arg2Properties['val']);

        $this->element->setAttribute('order', (string)$this->order);
        $this->element->setAttribute('opcode', $this->opcode);

        $this->element->appendChild($this->argsNodes[0]);
        $this->element->appendChild($this->argsNodes[1]);

        return $this->element;
    }
}
