<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>密码管理器注册</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta name="format-detection" content="telephone=no">
  <link rel="apple-touch-icon-precomposed" href="/pass/Public/images/favicon.ico">
  <link rel="shortcut icon" href="/pass/Public/images/favicon.ico">
  <link rel="icon" type="image/png" href="/pass/Public/images/favicon.ico">
  <meta name="renderer" content="webkit">
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
      <input type="email" name="email" id="email" value="" placeholder="请输入正确的邮箱" onchange="checkEmail($(this).val())">
      <br>
      <label for="code">验证码:</label>
      <div class="am-input-group">
      <input type="text" class="am-form-field" id="code" name="code" value="" autocomplete="off" placeholder="请输入邮箱验证码">
      <span class="am-input-group-btn">
        <button class="am-btn am-btn-primary" disabled="disabled" type="button" id="sendCodeButton">发送验证码</button>
      </span>
    </div>
    <br>
      <label for="key">加密密钥:</label>
      <input type="password" name="key" id="key" value="" placeholder="请输入密码加密密钥">

    <br>
      <label for="password">密码:</label>
      <input type="password" name="password" id="password" value="" placeholder="请输入登录密码">
      <br>
      <label for="rpassword">确认密码:</label>
      <input type="password" name="rpassword" id="rpassword" value="" placeholder="请输入登录密码">
      <br>
      <div class="am-cf">
        <input type="submit" name="" value="注 册" disabled="disabled" class="am-btn am-btn-primary am-btn-sm" style="width: 100%;">
      </div>
      <hr>
      <div style="text-align: center;">
        已经注册？
      <a href="/pass/index.php/index/login">前往登录</a>
      </div>
    </form>
    <hr>
  </div>
</div>
  <script src="/pass/Public/js/jquery.min.js"></script>
  <script src="/pass/Public/layer_mobile/layer.js"></script>
  <style type="text/css">
    .layui-m-layercont{
      text-align: left!important;
    }
  </style>
  <script type="text/javascript">
    // 弹框弹出时背景不能滚动
    $('html,body').css({
      height: '100%',
      overflow: 'hidden'
    });
    layer.open({
      content: '本密码管理系统做了一下安全措施：<br>1，每个人可以设置自己独一无二的密钥来加密密码，并且密钥经过加密保存的。<br>2：登录使用邮箱验证，需要您登录邮箱获取临时验证码才可登录。<br>3：登录通知功能，如果不是本人登录，立马通知您修改密码',
      btn: '我知道了',
      shadeClose: false,
      yes: function(){
        $('html,body').css({
          height: '',
          overflow: ''
        });
        layer.closeAll();
      }
    });
    // 检查邮箱
    function checkEmail(email){
      $.post('/pass/index.php/index/checkEmail', {email: email}, function(res) {
        if(!res.status){
          layer.open({
            content:res.msg,
            btn:'我知道了'
          });
          $("#sendCodeButton").attr('disabled', 'disabled');
          $("input[type='submit']").attr('disabled', 'disabled');
        }else{
          layer.open({
            content:res.msg,
            skin:'msg',
            time:2
          });
          $("#sendCodeButton").removeAttr('disabled');
          $("input[type='submit']").removeAttr('disabled');
        }
      });
    }
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
       * 注册
       */
      $("#login_form").submit(function(){
        var email=$('input[name="email"]').val();
        var pass=$('input[name="password"]').val();
        var rpass=$('input[name="rpassword"]').val();
        var code=$('input[name="code"]').val();
        var key=$('input[name="key"]').val();
        if(pass!=rpass){
          layer.open({
              content: '两次密码不一样'
              ,btn: '我知道了'
            });
          return false;
        }
        if(key.length<6){
          layer.open({
            content: '密钥太短！'
            ,btn: '我知道了'
          });
          return false;
        }
        $.ajax({
          url: '/pass/index.php/index/register',
          type: 'POST',
          dataType: 'json',
          data: {email: email,pass:pass,code:code,key:key},
        })
        .done(function(res) {
          if(res.status){
          	 layer.open({
              content: res.msg
              ,btn: ['去登陆', '不登录']
              ,yes: function(index){
                window.location.href='<?php echo U("index/login");?>';
                layer.close(index);
              }
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
        })
        .always(function() {

        });

        return false;
      });
  </script>
</body>
</html>