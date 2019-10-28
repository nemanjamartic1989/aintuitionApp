<?php
    $dir = dirname(__DIR__);
    include ($dir . "../../../classes/init.php");
    $argv = INI::getArguments();
    $AIntuitionID = $argv["AIntuitionID"];
    $AIntuition = new AIntuition($AIntuitionID);
    $AIntuitionParameters = json_decode($AIntuition->getFromAIntuition(array("AIntuitionParameters")));

    $AnnualBudget = new AnnualBudget();
    $annualBudgetBABU = $AnnualBudget->annualBudgetBABU();
    $LaborCost = new LaborCost();
    $laborCostBABU = $LaborCost->laborCostBABU();

    $cnt = array();
    if (is_object($AIntuitionParameters)) {
        foreach ($annualBudgetBABU as $key => $value) {
            if (in_array($value["businessArea"], $AIntuitionParameters->holding->businessArea)) {
                $cnt["businessArea"][$value["businessArea"]]['labor'] += $laborCostBABU[$key]["sum"];
                $cnt["businessArea"][$value["businessArea"]]['budget'] += $value["sum"];
            }

            if (in_array($value["businessUnit"], $AIntuitionParameters->holding->businessUnit)) {
                $cnt["businessUnit"][$value["businessUnit"]]['labor'] += $laborCostBABU[$key]["sum"];
                $cnt["businessUnit"][$value["businessUnit"]]['budget'] += $value["sum"];
            }
        }
    } else {
        foreach ($annualBudgetBABU as $key => $value) {
            $cnt["holding"]["businessArea"][$value["businessArea"]]['labor'] += $laborCostBABU[$key]["sum"];
            $cnt["holding"]["businessArea"][$value["businessArea"]]['budget'] += $value["sum"];

            $cnt["holding"]["businessUnit"][$value["businessUnit"]]['labor'] += $laborCostBABU[$key]["sum"];
            $cnt["holding"]["businessUnit"][$value["businessUnit"]]['budget'] += $value["sum"];
        }
    }

    if (isset($cnt["businessArea"])) {
        ksort($cnt["businessArea"]);
    }
    if (isset($cnt["businessUnit"])) {
        ksort($cnt["businessUnit"]);
    }

    ksort($cnt);

    $AIntuition->insertAIReport(json_encode($cnt), "all");

    // calculation percentages(almost same like it software asset management)
    
    function budgetSpent($labor, $budget) {
        return $budgetSpent = round($labor * 100 / $budget, 2);
    }
    
    function checkBudgetSpent($labor, $budget, $annualBudgetSpendingPerMonth) {

        $budgetSpent = budgetSpent($labor, $budget);
        
        if ($budgetSpent > $annualBudgetSpendingPerMonth) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    $AIntuitionMobileReports = $AIntuition->AIntuitionMobileReports();
    $AIntuitionHandlingTypes = $AIntuition->getFromAIntuition(array("AIntuitionHandlingTypes"));
    $annualBudgetSpendingPerMonth = $AIntuition->getFromAIntuition(array("annualBudgetSpendingPerMonth"));
    $calculateArray = array();
    $good_bad = array();
    
    for ($i = 0; $i < count($AIntuitionMobileReports); $i++) {        
        $expLast = json_decode($AIntuitionMobileReports[$i]["status"]);
        $n = 0;
        $duty = array();
        if (!isset($expLast->holding)) {
            $arrExpLast = $expLast;
        } else {
            $arrExpLast = $expLast->holding;
        }

        foreach ($arrExpLast as $keyLast => $last) {
            foreach ($last as $key => $value) {
                $checkAIntuitionMobileReport = checkBudgetSpent($last->$key->labor, $last->$key->budget, $annualBudgetSpendingPerMonth);
                // delegation duty part and status report
                if (!$checkAIntuitionMobileReport) {
                    $n++;
                    if ($AIntuitionHandlingTypes == "Duty") {
                        if ($keyLast == "businessArea") {
                            $BusinessArea = new BusinessArea($key);
                            $get_employeeDutyBusinessArea = $BusinessArea->get_employeeDutyBusinessArea();
                            if ($get_employeeDutyBusinessArea) {
                                $duty[$keyLast][$key] = $get_employeeDutyBusinessArea;
                            }
                        } elseif ($keyLast == "businessUnit") {
                            //nemamo jos ovaj duty
                        }
                    } elseif ($AIntuitionHandlingTypes == "Private") {
                        $duty = $AIntuition->get_employeeID();
                    }
                }
            }
        }

        $report = TRUE;
        if ($n > 0) {
            $report = FALSE;            
        }

        if ($AIntuitionMobileReports[$i]["readInfo"] == 0) {
            if ($n > 0) {
                $good_bad["badUnread"] += 1;
            } else {
                $good_bad["goodUnread"] += 1;
            }
        }
        
        if ($AIntuitionMobileReports[$i]["reportCode"] == NULL) {
            $AIntuition->updateReportCode($AIntuitionMobileReports[$i]["AIntuitionReportID"], $report);
            if ($AIntuitionMobileReports[$i]["dutyDelegation"] == NULL) {
                if(!empty($duty)){
                    $AIntuition->updateDutyDelegation($AIntuitionMobileReports[$i]["AIntuitionReportID"], json_encode($duty));
                }
            }
        }
        $calculateArray[$i] = $report;
    }

    $AIntuition->updateUnread($good_bad["goodUnread"], $good_bad["badUnread"]);
    $AIntuition->AIntuitionInsertPercentages($calculateArray);
?>