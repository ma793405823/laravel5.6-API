<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>新增省份</title>
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
            {{ csrf_field() }}
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>省份
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_username" name="cityname" required="" lay-verify="cityname" autocomplete="off" class="layui-input" placeholder="请输入中国省份....">
              </div>
          </div>
          <div class="layui-form-item">
            <label for="L_workernum" class="layui-form-label">
               <span class="x-red">*</span>值班人数
            </label>
            <div class="layui-input-inline">
              <input type="number" id="L_workernum" name="workernum" required="" lay-verify="workernum" autocomplete="off" class="layui-input" placeholder="请输入最少值班人数...">
            </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="submit">
                  增加
              </button>
          </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          //验证
            form.verify({
                cityname: function(value){
                    if(value == null || value == ''){
                        return '省份名称必填';
                    }
                },
                workernum: function(value){
                    if(value == null || value == ''){
                        return '值班人数必填';
                    }
                }
            });
          //监听提交
          form.on('submit(add)', function(data){
              token   = $("input[name='_token']").val();
              $.ajax({
                  url:"{{route('admin.city.addCity')}}",
                  type:"post",
                  data:{cityname:data.field.cityname,workernum:data.field.workernum,_token:token},
                  dataType:"json",
                  success:function (data) {
                      if(data.code == 200){
                          alert(data.msg);
                          parent.location.href = "{{route('admin.city.list')}}";
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