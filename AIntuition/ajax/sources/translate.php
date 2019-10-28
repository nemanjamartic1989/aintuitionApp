<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/core/core.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/include/_functions.php");
    $dbConfig=new DBConfig();
    $dbParameter=$dbConfig::getDBPatameter();
    $dbh= new DatabaseHandler($dbParameter['host'], $dbParameter['dbName'], $dbParameter['dbUser'], $dbParameter['dbPass']);

    if(isset($_POST['type']))
    {
        $type=$_POST['type'];
    }

    if(isset($_POST['text']))
    {
        $text=trim($_POST['text']);
    }

    if(isset($_POST['chosenLanguage']))
    {
        $chosenLanguage=$_POST['chosenLanguage'];
    }

    $translate= new Translator('trnsl.1.1.20170928T095443Z.fc4a7b57be84acdd.7f5e3578aab9443c7657a61cdfa881a50b4eff29');
    $output=array();
    $langIDs=array();
    $sql="SELECT languageID, languageName, shortName 
          FROM tdbLanguages";
    $result=$dbh->GetAll($sql);

    foreach($result as $row)
    {

        $outputLang=trim($row['shortName']);
        $langIDs[$outputLang]=$row['languageID'];
        $lang=$chosenLanguage.'-'.$outputLang;
        $resultOfTranslate = $translate->translate($text,$lang);
        $output[$outputLang]     = $resultOfTranslate;
    }
    $output[$chosenLanguage]=$text;

    if($type=="save")
    {
        foreach($output as $shortName=>$text)
        {
            $languageID=$langIDs[$shortName];
            $sql="INSERT INTO tdbAIntuitionTranslatedWords(`languageID`,`words`) VALUES ('$languageID','$text')";
            $dbh->Execute($sql);
        }
        $output=array('output','Data has successfully saved.');
    }

    echo json_encode(array('output'=>$output));

?>