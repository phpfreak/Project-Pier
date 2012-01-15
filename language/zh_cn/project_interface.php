<?php

  /**
  * @http://www.projectpier.org/
  * 
  * Translated by Martin Liu (http://martinliu.cn)
  *  Reviewed on 2011-1-15 7PM
  */


  // Array of langs
  return array(
    'upcoming milestones in next 30 days' => '近期的里程碑(在下一个30天里)',
    'show all upcoming milestones' => '显示所有将来的里程碑 (总共 %s 个)',
  
    'recent activities' => '最近的活动',
    'search button caption' => '搜索',
    'search result description' => '显示 <strong>%s 的 %s</strong> 对象匹配 <strong>"%s"</strong> 的',
    
    // Options and descriptions
    'important message desc' => '重要消息被列在了项目消息页面的侧栏“重要消息”中',
    'enable comments' => '启用评论',
    'enable comments desc' => '能查看这个对象的用户能够对它发表评论。选择 "否" 来锁定评论',
    'enable anonymous comments' => '匿名评论',
    'enable anonymous comments desc' => '允许匿名的评论被发表在这个项目上。匿名评论可以通过API或者其他信息信息源来发布 (如果启用了). 作者必须提供一个有效的姓名和电子邮件地址。 来源的 IP 地址将被记录下来。',
  
    'completed task' => '已完成任务',
    'completed tasks' => '已完成任务',
    'open task' => '未完成任务',
    'open tasks' => '未完成任务',
    'view all completed tasks' => '所有已完成任务 (总计 %s 个)',
    'recently completed tasks' => '最近完成的任务',
    'task open of total tasks' => '%s 个未完成任务在总数 %s 个的任务清单中',
    
    'read more' => '查看详情',
    'message separator' => '<p>* * *</p>',
    'comments on message' => '%s 评论',
    'comment on object' => "'%s' (%s)",
    'comment posted on' => '发布于 %s',
    'comment posted on by' => '发布于 %s 通过 <a href="%s">%s</a>',
    'completed on by' => '%s  <a href="%s">%s</a>',
    'completed on' => '%s',
    'started on by' => '%s <a href="%s">%s</a>',
    'posted on by' => '%s <a href="%s">%s</a>',
    'posted on' => '%s',
    'milestone assigned to' => '分派给 %s',
    'project started on' => '开始于',

    'projects copy new name' => '%s (复制项目)',
    'projects copy source' => '从此项目复制',
    'projects copy details' => '复制详情',
    'projects copy folders' => '复制文件夹',
    'projects copy tasks' => '复制任务',
    'projects copy milestones' => '复制里程碑',
    'projects copy messages' => '复制消息',
    'projects copy comments' => '复制评论',
    'projects copy files' => '复制文件',
    'projects copy users' => '复制用户和公司',
    'projects copy links' => '复制链接',
    'projects copy pages' => '复制 Wiki 页面',

    'can manage files' => '能管理文件',
    'can upload files' => '能上传文件',
    'can manage messages' => '能管理消息',
    'can manage milestones' => '能管理里程碑',
    'can manage comments' => '能管理评论',
    'can manage tasks' => '能管理任务',
    'can manage tickets' => '能管理票单',
    'can assign tasks to other clients' => '能分派任务给其他客户',
    'can assign tasks to owner company' => '能分派任务给所属公司',
    'can change milestones status' => '能变更里程碑的状态',
    'can manage times' => '能管理时间',
    
    'send milestone assigned to notification' => '发送邮件通知给用户',
    'task list target project' => '项目来移动项目清单到',
    
    'edit company data' => '<a href="%s">编辑</a> 公司数据',
    'company users involved in project' => '%s 个用户参与在 %s',
    'companies involved in project' => '参与项目的公司',
    
    'project permissions form hint' => '使用 <a href="%s">权限表单</a> 你能方便地增加或者删除公司和用户，并控制他们的访问权限.',
    
    'additional message text desc' => '只在评论页面上可见的附加消息文字',
    'expand additional text' => '展开',
    'collapse additional text' => '收缩',
    'email notification' => '邮件通知',
    'email notification desc' => '通过邮件把这个消息通知给选中的人',
    
    'subscribers desc' => '订阅将在当其他人发布一个评论在这个信息上的时候收到一个邮件通知',
    'admins can post comments on locked objects desc' => '<strong>评论已被锁定</strong>，但是你作为管理员将会有权限发布评论。注意如果你期望从你的客户或者非管理员用户收到回复，你需要对这个对象的评论解锁  <i>(设置 "启用评论" 选项为 "是")</i>.',
    
    'all permissions' => '所有',
    
    'add by' => '添加自',
    'edit by' => '更新自',
    'delete by' => '删除自',
    'close by' => '被关闭',
    'open by' => '被开放',
    'upload by' => '被上传',
    'created by' => '被创建',
    
    'project description' => '描述',
    'project status' => '项目状态',
    'show project desciption in overview' => '在概要页面上显示项目描述?',

    'admin notice comments disabled' => '评论在这个对象上被禁用, 但是你作为管理员将会有权限发布评论。 如果你期望来自其他非管理员的回复，你需要设置 "启用评论" 为 "是"。',
    
    // iCal
    'icalendar' => 'iCalendar',
    'icalendar subscribe' => 'iCalendar',
    'icalendar subscribe desc' => '使用这个链接来导入所有里程碑和任务数据到你的常用的日历应用中。',
    'icalendar password change notice' => '<strong>注意：</strong> 如果你改变了你的密码，链接到日历的数据也将改变！ 你需要重新订阅。',
    
    // Private
    'private message desc' => '私有消息只对公司内部成员是可见的。 客户公司成员将不能看到它们。',
    'private milestone desc' => '私有里程碑只对公司内部成员是可见的。 客户公司成员将不能看到它们.',
    'private task list desc' => '私有任务清单只对公司内部成员是可见的。 客户公司成员将不能看到它们',
    'private comment desc' => '私有评论只对公司内部成员是可见的。 客户公司成员将不能看到它们',

    'priority' => '优先度',
    'order by name' => '按名称排序',
    'order by priority' => '按优先度排序',
    'order by milestone' => '按里程碑排序',
    'group by project' => '按项目分组',
    
  ); // array

?>