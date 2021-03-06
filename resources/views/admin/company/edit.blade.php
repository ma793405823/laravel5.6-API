<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>编辑公司</title>
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
  
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form" method="post">
            <input type="hidden" name="id" value="{{$list->id}}"/>
            {{ csrf_field() }}
        <div class="layui-form-item">
              <label for="L_companyname" class="layui-form-label">
                  <span class="x-red">*</span>公司名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_companyname" name="name" value="{{$list->name}}" required="" lay-verify="name" autocomplete="off" class="layui-input">
              </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">公司负责人</label>
                <div class="layui-input-inline">
                    <select name="company" lay-verify="company">
                        @if(isset($admin) && !empty($admin))
                            <option value="0">--请选择公司负责人--</option>
                            @foreach($admin as $v)
                                <option value="{{$v->id}}" @if($v->id == $list->admin_id) selected="selected" @endif>{{$v->admin_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
          <label for="L_desc" class="layui-form-label">
             公司描述
          </label>
          <div class="layui-input-inline">
              <input type="text" id="L_desc" name="desc" value="{{$list->desc}}" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
             <label for="L_repass" class="layui-form-label">
             </label>
             <button  class="layui-btn" lay-filter="edit" lay-submit="submit">
                 保存
             </button>
        </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          //自定义验证规则
          form.verify({
            name: function(value){
                if(value == null || value == ''){
                    return '公司名称必填';
                }
            // },
            // company: function(value){
            //     if(value == null || value == ''){
            //         return '部门负责人必选';
            //     }
            }
          });
          //监听提交
          form.on('submit(edit)', function(data){
              token   = $("input[name='_token']").val();
              $.ajax({
                  url:"{{route('admin.company.saveCompany')}}",
                  type:"post",
                  data:{name:data.field.name,company:data.field.company,desc:data.field.desc,id:data.field.id,_token:token},
                  dataType:"json",
                  success:function (data) {
                      if(data.code == 200){
                          alert(data.msg);
                          parent.location.href = "{{route('admin.company.list')}}";
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
        });
    </script>
  </body>
</html>