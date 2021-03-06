<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>密码管理器登录</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <link rel="apple-touch-icon-precomposed" href="/pass/Public/images/favicon.ico">
  <link rel="shortcut icon" href="/pass/Public/images/favicon.ico">
  <link rel="icon" type="image/png" href="/pass/Public/images/favicon.ico">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="/pass/Public/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <img src="/pass/Public/images/logo.png" style="width: 70%;">
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <form method="post" class="am-form" id="login_form">
      <label for="email">邮箱:</label>
      <input type="email" name="email" id="email" value="" placeholder="请输入正确的邮箱">
      <br>
      <label for="code">验证码:</label>
      <div class="am-input-group">
      <input type="text" class="am-form-field" id="code" name="code" value="" autocomplete="off" placeholder="请输入邮箱验证码">
      <span class="am-input-group-btn">
        <button class="am-btn am-btn-primary" type="button" id="sendCodeButton">发送验证码</button>
      </span>
    </div>
    <br>
      <label for="password">密码:</label>
      <input type="password" name="password" id="password" value="" placeholder="请输入登录密码">
      <br>
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm" style="width: 100%;">
      </div>
      <hr>
      <div style="text-align: center;">
        还没注册？
      <a href="/pass/index.php/index/register">前往注册</a>
      </div>
    </form>
    <hr>
  </div>
</div>
  <script src="/pass/Public/js/jquery.min.js"></script>
  <script src="/pass/Public/layer_mobile/layer.js"></script>
  <script type="text/javascript">
    // 发送验证码
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

      /**
       * 登录
       */
      $("#login_form").submit(function(){
        layer.open({
          type: 2
          ,content: '登录中'
        });
        var email=$('input[name="email"]').val();
        var pass=$('input[name="password"]').val();
        var code=$('input[name="code"]').val();
        $.ajax({
          url: '/pass/index.php/index/login',
          type: 'POST',
          dataType: 'json',
          data: {email: email,pass:pass,code:code},
        })
        .done(function(res) {
          layer.closeAll();
          if(res.status){
          	  layer.open({
      			    content: res.msg
      			    ,skin: 'msg'
      			    ,time: 2 //2秒后自动关闭
      			  });
            window.location.href='<?php echo U("index/index");?>';
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
        })
        .always(function() {

        });

        return false;
      });
  </script>
</body>
</html>