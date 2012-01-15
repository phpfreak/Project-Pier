<?php

  /**
  * @http://www.projectpier.org/
  * 
  * Translated by Martin Liu (http://martinliu.cn)
  *  Reviewed on 2011-1-15 7PM
  */


  return array(
  
    // Empty, dnx etc
    'project dnx' => '所请求的项目在数据库中不存在',
    'message dnx' => '所请求的消息不存在',
    'no comments in message' => '这个消息上没有评论',
    'no comments associated with object' => '这个项目上没有评论被发表',
    'no messages in project' => '这个项目上没有消息',
    'no subscribers' => '没有用户订阅这个消息',

    'no activities in project' => '这个项目上还没有活动被记录',
    'comment dnx' => '所请求的评论不存在',
    'milestone dnx' => '所请求的里程碑不存在',
    'time dnx' => '所请求的时间记录不存在',
    'task list dnx' => '所请求的任务清单不存在',
    'task dnx' => '所请求的任务不存在',
    'no milestones in project' => '在这个项目中还没有里程碑',
    'no active milestones in project' => '在这个项目中还没有活动的里程碑',
    'empty milestone' => '这个里程碑是空的。你能给它在任何时候增加 <a href="%s">消息</a> 或者 <a href="%s">任务清单</a> ',
    'no logs for project' => '这个项目还没有记录相关的信息',
    'no recent activities' => '在数据库中最近没有活动被记录',
    'no open task lists in project' => '在这个项目中还没有开放的任务清单',
    'no completed task lists in project' => '在这个项目中还没有完成的任务清单',
    'no open task in task list' => '这个任务清单中还没有定义任务',
    'no projects in db' => '在数据库中还没有定义项目',
    'no projects owned by company' => '还没有公司来负责的项目',
    'no projects started' => '还没有已经开始的项目',
    'no active projects in db' => '还没进行的项目',
    'no new objects in project since last visit' => '从您上一次访问到现在，这个项目上还没有新的对象生成',
    'no clients in company' => '您的公司还没有注册客户',
    'no users in company' => '这个公司中没有用户存在',
    'client dnx' => '所选择的客户公司不存在',
    'company dnx' => '所选择的公司不存在',
    'user dnx' => '所请求的用户在数据库中不存在',
    'avatar dnx' => '头像不存在',
    'no current avatar' => '没有上传头像',
    'no current logo' => '没有上传图标',
    'user not on project' => '所选择的用户没有参与在被选的项目中',
    'company not on project' => '所选择的公司没有参与被选的项目',
    'user cant be removed from project' => '所选择的用户不能从这个项目中删除',
    'tag dnx' => '请求的标签不存在',
    'no tags used on projects' => '在这个项目中没有标签',
    'no forms in project' => '在这个项目中没有表单',
    'project form dnx' => '所请求的项目表单在数据库中不存在',
    'related project form object dnx' => '相关的表单对象在数据库中不存在',
    'no my tasks' => '没有任务被分派给你',
    'no search result for' => '没有与 “<strong>%s</strong>” 匹配的结果',
    'config category dnx' => '你请求的配置分类不存在',
    'config category is empty' => '所选择的配置分类是空的',
    'email address not in use' => '%s 没有在使用',
    'no administration tools' => '在数据库中没有注册管理工具',
    'administration tool dnx' => '管理工具 “%s” 不存在',
    'about to delete' => '你将删除',
    'about to move' => '你将移动',
    
    // Success
    'success add project' => '项目 %s 已经被成功添加',
    'success copy project' => '项目 %s 已经被复制为 %s',
    'success edit project' => '项目 %s 已被更新',
    'success delete project' => '项目 %s 已被删除',
    'success complete project' => '项目 %s 以被完成',
    'success open project' => '项目 %s 已被重新开放',
    'success edit project logo' => '项目图标已被更新',
    'success delete project logo' => '项目图标已被删除',
    
    'success add milestone' => '里程碑 \'%s\' 已经被成功添加',
    'success edit milestone' => '里程碑 \'%s\' 已被更新',
    'success deleted milestone' => '里程碑 \'%s\' 已被删除',

    'success add time' => '时间 \'%s\' 已经被成功添加',
    'success edit time' => '时间 \'%s\' 已被更新',
    'success deleted time' => '时间 \'%s\' 已被删除',
    
    'success add message' => '消息 %s 已经被成功添加',
    'success edit message' => '消息 %s 已被更新',
    'success deleted message' => '消息 \'%s\' 和它所有相关评论已被删除',
    
    'success add comment' => '评论已经被成功发表',
    'success edit comment' => '评论已经被成功更新',
    'success delete comment' => '评论已经被成功删除',
    
    'success add task list' => '任务清单 \'%s\' 已被添加',
    'success edit task list' => '任务清单 \'%s\' 已被更新',
    'success copy task list' => '任务清单 \'%s\' 被复制为 \'%s\' 带着 %s 个任务',
    'success move task list' => '任务清单 \'%s\' 被从 \'%s\' 项目中移动到 \'%s\'项目中',
    'success delete task list' => '任务清单 \'%s\' 已被删除',
    
    'success add task' => '所选的任务已被添加',
    'success edit task' => '所选的任务已被更新',
    'success delete task' => '所选的任务已被删除',
    'success complete task' => '所选的任务已完成',
    'success open task' => '所选的任务已开放',
    'success n tasks updated' => '%s 个任务已被更新',
     
    'success add client' => '客户公司 %s 已被添加',
    'success edit client' => '客户公司 %s 已被更新',
    'success delete client' => '客户公司 %s 已被删除',
    
    'success edit company' => '公司数据已被更新',
    'success edit company logo' => '公司图标已被更新',
    'success delete company logo' => '公司图标已被删除',
    
    'success add user' => '用户 %s 已被添加',
    'success edit user' => '用户 %s 已被更新',
    'success delete user' => '用户 %s 已被删除',
    
    'success update project permissions' => '项目的全新已被更新',
    'success remove user from project' => '用户已被从这个项目中删除',
    'success remove company from project' => '公司已被从这个项目中删除',
    
    'success update profile' => '用户资料已被更新',
    'success edit avatar' => '头像已被更新',
    'success delete avatar' => '头像已被删除',
    
    'success hide welcome info' => '欢迎信息框已被隐藏',
    
    'success complete milestone' => '里程碑 \'%s\' 已被完成',
    'success open milestone' => '里程碑 \'%s\' 已被重新开放',
    
    'success subscribe to message' => '你已成功地订阅了这个消息',
    'success unsubscribe to message' => '你已成功地解除了这个消息的订阅',
   
    'success add project form' => '表单 \'%s\' 已被添加',
    'success edit project form' => '表单 \'%s\' 已被更新',
    'success delete project form' => '表单 \'%s\' 已被删除',
    
    'success update config category' => '%s 配置值已被更新',
    'success forgot password' => '你的密码被用邮件发出',
    
    'success test mail settings' => '测试邮件被成功地发送',
    'success massmail' => '邮件被发送',
    
    'success update company permissions' => '公司权限信息 %s 已被更新',
    'success user permissions updated' => '用户权限已被更新',
    
    // Failures
    'error form validation' => '由于某些属性数据不合法，对象保存失败',
    'error delete owner company' => '所属公司不能被被删除',
    'error delete message' => '所选消息删除失败',
    'error update message options' => '更新消息选项失败',
    'error delete comment' => '所选评论删除失败',
    'error delete milestone' => '所选里程碑删除失败',
    'error delete time' => '所选时间删除失败',
    'error complete task' => '所选任务标记完成失败',
    'error open task' => '所选任务重新开放失败',
    'error delete project' => '所选项目删除失败',
    'error complete project' => '所选项目标记完成失败',
    'error open project' => '所选项目重新开放失败',
    'error edit project logo' => '项目图标更新失败',
    'error delete project logo' => '项目图标删除失败',
    'error delete client' => '所选客户公司删除失败',
    'error delete user' => '所选用户删除失败',
    'error update project permissions' => '项目权限更新失败',
    'error remove user from project' => '从项目中删除用户失败',
    'error remove company from project' => '从项目中删除公司失败',
    'error edit avatar' => '更新头像失败',
    'error delete avatar' => '删除头像失败',
    'error hide welcome info' => '隐藏欢迎信息失败',
    'error complete milestone' => '所选里程碑标记完成失败',
    'error open milestone' => '所选里程碑重新开放失败',
    'error edit company logo' => '公司图标更新失败',
    'error delete company logo' => '公司图标删除失败',
    'error subscribe to message' => '订阅所选消息失败',
    'error unsubscribe to message' => '取消订阅所选消息失败',

    'error delete task list' => '所选任务清单删除失败',
    'error delete task' => '所选任务删除失败',
    'error delete category' => '所选分类删除失败',
    'error check for upgrade' => '检查新版本失败',
    'error test mail settings' => '发送测试消息失败',
    'error massmail' => '发送邮件失败',
    'error owner company has all permissions' => '所属公司具有所有权限',
    
    // Access or data errors
    'no access permissions' => '你没有权限访问所请求的页面',
    'invalid request' => '无效的请求!',
    
    // Confirmation
    'confirm delete message' => '你确定要删除这个消息?',
    'confirm delete milestone' => '你确定要删除这个里程碑?',
    'confirm delete task list' => '你确定要删除这个任务清单和它的所有任务?',
    'confirm delete task' => '你确定要删除这个任务?',
    'confirm delete comment' => '你确定要删除这个评论?',
    'confirm delete category' => '你确定要删除这个分类?',
    'confirm delete project' => '你确定要删除这个项目和它的所有数据(消息, 任务, 里程碑, 文件...)?',
    'confirm delete project logo' => '你确定要删除这个图标?',
    'confirm complete project' => '你确定要把这个项目标记完成? 所有项目活动将被锁定',
    'confirm open project' => '你确定要把这个项目标记开放? 这会把所有项目活动解锁',
    'confirm delete client' => '你确定要把所选客户公司和它的所有用户都全部删除?',
    'confirm delete user' => '你确定要把这个用户账号删除?',
    'confirm reset people form' => '你确定要把这个表单重置? 你做的所有修改将丢失!',
    'confirm remove user from project' => '你确定要把这个用户从项目中删除?',
    'confirm remove company from project' => '你确定要把这个公司从项目中删除?',
    'confirm logout' => '你确定要从系统中退出?',
    'confirm delete current avatar' => '你确定要把此头像删除?',
    'confirm delete company logo' => '你确定要把此公司图标删除?',
    'confirm subscribe' => '你确定要订阅此消息? 你想在除你之外的人对此消息评论的时候收到通知邮件',
    'confirm reset form' => '你确定要重置这个表单?',
    
    // Errors...
    'system error message' => '抱歉，但是有个错误导致你的请求无法执行。一个错误报告已被发给了系统管理员',
    'execute action error message' => '抱歉，但是ProjectPier现在无法执行你的请求。一个错误报告已被发给了系统管理员',
    
    // Log
    'log add projectmessages' => '\'%s\' 已被添加',
    'log edit projectmessages' => '\'%s\' 已被更新',
    'log delete projectmessages' => '\'%s\' 已被删除',
    
    'log add comments' => '%s 已被添加',
    'log edit comments' => '%s 已被更新',
    'log delete comments' => '%s 已被删除',
    
    'log add projectmilestones' => '\'%s\' 已被添加',
    'log edit projectmilestones' => '\'%s\' 已被更新',
    'log delete projectmilestones' => '\'%s\' 已被删除',
    'log close projectmilestones' => '\'%s\' 已完成',
    'log open projectmilestones' => '\'%s\' 已重新开放',

    'log add projecttimes' => '\'%s\' 已被添加', 
    'log edit projecttimes' => '\'%s\' 已被更新',
    'log delete projecttimes' => '\'%s\' 已被删除',
    
    'log add projecttasklists' => '\'%s\' 已被添加',
    'log edit projecttasklists' => '\'%s\' 已被更新',
    'log delete projecttasklists' => '\'%s\' 已被删除',
    'log close projecttasklists' => '\'%s\' 已被关闭',
    'log open projecttasklists' => '\'%s\' 已被开放',
    
    'log add projecttasks' => '\'%s\' 已被添加',
    'log edit projecttasks' => '\'%s\' 已被更新',
    'log delete projecttasks' => '\'%s\' 已被删除',
    'log close projecttasks' => '\'%s\' 已被关闭',
    'log open projecttasks' => '\'%s\' 已被开放',
  
    'log add projectforms' => '\'%s\' 已被添加',
    'log edit projectforms' => '\'%s\' 已被更新',
    'log delete projectforms' => '\'%s\' 已被删除',
  
    'log add projects' => '%s 已被添加',
  ); // array

?>