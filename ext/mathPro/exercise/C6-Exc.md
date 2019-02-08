>请设置编辑器的编码格式为utf-8

0. 参照下图，写一个登录的html静态页面，文件名为`login.html`，请使用form表单,`action`和`method`属性暂时填为空。`ACCOUNT`输入框默认值为admin，`PASSWORD`输入框出现`please input password`的灰色提示字.
[图]
0. 为上一题写的html代码，通过 JavaScript 增加表单校验功能，如果用户出现了不符合的输入则`alert`弹窗提醒。
    - `ACCOUNT`输入框只能输入5-10位长度（包括边界）的数字或字母组合
    - `PASSWORD`输入框的只能输入6-12位长度（包括边界）的内容。
    - `ACCOUNT`和`PASSWORD`输入框都不能含有空格，都不能含有中文字符。
0. 创建一个登录的php页面，文件名为`login.php`,在原有的`html`下方嵌入一个php输入，表示是否成功登录。如果登录成功，则在`Submit`的下方，输出`LOGIN SUCCESS`,否则输出 `LOGIN FAILED` .
    - 只有下面的账号密码能够成功登录


| ACCOUNT | PASSWORD | 
| :---:|:---:|
|admin|admmiin|
|Bruke|2010brPW|
|Meredith|strrxiMER|
|Shepherd|4MELOVE|
|Richard |Webber|
|Yang|Christina|

    
    