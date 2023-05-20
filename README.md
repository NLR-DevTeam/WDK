# WDK
WDK（WebDevelopmentKit），基于PHP开发，是一个Web开发工具包，集成了许多的方法，解放双手，避免繁杂的代码
## 序言
欢迎各位开发者使用 WDK（全称WebDevelopmentKit），本程序使用 MIT 开源协议，请根据协议内容来使用 WDK
有关于 v1.0.0.0 的可使用性已经过验证，但Bug的可能性未经考量，请暂时不要将 WDK 用于大型生产环境中
关于 WDK 的文档稍后您会在 README.md 看到，不排除之后迁移到 ```docs.atomunite.cn``` 的可能
请合理使用，如果喜欢请点个 Star

# 使用文档
## 关于初始化
您可以使用以下代码初始化您的 WDK，请注意，不同的功能区有不同的初始化代码，类别如下：
```
WDK_Web
WDK_CheckTools
WDK_SQL
```
关于初始化，下面以SQL类为例：
```
require("{path}/wdk-v1.0.php");
$SQL = new WDK_SQL;
```
此代码可以让您初始化一个 WDK_SQL 对象，来访问 SQL 类的功能，关于其他的初始化，只需要将 ```WDK_SQL``` 换成其他类名即可

## Web 类的使用
需要初始化 Web 类，我们为您提供了以下方法：

### 1.页面跳转：
使用方法：```$Class->HeaderJump($URL)```

变量解释：
```
$URL：跳转的 URL 地址
```
此方法可以快速的使用Header Location的方式跳转到一个新的网页

### 2.转为Unicode：
使用方法：```$Class->stringToUnicode($Text)```

变量解释：
```
$Text：要编码的文字
```
此方法可以将文字转化为Unicode代码
### 3.Unicode Encode：
使用方法：```$Class->unicodeEncode($Unicode)```

变量解释：
```
$Unicode：被Unicode的文字
```
此方法可以将Unicode代码转化为文字
## SQL 类的使用
需要初始化 SQL 类，我们为您提供了以下方法：

### 1.获取新的 MySQLi 连接：
使用方法：```$Class->GetConnection($UseSQLSetting, $RequireArray)```

变量解释：
```
$UseSQLSetting：是否使用默认配置文件，布尔值
$RequireArray：请求数组，如果第一项为true，则不启用此项，直接调用配置文件，如果第一项为false，则调用此变量，内容为键值对，键包括：Address,Port,Username,Password,DataBaseName
```
此方法可以快速的获取一个 MySQLi 连接对象，如果错误返回错误信息，如果正确返回 Object

### 2.读数据表：
使用方法：```$Class->Read_List($Connection, $TableName, $RequireArray{可不填，默认为所有项})```

变量解释：
```
$Connection：SQL连接
$TableName：数据表名称
$RequireArray：筛选规则，选择读哪些项，为数组键值对，例： ```array("username" => "Helloworld")```
```
此方法可以对某一个SQL连接中的数据表进行读取操作，返回一个SQL Object（别着急，还有更简单的Fetch_Assoc方法可以使用）

### 2.读数据表：
使用方法：```$Class->Read_List($Connection, $TableName, $RequireArray{可不填，默认为所有项})```

变量解释：
```
$Connection：SQL连接
$TableName：数据表名称
$RequireArray：筛选规则，选择读哪些项，为数组键值对，例： ```array("username" => "Helloworld")```
```
此方法可以对某一个SQL连接中的数据表进行读取操作，返回一个SQL Object（别着急，还有简单的Fetch_Assoc方法可以使用）

### 3.从数据表中寻找数据匹配的数据：
使用方法：```$Class->Find_Data($Connection, $TableName, $RequireArray)```

变量解释：
```
$Connection：SQL连接
$TableName：数据表名称
$RequireArray：匹配规则，为数组键值对，例： ```array("score" => "114514")```
```
此方法可以对某一个SQL连接中的数据表中符合匹配规则的项进行读取操作，返回一个SQL Object（别着急，还有简单的Fetch_Assoc方法可以使用）

### 4.从数据表中更新数据：
使用方法：```$Class->Update_Data($Connection, $TableName, $RequireArray, $UpdateArray)```

变量解释：
```
$Connection：SQL连接
$TableName：数据表名称
$RequireArray：匹配规则，为数组键值对，例： ```array("score" => "114514")```
$UpdateArray：更新规则，为数组键值对，例： ```array("score" => "1919810")```
```
此方法可以对某一个SQL连接中的数据表中符合匹配规则的项进行更新操作，返回一个SendQuery后的结果

### 5.从数据表中删除数据：
使用方法：```$Class->Delete_Data($Connection, $TableName, $RequireArray)```

变量解释：
```
$Connection：SQL连接
$TableName：数据表名称
$RequireArray：匹配规则，为数组键值对，例： ```array("score" => "114514")```
```
此方法可以对某一个SQL连接中的数据表中符合匹配规则的项进行删除操作，一般没有返回，有错误返回错误信息

### 6.对 SQL Object 进行解析并整合到 List 中：
使用方法：```$Class->Fetch_Assoc($SQLObject)```

变量解释：
```
$SQLObject：SQL Object，前几个方法返回的
```
此方法可以对某一个SQL连接Query返回的Object进行解析，返回一个JSONObject，例：
```
[
  {"hello":"world"},
  {"hello":"php"}
]
```

### 发送自定义SQL请求：
使用方法：```$Class->SendQuery($Connection, $Sqls)```

变量解释：
```
$Connection：SQL连接
$Sqls：执行的SQL语句
```
此方法可以对某一个SQL连接执行一个SQL语句，正确返回SQL Object，错误返回错误信息
