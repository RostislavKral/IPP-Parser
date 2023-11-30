<?php
/**
 * @Author: Rostislav Kral(xkralr06)
 */
declare(strict_types=1);

namespace IPPCode23\Instruction;



class InstructionUnary extends Instruction
{
    /**
     * @class InstructionUnary
     * @package IPPCode23\Instruction
     */

    /**
     * @return \DOMNode
     */
    function make(): \DOMNode
    {
        if (count($this->operandes) !== 0) exit(23);
        $this->element->setAttribute('order', (string)$this->order);
        $this->element->setAttribute('opcode', $this->opcode);

        return $this->element;
    }
}
