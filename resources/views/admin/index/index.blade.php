<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>忆享科技排班系统-后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('admin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>

</head>
<body>
<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="{{route('admin.index')}}">忆享科技</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">{{Session::get('username')}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                {{--<dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>--}}
                <dd><a href="{{route('admin.loginout')}}">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            @foreach($menus as $v)
                <li>
                    <a href="javascript:;">
                        <i class="iconfont">{{html_entity_decode($v->tip)}}</i>
                        <cite>{{$v->name}}</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    @if(isset($v->submenu) && (is_object($v->submenu) || is_array($v->submenu)) && !empty($v->submenu))
                        @foreach($v->submenu as $vv)
                            <ul class="sub-menu">
                                <li>
                                    <a _href="/{{$vv->mm}}/{{$vv->mc}}/{{$vv->ma}}">
                                        <i class="iconfont">&#xe6a7;</i>
                                        <cite>{{$vv->name}}</cite>
                                    </a>
                                </li >
                            </ul>
                        @endforeach
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{route('admin.welcome')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©<?php echo date('Y')?> 忆享科技排班后台管理系统</div>
</div>
<!-- 底部结束 -->
</body>
</html>