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


<section data-am-widget="accordion" class="am-accordion am-accordion-gapped" data-am-accordion='{  }'>
	<div class="am-alert am-alert-success" data-am-alert>
		<button type="button" class="am-close">&times;</button>
		<p><?php echo ($info); ?></p>
	</div>
      <input type="text" class="am-form-field" name="name" autocomplete="off" onkeyup="filter($(this).val())" placeholder="输入关键字筛选过滤">
    <hr>
    <?php if(is_array($pass)): foreach($pass as $key=>$pa): ?><dl class="am-accordion-item" id="dhdfvs_<?php echo ($pa['uuid']); ?>">
        <dt class="am-accordion-title">
          <?php echo ($pa['name']); ?> 
        </dt>
        <dd class="am-accordion-bd am-collapse">
          <div class="am-accordion-content">
            <table class="am-table am-table-bordered">
              <tr>
                <td style="width: 28%">用户名</td>
                <td class="usernameiiiiiii" data-clipboard-text='<?php echo ($pa['username']); ?>'><?php echo ($pa['username']); ?></td>
              </tr>
              <tr>
                <td style="width: 28%">密码</td>
                <td class="passiiiii" style="word-break:break-all; word-wrap:break-word;" data-clipboard-text='<?php echo ($pa['real']); ?>'><?php echo ($pa['real']); ?></td>
              </tr>
              <tr>
                <td style="width: 28%">密码强度</td>
                <td>
                  <div class="am-progress passinfo" style="margin-bottom: 0">
                    
                  </div>
                </td>
              </tr>
            </table>
            <div class="am-panel am-panel-default">
                  <div class="am-panel-bd">
                    备注：<?php echo ($pa['remark']); ?>
                    <br>
                    时间：<?php echo (date('Y-m-d H:i:s',$pa['create_time'])); ?>
                  </div>
              </div>
              <!-- 操作 -->
              <div class="am-btn-group" style="width: 100%">
              <button type="button" onclick="deleteThis('<?php echo ($pa['uuid']); ?>')" class="am-btn am-btn-danger am-radius" style="width: 50%">删除</button>
              <a href="<?php echo U('index/updatePasses',array('pid'=>$pa['uuid']));?>" class="am-btn am-btn-success am-radius" style="width: 50%">修改</a>
            </div>
          </div>
        </dd>
      </dl><?php endforeach; endif; ?>
  </section>

<script src="/pass/Public/js/jquery.min.js"></script>
<script src="/pass/Public/js/amazeui.min.js"></script>
  <script src="/pass/Public/layer_mobile/layer.js"></script>

  <script src='/pass/Public/js/jquery.cookie.js'></script>
  <script src="/pass/Public/js/clipboard.min.js"></script>
  <script type="text/javascript">
    
  	// 列表筛选过滤
  	function filter(keyword){
  		keyword=keyword.toUpperCase();
  		var titles=$(".am-accordion-title");
  		$.each(titles,function(index,item){
			  if($(item).text().toUpperCase().indexOf(keyword) > -1){
          $(item).parent().css('display', '');
        }else{
          $(item).parent().css('display', 'none');
        } 
  		})
	  }

    // 首次提示框
    if($.cookie('showInfo')!=1){
    	// 弹框弹出时背景不能滚动
	    $('html,body').css({
	      height: '100%',
	      overflow: 'hidden'
	    });
  	  layer.open({
  	    content: '温馨提示：<br>点击用户名，密码即可快速复制哦!<br>部分手机浏览器不支持快速复制！'
  	    ,btn: '明白了，不再提示'
  	    ,yes: function(index){
  	      $.cookie('showInfo',1,{expires:30*3600*24*12*50});
  	      layer.close(index);
  	    }
  	    ,end:function(){
  	      $('html,body').css({
  	        height: '',
  	        overflow: ''
  	      });
  	    }
  	  });
    }
    
    // 密码强度检测
    $(function(){
      $.each($(".passiiiii"),function(index,item){
        $($(".passinfo")[index]).html(CheckIntensity($(item).text()));
      })
    });

    /**
     * 检验密码长度
     */
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
      return html;
    }

    // 点击复制
    var clipboard_pass = new Clipboard('.passiiiii');
    var clipboard_user = new Clipboard('.usernameiiiiiii');
    clipboard_pass.on('success', function(e) {
      layer.open({
        content:'密码复制成功!',
        skin:'msg',
        time:2
      })
    });
    clipboard_user.on('success', function(e) {
      layer.open({
        content:'用户名复制成功!',
        skin:'msg',
        time:2
      })
    });
    clipboard_pass.on('error', function(e) {
      layer.open({
        content:'密码复制失败!',
        skin:'msg',
        time:2
      })
    });
    clipboard_user.on('error', function(e) {
      layer.open({
        content:'用户名复制失败!',
        skin:'msg',
        time:2
      })
    });


    // 删除密码
    function deleteThis(pid){
      layer.open({
        content: '您确定要删除这个密码吗？'
        ,btn: ['删除', '不要']
        ,yes: function(index){
          layer.close(index);
          $.ajax({
            url: '/pass/index.php/index/deletepass',
            type: 'POST',
            dataType: 'json',
            data: {'pid': pid},
          })
          .done(function(res) {
            if(res.status){
              $("#dhdfvs_"+pid).remove();
              $("#passcount").text(parseInt($("#passcount").text())-1);
              layer.open({
                content: res.msg
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
              });
            }else{
              layer.open({
                content: res.msg
                ,btn:'我知道了'
              });
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
        }
      });
    }
  </script>

</body>
</html>