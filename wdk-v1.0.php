<?php

/*
    NLR-DevTeam WDK(Website Development Kit)
    Version : 1.0.0.0

    Website : https://nlrdev.top
    探索技术，开放共享 Explore Technology & Open Source
*/

$SQLSetting = array(
    "Enable" => false,                  // 启用 SQL 工具
    "Address" => "{IP}",                // 数据库 IP 地址，本地MySQL请填写 localhost 例：localhost
    "Port" => "3306",                   // 数据库端口，默认3306，不知道是什么的不要改 例：3306
    "Username" => "{username}",         // 数据库用户名，创建数据库时候的，不是操作系统用户名 例：DB1
    "Password" => "{password}",         // 数据库密码，创建数据库时候的，不是操作系统密码 例：密码还有啥例子
    "DataBaseName" => "{NAME}"          // 数据库名称，创建数据库时候的，不是数据表名称 例：UserDataDB
);

/* 自定义插件块，当您使用 WDK 插件时，可以在此处添加需要的代码 */



// 返回信息时候使用的语言，默认为英文，暂时也只提供英文的反馈，这是为了防止当因为编码问题而刻意设计的，并非不想使用中文
// 翻译贡献者英语中规中矩，不算很好，也没有使用翻译软件，如果您能提供更精准的翻译，欢迎提交 issues
$Language = "en_US";



// 接下来是程序部分，如果您不是要刻意修改，请不要动
switch ($Language) {
    case "en_US":
        $LanguageLib = $LanguageLib = $Language_en_US;
        break;
    default:
        //默认en_US
        $LanguageLib = $Language_en_US;
}

//语言库
$Language_en_US = array(
    "System" => array(
        // Error 部分
        "SettingError" => "System.SettingError"
    ),
    "SQL" => array(
        // Error 部分
        "FunctionNotEnableError" => "SQL.FunctionNotEnable.Error",
        "CannotConnectToServer" => "SQL.FailedToConnect.Error",
        "ProvideVariableNotAllowed" => "SQL.VariableProvide.Error"
    )
);

class WDK_Web
{
    public function HeaderJump($url)
    {
        header("location: {$url}");
    }

    public function stringToUnicode($str)
    {
        $unicodeName = json_encode($str);
        $unicodeName = trim($unicodeName, '"');
        return $unicodeName;
    }

    function unicodeEncode($str)
    {
        return json_encode($str);
    }
}

