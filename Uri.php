<?php

//Slow Code, dont use these classes, was just for testing and experimenting
class URI_Var
{
    public $name = "";
    public $data = null;

    function __construct($varName, $varData)
    {
        $this->name = $varName;
        $this->data = $varData;
    }
}

class URI_Var_List //a list of Uri Data in an hashed format for speed
{
    public $varList = [];

    function addVar($var)
    {
        $this->varList[hash("md5", $var->name)] = $var->data;
    }

    function isValid()
    {
        return !empty($this->varList);
    }

    function removeVar($varName)
    {
        $hashedName = hash("md5", $varName);
        if (isset($this->varList[$hashedName])) 
        {
            unset($this->varList[$hashedName]);
        }
    }

    //Returns Null if var is not valid
    function getVar($varName)
    {
        $hashedName = hash("md5", $varName);

        if (isset($this->varList[$hashedName])) {
            return $this->varList[$hashedName];
        }

        return null;
    }
}

function format_FromURI($uri)
{
    $strlen = strlen($uri);

    $varList = new URI_Var_List();

    if($strlen > 0)
    {
        $isName = true;

        $nameBuffer = "";
        $dataBuffer = "";

        for($i = 0; $i < $strlen; $i++)
        {
            $char = $uri[$i];
    
            if($isName)
            {
                if($char == '=')
                {
                    $isName = false;
                    continue;
                }

                $nameBuffer .= $char;
            }
            else
            {
                if($char == '&')
                {
                    if(strlen($dataBuffer) <= 0)
                    {
                        throw new Exception('URI Data Buffer was Invalid!');
                    }
                    if(strlen($nameBuffer) <= 0)
                    {
                        throw new Exception('URI Name Buffer was Invalid!');
                    }

                    $isName = true;
                    $varList->addVar(new URI_Var($nameBuffer, $dataBuffer));

                    $nameBuffer = "";
                    $dataBuffer = "";

                    continue;
                }

                $dataBuffer .= $char;
            }

            
        }

        if(strlen($dataBuffer) > 0 && strlen($nameBuffer))
        {
            $varList->addVar(new URI_Var($nameBuffer, $dataBuffer));
        }
    }

    return $varList;
}

function getDataFromFormatted($formattedUriList, $varName)
{
    if($formattedUriList->isValid() === false)
         return null;

    try{
       $var_ = $formattedUriList->getVar($varName);

       if($var_ !== null)
       {
          return $var_;
       }
    }
    catch(Exception $e) //write to server logs or some bs
    {
    }

    return null;
}
?>
