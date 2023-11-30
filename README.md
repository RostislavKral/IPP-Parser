# Implementační dokumentace k 1. úloze do IPP 2022/2023 #
## Jméno a příjmení: Rostislav Král
## Login: xkralr06 ##

### Základní informace ###
- Projekt používá striktní typování umožněné díky direktivě `declare(strict_types=1)`.
- Pro třídy využívá autoloadingu tříd přes SPL(Standard PHP Library) registr.
- Byl použit jeden návrhový vzor a to konkrétně Továrna pro tvorbu instrukcí.
- Některé kontruktory jsou řešeny přes "property promotion" z verzí PHP8.0+
***
### Popis průběhu programu ###

Projekt začíná ve skriptu `parse.php`, kde je implementován přepínač --help a čtení ze standardního vstupu.
Řeší tak rozparsování hlavičky a jednotlivých instrukcí podle mezery. Dále se nainicializuje třída `IPPCode23\Analyzer`, která obaluje celý program
a kam se také dál posílají rozparsované instrukce. Třída `IPPCode23\Analyzer` v konstruktoru vytvoří novou instanci třídy
`DOMDocument`se všemi náležitostmi, které projekt vyžaduje. Primární je ale metoda `IPPCode23\Analyzer::makeInstruction()`,
která jednak odstraní komentáře (metoda `_deleteCommentsFromArgs()`), druhak zkontroluje korektnost escape sekvencí
(metoda `_escapeSequencesCheck()`) ale hlavně
volá Tovární třídů instrukcí `IPPCode23\Instruction\InstructionFactory` a právě ta určuje, který z producentů
bude zvolen pro tvorbu Instrukce. Producent je zvolen na základě počtu operandů, konkrétně se jedná o třídy `IPPCode23\Instruction\InstructionUnary`
, `IPPCode23\Instruction\InstructionBinary`, `IPPCode23\Instruction\InstructionTernary`, `IPPCode23\Instruction\InstructionQuaternary`.
Všechny tyto třídy implementují abstraktní třídu `IPPCode23\Instruction\Instruction`
(uvažoval jsem i o rozhraní ale abstraktní třída se mi zdála vhodnější, rozhraní by totiž v mém případě vyžadovalo větší režii).
Jednotliví producenti řeší pořadí a typ svých operandů(většinou odlišným způsobem) přes injektovanou třídu `IPPCode23\Operands` 
do třídy `IPPCode23\Instruction\Instruction`, která implementuje regulární výrazy pro dané typy operandů
pro zjištění korektnosti, jinak vede na chybový kód 23.
***
### Rozšíření NVP ###
Drtivá většina kódu je naimplementována pomocí OOP a jako návrhový vzor byla použita Továrna.
Továrna je narozdíl od jiných vzorů stejné kategorie jako např. abstraktní Továrna nebo Prototyp
jednodušší na implementaci každopádně pořád mi hezky oddělil logiku jednotlivých typů instrukcí od sebe
aby na sobě nebyly závislé avšak při větším množství Produktů/Podtříd bych určitě zvolil jiný návrhový vzor.
Vzor jinak ale dodržuje do určité míry principy jako jsou Single Responsibility Principle a Open Close Principle.

###### Jak je vzor naimplementován ######

- `IPPCode23\Instruction\InstructionFactory` je tovární třída, kde jsou na základě počtu operandů voláni příslušní
Producenti třídy implementující(dědící) Produkt tím pádem můžeme nechat sestrojit instrukci nehledě na její typ.
Pokud Továrna nenajde ani v jedné instrukční sadě (konstanta pole Nnárních instrukcí) skončí program chybovým kódem 22.
- Producenti -`IPPCode23\Instruction\InstructionUnary`  , `IPPCode23\Instruction\InstructionBinary`,
`IPPCode23\Instruction\InstructionTernary`, `IPPCode23\Instruction\InstructionQuaternary`
- A Produktem je abstraktní třída `IPPCode23\Instruction\Instruction`, která např. umožňuje Producentům používat
metody `IPPCode23\Operands` pro ověření operandů.