class WDK_CheckTools
{
    public function CheckExist($List, $CheckList)
    {
        if (is_array($List) && is_array($CheckList)) {
            for ($i = 0; $i++;) {
                if (in_array($CheckList[$i], $List)) {
                    continue;
                } else {
                    break;
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}

class WDK_SQL
{
    /*
        WEB_SQL GetConnection
        获取一个 MySQLi 对象

        返回：MySQL Connection
    */
    public function GetConnection($UseSQLSetting, $RequireArray)
    {
        global $LanguageLib, $SQLSetting;

        if (is_bool($UseSQLSetting) && $UseSQLSetting == true) {
            if ($GLOBALS["SQLSetting"]["Enable"] == true) {

                $RequireArray = $SQLSetting;

                // 创建新的 SQL Connection

                $Address = $RequireArray["Address"];
                $Port = $RequireArray["Port"];
                $Username = $RequireArray["Username"];
                $Password = $RequireArray["Password"];
                $DataBaseName = $RequireArray["DataBaseName"];

                $sql_connection = new mysqli($Address, $Username, $Password, $DataBaseName, $Port);

                return $sql_connection;
            } else {
                return $LanguageLib["SQL"]["FunctionNotEnableError"]; // SQL未启用
            }
        } else {
            if (is_array($RequireArray)) {
                if ($RequireArray == array()) {
                    return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
                } else {
                    if (isset($RequireArray["Address"], $RequireArray["Username"], $RequireArray["Password"], $RequireArray["DataBaseName"])) {
                        if (isset($RequireArray["Port"])) {
                            $sql_connection = new mysqli($RequireArray["Address"], $RequireArray["Username"], $RequireArray["Password"], $RequireArray["DataBaseName"], $RequireArray["Port"]);
                        } else {
                            $sql_connection = new mysqli($RequireArray["Address"], $RequireArray["Username"], $RequireArray["Password"], $RequireArray["DataBaseName"]);
                        }
                        return $sql_connection;
                    }
                }
            } else {
                return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
            }
        }
    }

    /*
        WEB_SQL SendQuery
        发送自定义 SQL Query

        需要：MySQL Connection($Connection), SQL语句($Sqls)
        返回：MySQL Object
    */
    public function SendQuery($Connection, $Sqls)
    {
        $Result = $Connection->query($Sqls);

        if ($Result->num_rows > 0) {
            return $Result;
        } else {
            return false;
        }
    }



    /*
        WEB_SQL Read_List
        读取一个数据表

        需要：MySQL Connection($Connection), TableName($TableName), RequireArray($RequireArray)
        返回：MySQL Object
    */
    public function Read_List($Connection, $TableName, $RequireArray = "*")
    {
        global $LanguageLib;

        if (is_array($RequireArray)) {
            $RequireText = "";
            for ($i = 0; $i++;) {
                if (isset($RequireArray[$i])) {
                    if ($i == 0) {
                        $RequireText = $RequireArray[$i];
                        continue;
                    } else {
                        if ($RequireArray[$i] == end($RequireArray)) {
                            $RequireText = $RequireText . ", " . end($RequireArray);
                            break;
                        }
                    }
                } else {
                    return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
                }
            }
            $Sqls = "SELECT {$RequireText} FROM {$TableName}";
            $Result = $Connection->query($Sqls);
            return $Result;
        } else {
            if ($RequireArray == "*") {
                $Sqls = "SELECT {$RequireArray} FROM {$TableName}";
                $Result = $Connection->query($Sqls);
                return $Result;
            } else {
                return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
            }
        }
    }



    /*
        WEB_SQL Find_Data
        在数据表中依据 $RequireArray 寻找对应数据

        需要：MySQL Connection($Connection), TableName($TableName), RequireArray($RequireArray)
        返回：MySQL Object
    */
    public function Find_Data($Connection, $TableName, $RequireArray)
    {
        global $LanguageLib;

        if (is_array($RequireArray)) {
            $RequireText = "";
            $i = 0;

            foreach ($RequireArray as $Key => $Value) {
                if ($i == 0) {
                    $RequireText = $Key . "=" . "'{$Value}'";
                } else {
                    $RequireText = $RequireText . " AND " . $Key . "=" . "'{$Value}'";
                }
                $i++;
            }

            $Sqls = "SELECT * FROM {$TableName} WHERE {$RequireText}";
            $Result = $Connection->query($Sqls);
            return $Result;
        } else {
            return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
        }
    }



    /*
        WEB_SQL Update_Data
        在数据表中依据 $RequireArray 更新对应数据

        需要：MySQL Connection($Connection), TableName($TableName), RequireArray($RequireArray), UpdateArray($UpdateArray)
        返回：MySQL Object
    */
    public function Update_Data($Connection, $TableName, $RequireArray, $UpdateArray)
    {
        global $LanguageLib;

        if (is_array($RequireArray)) {
            $RequireText = "";
            $UpdateText = "";
            $i = 0;

            foreach ($RequireArray as $Key => $Value) {
                if ($i == 0) {
                    $RequireText = $Key . "=" . "'{$Value}'";
                } else {
                    $RequireText = $RequireText . " AND " . $Key . "=" . "'{$Value}'";
                }
                $i++;
            }

            $i = 0;

            foreach ($UpdateArray as $Key => $Value) {
                if ($i == 0) {
                    $UpdateText = $Key . "=" . "'{$Value}'";
                } else {
                    $UpdateText = $UpdateText . ", " . $Key . "=" . "'{$Value}'";
                }
                $i++;
            }

            $Sqls = "UPDATE {$TableName} SET {$UpdateText} WHERE {$RequireText}";
            $Result = $Connection->query($Sqls);
            return $Result;
        } else {
            return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
        }
    }



    /*
        WEB_SQL Delete_Data
        在数据表中依据 $RequireArray 删除对应数据

        需要：MySQL Connection($Connection), TableName($TableName), RequireArray($RequireArray)
        返回：没有返回，错误会返回错误
    */
    public function Delete_Data($Connection, $TableName, $RequireArray)
    {
        global $LanguageLib;

        if (is_array($RequireArray)) {
            $RequireText = "";
            $i = 0;

            foreach ($RequireArray as $Key => $Value) {
                if ($i == 0) {
                    $RequireText = $Key . "=" . "'{$Value}'";
                } else {
                    $RequireText = $RequireText . " AND " . $Key . "=" . "'{$Value}'";
                }
                $i++;
            }

            $Sqls = "DELETE FROM {$TableName} WHERE {$RequireText}";
            $Result = $Connection->query($Sqls);
        } else {
            return $LanguageLib["SQL"]["ProvideVariableNotAllowed"]; // 参数不对
        }
    }



    /*
        WEB_SQL Fetch_Assoc
        获取具体 $rows 信息

        需要：MySQL Object($SQLObject)
        返回：JSON Object
    */
    public function Fetch_Assoc($SQLObject)
    {
        if ($SQLObject->num_rows > 0) {
            $OutArray = [];
            $i = 0;
            // 输出数据
            while ($row = $SQLObject->fetch_assoc()) {
                $i++;
                $InArray = [
                    $i => $row
                ];
                $OutArray = array_merge($OutArray, $InArray);
            }
            return $OutArray; // 输出 OutArray
        } else {
            return array(); // 返回空数据
        }
    }
}
