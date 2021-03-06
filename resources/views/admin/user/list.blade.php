<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>员工列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="/">首页</a>
        <a href="{{route('admin.member.list')}}">员工管理</a>
        <a>
          <cite>员工列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" id="js-form" method="get" action="{{route('admin.member.list')}}">
          <input type="text" name="username"  value="{{$username}}" placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <div class="layui-input-inline" style="margin-top: -3px;">
            <select name="userstatus">
              <option value="">请选择值班</option>
              @foreach($status as $k => $v)
                  <option value="{{$k}}" @if($userstatus == $k) selected="selected" @endif>{{$v}}</option>
              @endforeach
            </select>
          </div>
          <input type="hidden" name="page" id="page" value="{{$list->currentPage()}}">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加员工','{{route('admin.member.add')}}',600,700)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>部门</th>
            <th>类型</th>
            <th>值班城市</th>
            <th>离职状态</th>
            <th>入职时间</th>
            <th>离职时间</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
          @foreach($list as $key => $user)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->user_name}}</td>
            <td>@if(!empty($user->depart)){{$user->depart}}@else <span style="color: red;">无</span> @endif</td>
            <td>
              @if($user->duty_type == 1)
                轮休
              @elseif($user->duty_type == 2)
                倒班
              @endif
            </td>
            <td>
                @if(empty($user->city))
                  无值班城市
                @else
                    @if(is_array($user->city) || is_object($user->city) )
                        @foreach($user->city as $v)
                            {{$v['city_name']}}
                        @endforeach
                    @endif
                @endif
            </td>
            <td>
              @if($user->is_del == 1)
                <span style="color: red;">已离职</span>
              @else
                正常
              @endif
            </td>
            <td>{{date('Y-m-d',$user->input_time)}}</td>
            <td>
              @if(($user->is_del == 1) || !empty($user->leve_time))
                {{date('Y-m-d',$user->leve_time)}}
              @else
                --
              @endif
            </td>
            <td class="td-manage">
              @if($user->is_del == 1)
                无法操作
              @else
                <a title="编辑"  onclick="x_admin_show('编辑{{$user->user_name}}的资料','{{route('admin.member.edit',['userid'=>$user->user_id])}}',700,600)" href="javascript:;">
                  <i class="layui-icon">&#xe642;</i>
                </a>
                <a title="查看考勤"  onclick="x_admin_show('查看{{$user->user_name}}的考勤','{{route('admin.member.records',['userid'=>$user->user_id])}}')" href="javascript:;">
                  <i class="layui-icon">&#xe705;</i>
                </a>
                <a title="删除" onclick="member_del(this,{{$user->user_id}},{{$user -> duty_type}})" href="javascript:;">
                  <i class="layui-icon">&#xe640;</i>
                </a>
                <a title="请假审批"  onclick="x_admin_show('查看{{$user->user_name}}的审批','{{route('admin.member.qingjia',['userid'=>$user->user_id])}}')" href="javascript:;">
                  @if(isset($user->is_pass) && $user->is_pass == 0)
                    <i class="layui-icon" style="color: red;">&#xe6b2;<span class="layui-badge-dot"></span></i>
                  @else
                    <i class="layui-icon">&#xe6b2;</i>
                  @endif
                </a>
              @endif

            </td>
          </tr>
          @endforeach()
        </tbody>
      </table>
      <div class="page">
          {{$list->links()}}
      </div>
    </div>
    <script>
        $(function () {
            $(".pagination").find("a").attr("href","javascript:void(0);");
            $(".pagination").find('a').click(function () {
                var str = $(this).text();
                var page = parseInt($("#page").val());
                if(str == "«"){
                    $("#page").val(page-1);
                }else if(str == "»"){
                    $("#page").val(page+1);
                }else{
                    $("#page").val($(this).text());
                }
                $("#js-form").submit();
            })
        })

      /*用户-删除*/
      function member_del(obj,id,duty_type){
          layer.confirm('确认要删除吗並且將其本月的排班以及下班的排班刪除？',function(index){
              //发异步删除数据
              $.ajax({
                  url:"{{route('admin.member.del')}}",
                  type:"get",
                  data:{id:id,duty_type:duty_type},
                  dataType:"json",
                  success:function (data) {
                      if(data.code == 200){
                          alert(data.msg);
                          window.location.href = "{{route('admin.member.list')}}";
                      }else{
                          alert(data.msg);
                          return false;
                      }
                  },
                  error:function (err) {
                      console.log(err);
                  }
              });
          });
      }
    </script>
  </body>
</html>