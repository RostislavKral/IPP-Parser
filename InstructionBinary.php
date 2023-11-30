<?php
/**
 * @Author: Rostislav Kral(xkralr06)
 */
declare(strict_types=1);

namespace IPPCode23\Instruction;


class InstructionBinary extends Instruction
{
    /**
     * @class InstructionBinary
     * @package IPPCode23\Instruction
     */


    /**
     * @const only instructions that have var as a operand
     */
    private const varOnly = ['DEFVAR', 'POPS'];
    /**
     * @const only instructions that have label as a operand
     */
    private const labelOnly = ['CALL', 'LABEL', 'JUMP'];

    /**
     * @const only instructions that have symbol as a operand
     */
    private const symbolOnly = ['PUSHS', 'WRITE', 'EXIT', 'DPRINT'];


    /**
     * @return \DOMNode
     */
    function make(): \DOMNode
    {
        if(count($this->operandes) !== 1) exit(23);

        if(in_array($this->opcode, self::varOnly)) $argProperties = $this->checkOperand($this->operandes[0], 'var');
        else if(in_array($this->opcode, self::labelOnly)) $argProperties = $this->checkOperand($this->operandes[0], 'label');
        else if(in_array($this->opcode, self::symbolOnly)) $argProperties = $this->checkOperand($this->operandes[0], 'symbol');
        else exit(23);

        $this->argsNodes[0]->setAttribute('type', $argProperties['type']);
        $this->argsNodes[0]->nodeValue = str_replace("\n", "", $argProperties['val']);

        $this->element->setAttribute('order', (string)$this->order);
        $this->element->setAttribute('opcode', $this->opcode);

        $this->element->appendChild($this->argsNodes[0]);

        return $this->element;
    }



}
