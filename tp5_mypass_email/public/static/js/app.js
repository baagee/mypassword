/**
 * Created by BaAGee on 2017/10/4.
 */

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



/**
 * 密码列表筛选过滤
  */
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

/**
 * 验证密码强度
 * @param string
 * @returns {string|string|string|string}
 * @constructor
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
    //表单
    $("#qazppp").html(html);
    return html;
}


// 检查邮箱
function checkEmail(email){
    $.post('/index/checkemail', {email: email}, function(res) {
        if(!res.status){
            layer.open({
                content:res.msg,
                btn:'我知道了'
            });
            $("#sendCodeButton").attr('disabled', 'disabled');
            $("input[type='submit']").attr('disabled', 'disabled');
            $("#changeemailsubmit").attr('disabled', 'disabled');
        }else{
            layer.open({
                content:res.msg,
                skin:'msg',
                time:2
            });
            $("#sendCodeButton").removeAttr('disabled');
            $("input[type='submit']").removeAttr('disabled');
            $("#changeemailsubmit").removeAttr('disabled');
        }
    });
}

/**
 * 发送验证码
  */
$("#sendCodeButton").bind('click','',function(){
    layer.open({
        type: 2
        ,content: '发送中'
    });
    $.ajax({
            url: '/index/sendcode',
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
$("#register_form").submit(function(){
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
            url: '/user/register',
            type: 'POST',
            dataType: 'json',
            data: {email: email,password:pass,code:code,key:key},
        })
        .done(function(res) {
            if(res.status){
                layer.open({
                    content: res.msg
                    ,btn: ['去登陆', '不登录']
                    ,yes: function(index){
                        window.location.href='/user/login.html';
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
            url: '/user/login',
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
                window.location.href='/pass/index';
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

/**
 * 添加密码
 */
$("#addpassform").submit(function(){
    $('button[type="submit"]').attr('disabled', 'disabled');
    $.ajax({
            url: '/pass/add',
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
                $("#addpassform")[0].reset();
                CheckIntensity('');
            }else{
                layer.open({
                    content: res.msg
                    ,btn: '我知道了'
                });
            }
        })
        .fail(function() {
            layer.open({
                content: '未知原因错误'
                ,btn: '我知道了'
            });
            console.log("error");
        })
        .always(function() {
            $('button[type="submit"]').removeAttr('disabled');
        });

    return false;
});


// 删除密码
function deleteThis(pid){
    layer.open({
        content: '您确定要删除这个密码吗？'
        ,btn: ['删除', '不要']
        ,yes: function(index){
            layer.close(index);
            $.ajax({
                    url: '/pass/delete',
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

/**
 * 密码编辑保存
 */
$("#editpassform").submit(function(){
    $.ajax({
            url: '/pass/editsave',
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
            url: '/user/set',
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
            url: '/user/set',
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
 * 修改邮箱
 */
$("#updateemailform").submit(function(){
    $.ajax({
            url: '/user/set',
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