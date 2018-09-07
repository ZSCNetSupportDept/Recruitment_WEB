# 中山学院网络维护科招新系统

* [功能介绍](#功能介绍)
* [开发人员](#开发人员)
* [环境要求](#环境要求)
* [各文件夹及其内容说明](#各文件夹及其内容说明)
* [需要自定义的部分](#需要自定义的部分)
- - -

### 功能介绍：
1. **收集**报名招新考试人员的**信息**（姓名、学号、班级、联系方式等）
2. 根据用户填写的信息与数据库中存储的新生信息比对，不让**非该校新生**的人员报名，同时**防止恶意报名**
3. 用户可以使用报名成功后获取到的一个**唯一编码**来**修改自己的报名信息**（编码通过**网页提示**以及**发送邮件**的方式告知用户）
4. **群发邮件**给已经填写邮箱信息的用户（群发请使用./php/send_all.php这个页面，该功能的页面没有交给前端写）
5. **记录**用户报名成功/失败、用户修改信息成功/失败的结果和原因（在./php/logs/里）
- - -

### 开发人员：
* [Nihility](https://github.com/NihilityT)——后端
* [Lumix](https://github.com/Katharsis-C)——前端
- - -


### 环境要求：
* PHP(5.6或以上)
* Nginx
* MySQL
- - -


### 各文件夹及其内容说明：
|文件夹|内容 |
|----|----|
|./|项目根目录（注：前端页面就放在这我懒得整理了）|
|./php/|后端PHP代码|
|./js/|前端JavaScript代码|
|./pics/|前端使用的图片文件|
|./doc/|API文档|
|./css/|css文件|
|./nginx_config/|nginx配置文件|
- - -


### 需要自定义的部分：

#### 连接MySQL使用的参数：
>所处位置：./php/include/class.database.php.example  
>请复制为：./php/include/class.database.php 并修改$DB_NAME、$DB_USR、$DB_PWD

    class Database {
        ……
 	    private $DB_HOST = 'localhost';
 	    private $DB_NAME = 'reg_db';    /*MySQL database name, we use 'reg_db' here.*/
 	    private $DB_USR = '';           /*Your MySQL username*/
 	    private $DB_PWD = '';           /*Your MySQL password*/
 	    ……
 	}
<br >

#### 使用邮箱smtp服务的参数：
>所处位置：./php/include/smtp.php.example  
>请复制为：./php/include/smtp.php 并修改$usr、$pwd

    function send_message($address, $subject, $body, $isHTML = true) {
    	$usr = 'example@example.com';
    	$pwd = 'xxxxxxxxxxxxxxxx';

    	/*
    	This password is NOT your e-mail password, it's a 16 characters smtp password provided by your e-mail ISP.
    	此处的密码不是邮箱帐号，而是由邮箱服务提供商提供给你的16位smtp服务密码。
    	*/
    	……
    }
<br >

#### Nginx配置文件
>所处位置：./nginx_config/recrutment.conf

请根据自己的需要修改参数

- - -
——整理by[咸猫](https://github.com/MoYuDeXianMao)
