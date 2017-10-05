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


  <form class="am-form" accept="" method="post" id="addpassform">
  <fieldset>

    <div class="am-form-group">
      <label for="name">密码名称</label>
      <input type="text" name="name" id="name" placeholder="密码名称" value="<?php echo ($pass['name']); ?>">
    </div>

    <div class="am-form-group">
      <label for="username">用户名</label>
      <input type="hidden" name="pid" value="<?php echo ($pass['uuid']); ?>">
      <input type="text" name="username" id="username" placeholder="用户名" value="<?php echo ($pass['username']); ?>">
    </div>

    <div class="am-form-group">
      <label for="doc-ipt-pwd-1">密码</label>
      <input type="text" name="password" id="doc-ipt-pwd-1" placeholder="设置个密码吧" value="<?php echo ($pass['real']); ?>" onkeydown="CheckIntensity($(this).val())">
      <div class="am-progress passinfo" style="margin-bottom: 0" id="qazppp">
                    
      </div>
    </div>

    <div class="am-form-group">
      <label for="doc-ta-1">备注说明</label>
      <textarea rows="5" name="remark" id="doc-ta-1"><?php echo ($pass['remark']); ?></textarea>
    </div>

    <p><button type="submit" style="width: 100%;" class="am-btn am-btn-primary">修 改</button></p>
  </fieldset>
</form>

<script src="/pass/Public/js/jquery.min.js"></script>
<script src="/pass/Public/js/amazeui.min.js"></script>
  <script src="/pass/Public/layer_mobile/layer.js"></script>

  <script type="text/javascript">
    CheckIntensity('<?php echo ($pass['real']); ?>');
    function CheckIntensity(string) {
      if(string.length >=6) {
        if(/[a-zA-Z]+/.test(string) && /[0-9]+/.test(string) && /\W+\D+/.test(string)) {
          var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>\
                    <div class="am-progress-bar am-progress-bar-secondary"  style="width: 33%">中</div>\
                    <div class="am-progress-bar am-progress-bar-success"  style="width: 34%">强</div>';
        }else if(/[a-zA-Z]+/.test(string) || /[0-9]+/.test(string) || /\W+\D+/.test(string)) {
          if(/[a-zA-Z]+/.test(string) && /[0-9]+/.test(string)) {
            var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>\
                    <div class="am-progress-bar am-progress-bar-secondary"  style="width: 33%">中</div>';
          }else if(/\[a-zA-Z]+/.test(string) && /\W+\D+/.test(string)) {
            var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>\
                    <div class="am-progress-bar am-progress-bar-secondary"  style="width: 33%">中</div>';
          }else if(/[0-9]+/.test(string) && /\W+\D+/.test(string)) {
            var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>\
                    <div class="am-progress-bar am-progress-bar-secondary"  style="width: 33%">中</div>';
          }else{
            var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>';
          }
        }
      }else if(string.length>0 && string.length<6){
        var html='<div class="am-progress-bar am-progress-bar-warning" style="width: 33%">弱</div>';
      }else{
        var html='';
      }
      $("#qazppp").html(html);
      return html;
    }
    $("#addpassform").submit(function(){
      $.ajax({
        url: '/pass/index.php/index/updatepasses/pid/59d18da666d72.html',
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