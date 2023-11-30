<?php
/**
 * @Author: Rostislav Kral (xkralr06)
 *
 * */
declare(strict_types=1);

namespace IPPCode23\Instruction;

use IPPCode23\Operands;


abstract class Instruction
{
    /**
     *
     */

    /**
     * @var Operands
     */
    protected Operands $operands;

    /**
     * @return mixed
     */
    abstract function make();

    /**
     * @param string $opcode
     * @param int $order
     * @param array $operandes
     * @param \DOMNode $element
     * @param array $argsNodes
     */
    function __construct(protected string $opcode, protected int $order, protected array $operandes, protected \DOMNode $element, protected array $argsNodes){$this->operands = new Operands();}

    /**
     * @return Operands
     */
    protected function getInstanceOperands()
    {
        return $this->operands;
    }

    /**
     * @param string $operand
     * @param string $type
     * @return string[]
     */
    protected function checkOperand(string $operand, string $type): array
    {
        if($type === 'var') {
            $this->operands->isVar($operand) ? '' : exit(23);
            return ['type' => 'var', 'val' => $operand];

        }
        else if($type === 'label'){
            $this->operands->isLabel($operand) ? '': exit(23);

            return ['type' => 'label', 'val' => $operand];
        }
        else if($type === 'symbol') {
            $this->operands->isSymbol($operand) ? '' : exit(23);

            if($this->operands->isConstant($operand)) return $this->operands->getTypeAndValueOfConstant($operand);

            return ['type' => 'var', 'val' => $operand];
        }
        else if($type === 'type')
        {

            $this->operands->isType($operand) ? '': exit(23);
            return ['type' => 'type', 'val' => $operand];
        }

        return [];
    }
}
