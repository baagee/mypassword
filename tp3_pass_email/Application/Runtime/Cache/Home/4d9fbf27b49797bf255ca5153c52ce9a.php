<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ($title); ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="apple-touch-icon-precomposed" href="/pass/Public/images/favicon.ico">
  <link rel="shortcut icon" href="/pass/Public/images/favicon.ico">
  <link rel="icon" type="image/png" href="/pass/Public/images/favicon.ico">
  <link rel="stylesheet" href="/pass/Public/css/amazeui.min.css">
  
</head>
<body>
<!-- Header -->
<header data-am-widget="header" class="am-header am-header-default">
  <h1 class="am-header-title">
    <a href="#title-link"><?php echo ($title); ?></a>
  </h1>
</header>

<!-- Menu -->
<nav data-am-widget="menu" class="am-menu  am-menu-offcanvas1" data-am-menu-offcanvas>
  <a href="javascript: void(0)" class="am-menu-toggle">
    <i class="am-menu-toggle-icon am-icon-bars"></i>
  </a>
  <div class="am-offcanvas">
    <div class="am-offcanvas-bar" style="width: 50%">
      <img src="/pass/Public/images/avatar.png" style="width: 100%">
      <ul class="am-menu-nav sm-block-grid-1">

        <li>
      <a href="<?php echo U('index/index');?>">
        <!-- <span class="am-icon-home"></span> -->
        <i class="am-icon-list-alt"></i>
        <span class="am-navbar-label">查看密码</span>
      </a>
    </li>
    <li>
      <a href="<?php echo U('index/addPass');?>">
        <span class="am-icon-plus"></span>
        <span class="am-navbar-label">创建密码</span>
      </a>
    </li>
    <li>
      <li>
      <a href="<?php echo U('index/analyse');?>">
        <span class="am-icon-gear"></span>
        <span class="am-navbar-label">密码分析</span>
      </a>
    </li>
      <li>
      <a href="<?php echo U('index/personalset');?>">
        <span class="am-icon-gear"></span>
        <span class="am-navbar-label">个人设置</span>
      </a>
    </li>
    <li>
      <a href="<?php echo U('index/logout');?>">
        <span class="am-icon-sign-out"></span>
        <span class="am-navbar-label">退出登录</span>
      </a>
    </li>

      </ul>
      
<img src="/pass/Public/images/footimg.png" style="width: 100%;margin-bottom: 0;position: fixed;bottom: 10px">
    </div>
  </div>
</nav>


  <div data-am-widget="tabs"
       class="am-tabs am-tabs-d2"
        >
      <ul class="am-tabs-nav am-cf">
          <li class="am-active"><a href="[data-tab-panel-0]">修改密码</a></li>
          <li class=""><a href="[data-tab-panel-1]">修改密钥</a></li>
          <li class=""><a href="[data-tab-panel-2]">更换邮箱</a></li>
      </ul>
      <div class="am-tabs-bd">
          <div data-tab-panel-0 class="am-tab-panel am-active">
              <div class="am-alert am-alert-success" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                <p>修改密码管理器登录密码</p>
              </div>
              <form class="am-form" accept="" method="post" id="updatepassform">
                <fieldset>
                    <input type="hidden" name="usa" value="password">
                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-1">当前密码</label>
                    <input type="password" name="opassword" id="doc-ipt-pwd-1" placeholder="当前密码">
                  </div>
                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-2">新密码</label>
                    <input type="password" name="password" id="doc-ipt-pwd-2" placeholder="新密码">
                  </div>

                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-3">确认新密码</label>
                    <input type="password" name="rpassword" id="doc-ipt-pwd-3" placeholder="确认新密码">
                  </div>

                  <p><button type="submit" style="width: 100%;" class="am-btn am-btn-primary">修 改</button></p>
                </fieldset>
              </form>
          </div>
          <div data-tab-panel-1 class="am-tab-panel ">
            <div class="am-alert am-alert-success" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                <p>修改您的密钥，密钥不要告诉任何人</p>
              </div>
              <form class="am-form" accept="" method="post" id="updatekeyform">
                <fieldset>
                  <input type="hidden" name="usa" value="key">
                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-1">当前密钥</label>
                    <input type="text" readonly="readonly" name="oldkey" id="doc-ipt-pwd-1" placeholder="当前密钥" value="<?php echo ($realoldkey); ?>">
                  </div>
                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-2">新密钥</label>
                    <input type="text" name="key" id="doc-ipt-pwd-2" placeholder="请输入新密钥" value="">
                  </div>
                  <p><button type="submit" style="width: 100%;" class="am-btn am-btn-primary">修 改</button></p>
                </fieldset>
              </form>
          </div>
          <div data-tab-panel-2 class="am-tab-panel ">
            <div class="am-alert am-alert-success" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                <p>修改密码管理器登录邮箱</p>
              </div>
              <form class="am-form" accept="" method="post" id="updateemailform">
                <fieldset>
                  <input type="hidden" name="usa" value="email">
                  <div class="am-form-group">
                    <label for="oldemail">当前邮箱</label>
                    <input type="email" disabled="disabled" name="oldemail" id="oldemail" placeholder="当前邮箱" value="<?php echo session('user')[0]['email'];?>">
                  </div>
                  <div class="am-form-group">
                    <label for="doc-ipt-pwd-2">新邮箱</label>
                    <input type="email" name="email" id="doc-ipt-pwd-2" placeholder="新邮箱" value="" onchange="checkEmail($(this).val())">
                  </div>
                  <label for="code">验证码:</label>
                    <div class="am-input-group">
                    <input type="text" class="am-form-field" id="code" name="code" value="" autocomplete="off" placeholder="请输入邮箱验证码">
                    <span class="am-input-group-btn">
                      <button class="am-btn am-btn-primary" disabled="disabled" type="button" id="sendCodeButton">发送验证码</button>
                    </span>
                  </div>

                  <p><button type="submit" id="changeemailsubmit" style="width: 100%;" disabled="disabled" class="am-btn am-btn-primary">修 改</button></p>
                </fieldset>
              </form>
          </div>
      </div>
  </div>


