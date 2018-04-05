<?php
namespace VarRef;

use Scope;
use ValRef;
use ValRef\ArrayVal;
use VarRef;

class ListVarRef implements VarRef
{
    public function __construct(array $vars)
    {
        $this->vars = $vars;
    }

    public function getValue(Scope $scope)
    {
        return null; // Cannot get value of list expression
    }

    public function assignValue(Scope $scope, ValRef $valRef)
    {
        if (!($valRef instanceof ArrayVal)) {
            return false;
        }
        $didAssignAll = true;
        for ($i = count($this->vars) - 1; $i >=0; $i--) {
            $var = $this->vars[$i];
            if ($var === null) {
                continue;
            }
            $didAssignAll = $var->assignValue($scope, $valRef->arrayFetch($i)) && $didAssignAll;
        }
        return $didAssignAll;
    }

    public function unsetVar(Scope $scope)
    {
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function __toString()
    {
        return "List(" . implode(', ', $this->vars) . ")";
    }

}
