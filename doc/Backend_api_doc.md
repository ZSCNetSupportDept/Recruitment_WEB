## 报名注册



### 接口：

POST /php/register.php

### 请求参数：

| 名称      | 类型     | 定义   | 必需   | 默认值  | 说明   |
| ------- | ------ | ---- | ---- | ---- | ---- |
| name    | string | 姓名   | true |      |      |
| phone   | string | 手机号  | true |      |      |
| email   | string | 邮箱   | true |      |      |
| faculty | string | 学院   | true |      |      |
| class   | string | 专业   | true |      |      |
| number  | string | 学号   | true |      |      |

### 响应：

+ #### 200：成功
  - success
+ #### 409：信息已被注册
  - phone is registered
  - email is registered
  - student id is registered
+ #### 412：提交参数不合法
  - input error
  - information does not exist

##### 当响应成功时返回 data，响应不成功时不返回

##### 响应格式：JSON

	{
		"status": {number},
		"msg": {string},
		"data": {
			"mark": {string}
		}
	}





## 修改数据

通过姓名和回执修改数据

### 接口：

POST /php/modify.php

### 请求参数：

| 名称      | 类型     | 定义   | 必需   | 默认值  | 说明   |
| ------- | ------ | ---- | ---- | ---- | ---- |
| _name   | string | 旧姓名  | true |      |      |
| mark    | string | 回执   | true |      |      |
| name    | string | 新姓名  | true |      |      |
| phone   | string | 手机号  | true |      |      |
| email   | string | 邮箱   | true |      |      |
| faculty | string | 学院   | true |      |      |
| class   | string | 专业   | true |      |      |
| number  | string | 学号   | true |      |      |

### 响应：

+ #### 200：成功
  - success

+ #### 409：信息已被注册
  - phone is registered
  - email is registered
  - student id is registered

+ #### 412：提交参数不合法
  - input error
  - information does not exist

##### 响应格式：JSON

	{
		"status": {number},
		"msg": {string}
	}






## 获取信息

通过姓名和回执获取数据

### 接口：

POST /php/verify.php

### 请求参数：

| 名称   | 类型     | 定义   | 必需   | 默认值  | 说明   |
| ---- | ------ | ---- | ---- | ---- | ---- |
| name | string | 姓名   | true |      |      |
| mark | string | 回执   | true |      |      |

### 响应：

+ #### 200：成功
  - success

+ #### 412：提交参数不合法
  - input error
  - mark does not exist

##### 当响应成功时返回 data，响应不成功时不返回

##### 响应格式：JSON

	{
		"status": {number},
		"msg": {string},
		"data": {
			"ID": {string},
			"name": {string},
			"phone": {string},
			"email": {string},
			"faculty": {string},
			"class": {string},
			"number": {string},
			"mark": {string}
		}
	}


