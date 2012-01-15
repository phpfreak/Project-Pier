<?php

  /**
  * @http://www.projectpier.org/
  * 
  * Translated by Martin Liu (http://martinliu.cn)
  *  Reviewed on 2011-1-15 7PM
  */

  return array(
  
    // General
    'invalid email address' => '邮件地址格式无效',
    'id missing' => '请求ID缺失',
   
    // Company validation errors
    'company name required' => '需要公司组织名称',
    'company homepage invalid' => '主页地址格式错误(http://www.example.com)',
    
    // User validation errors
    'username value required' => '需要填写用户名',
    'username must be unique' => '抱歉，所选用户名已经被占有了',
    'email value is required' => '需要填写邮件地址',
    'email address must be unique' => '抱歉，所选邮件地址已经被占用了',
    'company value required' => '用户必须是某公司的成员',
    'password value required' => '密码需要填写',
    'passwords dont match' => '密码不一致',
    'old password required' => '需要旧的密码',
    'invalid old password' => '旧密码无效',
    'user homepage invalid' => '主页值无效(http://www.example.com)',
    
    // Avatar
    'invalid upload type' => '无效的文件格式，允许的是 %s',
    'invalid upload dimensions' => '文件尺寸无效，最大格式为 %s x %s 像素',
    'invalid upload size' => '图片大小无效。最大为 %s',
    'invalid upload failed to move' => '上传文件失败',
    
    // Registration form
    'terms of services not accepted' => '为了创建一个账号你需要阅读和接受我们的服务条款',
    
    // Init company website
    'failed to load company website' => '加载站点失败，所属公司未发现',
    'failed to load project' => '加载活动项目失败',
    
    // Login form
    'username value missing' => '请输入你的用户名',
    'password value missing' => '请输入你的用密码',
    'invalid login data' => '登陆失败，请检查你的登陆信息后重试',
    
    // Add project form
    'project name required' => '需要项目名称',
    'project name unique' => '项目名称必须是唯一的',
    
    // Add message form
    'message title required' => '需要标题',
    'message title unique' => '信息标题必须在这个项目中是唯一的',
    'message text required' => '需要标题的文本信息',
    
    // Add comment form
    'comment text required' => '评论的文本信息是必须的',
    
    // Add milestone form
    'milestone name required' => '需要填写里程碑名称',
    'milestone due date required' => '需要填写里程碑日期',

    // Add task list
    'task list name required' => '需要填写任务清单名称',
    'task list name unique' => '任务清单名称在此项目中必须是唯一的',
    
    // Add task
    'task text required' => '需要填写任务文本',

    // Test mail settings
    'test mail recipient required' => '收信人地址是必须的',
    'test mail recipient invalid format' => '收信人地址格式无效',
    'test mail message required' => '邮件消息文字是必须的',
    
    // Mass mailer
    'massmailer subject required' => '消息主题是必须的',
    'massmailer message required' => '消息信息是必须的',
    'massmailer select recipients' => '选择将收到此邮件的用户',
    
  ); // array

?>