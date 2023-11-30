<?php
/**
 * @Author: Rostislav Kral(xkralr06)
 * */
declare(strict_types=1);

namespace IPPCode23\Instruction;

/**
 *
 */
class InstructionFactory
{
    /**
     * As name of the class says, it is factory for Instruction producers
     *
     * @class   InstructionFactory
     * @package IPPCode23
     * */



    /**
     * Unary instructions
     */
    private const UNARIES = ['CREATEFRAME', 'PUSHFRAME', 'POPFRAME', 'RETURN', 'BREAK'];
    /**
     * Binary instructions
     */
    private const BINARIES = ['DEFVAR', 'CALL', 'PUSHS', 'POPS', 'WRITE', 'LABEL', 'JUMP', 'EXIT', 'DPRINT'];
    /**
     * Ternary instructions
     */
    private const TERNARIES = ['MOVE', 'NOT', 'INT2CHAR', 'READ', 'STRLEN', 'TYPE'];

    /**
     * Quarternary instructions
     */
    private const QUARTERNARIES = ['ADD', 'SUB', 'MUL', 'IDIV', 'LT', 'GT', 'EQ', 'AND', 'OR', 'STRI2INT', 'CONCAT', 'GETCHAR', 'SETCHAR', 'JUMPIFEQ', 'JUMPIFNEQ'];

    /**
     * The constructor is made by property promotion feature
     * @param string $opcode
     * @param int $order
     * @param array $operands
     * @param \DOMNode $element
     * @param array $argNodes
     */
    public function __construct(protected string $opcode, protected int $order, protected array $operands, protected \DOMNode $element, protected array $argNodes){}

    /**
     * Method will choose right producer for the Instruction or end up with exit code 22
     * @return \DOMNode
     */
    public function produce():\DOMNode
    {
        if (in_array($this->opcode, self::UNARIES)) $instruction = new InstructionUnary($this->opcode, $this->order, $this->operands, $this->element, []);
        elseif (in_array($this->opcode, self::BINARIES)) $instruction = new InstructionBinary($this->opcode, $this->order, $this->operands, $this->element,  $this->argNodes);
        elseif (in_array($this->opcode, self::TERNARIES)) $instruction = new InstructionTernary($this->opcode, $this->order, $this->operands, $this->element, $this->argNodes);
        elseif (in_array($this->opcode, self::QUARTERNARIES)) $instruction = new InstructionQuaternary($this->opcode, $this->order, $this->operands, $this->element, $this->argNodes);
        else exit(22);

        return $instruction->make();
    }


}
