<?php
/**
 * @Author: Rostislav Kral (xkralr06)
 *
 * */
declare(strict_types=1);
namespace IPPCode23;

/**
 *
 */
class Operands
{
    /**
     * This class is wrapping up the whole program.
     * @class Operands
     * @package IPPCode23
     */
    public function isConstant(string $str): bool
    {
       // print_r($str);
       return (bool) (preg_match('/(string@([\\\_$\/\-<>()%=`\'§,;!?*0-9\p{L}])*|int@(-[0-9]|[0-9]|[+][0-9])+|nil@nil|bool@(true|false))$/u', $str));
    }

    /**
     * @param string $str
     * @return array
     */
    public function getTypeAndValueOfConstant(string $str): array
    {
        $tmp = explode('@', $str, 2);

        return ['type' => $tmp[0], 'val' => $tmp[1]];
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isSymbol(string $str): bool
    {
        /*echo $str;
        echo (preg_match('/(string@([\\\_$-%!?*0-9\p{L}])*|int@(-[0-9]|[0-9]|[+][0-9])+|nil@nil|bool@(true|false))$/u', $str));*/
        return (bool) $this->isConstant($str) || $this->isVar($str);
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isVar(string $str): bool
    {
        return (bool) preg_match("/(GF|TF|LF)@[a-zA-Z_$\-%&!?*][a-zA-Z_$\-%!?*0-9]*/",$str);
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isLabel(string $str): bool
    {
        if($this->isSymbol($str)) return false;
        return (bool) preg_match("/^[\\\_$\-()%=`§,;!?*0-9\p{L}][_$-%!?*0-9\p{L}]*/u",$str);
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isType(string $str): bool
    {
        return (bool) preg_match('/(string|int|bool)$/', $str);
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isComment(string $str): bool
    {
        return str_starts_with($str, '#');
    }

}