<script src="/pass/Public/js/jquery.min.js"></script>
<script src="/pass/Public/js/amazeui.min.js"></script>
  <script src="/pass/Public/layer_mobile/layer.js"></script>

  <script type="text/javascript">
  	// 检查邮箱
    function checkEmail(email){
      $.post('/pass/index.php/index/checkEmail', {email: email}, function(res) {
        if(!res.status){
          layer.open({
            content:res.msg,
            btn:'我知道了'
          });
          $("#sendCodeButton").attr('disabled', 'disabled');
          $("#changeemailsubmit").attr('disabled', 'disabled');
        }else{
          layer.open({
            content:res.msg,
            skin:'msg',
            time:2
          });
          $("#sendCodeButton").removeAttr('disabled');
          $("#changeemailsubmit").removeAttr('disabled');
        }
      });
    }
    /**********************************************************************************
     * 修改密码
     */
    $("#updatepassform").submit(function(){
      if($('input[name="password"]').val().length<6){
        layer.open({
          content: '新密码太短！'
          ,btn: '我知道了'
        });
        return false;
      }
      if($('input[name="password"]').val()!=$('input[name="rpassword"]').val()){
        layer.open({
          content: '两次密码不一致'
          ,btn: '我知道了'
        });
        return false;
      }
      $.ajax({
        url: '/pass/index.php/index/personalset.html',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
      })
      .done(function(res) {
        if(res.status){
          layer.open({
            content: res.msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }else{
          layer.open({
            content: res.msg
            ,btn: '我知道了'
          });
        }
      })
      .fail(function() {
        layer.open({
          content: '未知原因出错'
          ,btn: '我知道了'
        });
        console.log("error");
      })
      .always(function() {
      });
      
      return false;
    });

    /**********************************************************************************
     * 修改密钥
     */
    $("#updatekeyform").submit(function(){
      if($('input[name="key"]').val().length<6){
        layer.open({
          content: '新密钥太短！'
          ,btn: '我知道了'
        });
        return false;
      }
      $.ajax({
        url: '/pass/index.php/index/personalset.html',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
      })
      .done(function(res) {
        if(res.status){
          layer.open({
            content: res.msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }else{
          layer.open({
            content: res.msg
            ,btn: '我知道了'
          });
        }
      })
      .fail(function() {
        layer.open({
          content: '未知原因出错'
          ,btn: '我知道了'
        });
        console.log("error");
      })
      .always(function() {
      });
      
      return false;
    });

    /**
     * 发送验证码
     */
    $("#sendCodeButton").bind('click','',function(){
      layer.open({
        type: 2
        ,content: '发送中'
      });
      $.ajax({
        url: '/pass/index.php/index/sendCode',
        type: 'POST',
        dataType: 'json',
        data: {'email':$("input[name='email']").val()},
      })
      .done(function(res) {
        layer.closeAll();
        if(res.status){
          layer.open({
            content:res.msg,
            skin:'msg',
            time:2
          });
        }else{
          layer.open({
            content:res.msg,
            btn:'我知道了'
          });
        }
      })
      .fail(function() {
        layer.open({
          content: '未知原因出错'
          ,btn: '我知道了'
        });
      })
      .always(function() {
        console.log("complete");
      });
      return false;
    });

    /**********************************************************************************
     * 修改邮箱
     */
    $("#updateemailform").submit(function(){
      $.ajax({
        url: '/pass/index.php/index/personalset.html',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
      })
      .done(function(res) {
        if(res.status){
          layer.open({
            content: res.msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }else{
          layer.open({
            content: res.msg
            ,btn: '我知道了'
          });
        }
      })
      .fail(function() {
        layer.open({
          content: '未知原因出错'
          ,btn: '我知道了'
        });
        console.log("error");
      })
      .always(function() {
      });
      
      return false;
    });
  </script>

</body>
</html>