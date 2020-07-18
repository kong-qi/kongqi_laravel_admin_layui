@extends('admin.default.layouts.baseCont')
@section('content')

    <div class="mt-10 mr-10 ml-10 mb-10 upload-list-warp">
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">外链嵌入</li>
                <li>MP4外部</li>
                <li>本地上传</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <textarea rows="5" class="layui-textarea layui-video-coder" placeholder="嵌入视频代码"></textarea>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        @include('admin.default.tpl.form.imgInput',['form_item'=>[
                            'file_type'=>'image',
                            'field'=>'video_poster',
                            'value'=>'',
                            'tips'=>'视频封面图片',
                            'addClass'=>'upload-area-input layui-video-poster',
                            'up_attr'=>'data-file_type=image',
                            'place_attr'=>'data-file_type=image',
                        ]])
                    </div>
                    <div class="layui-form-item">
                        <textarea rows="5" class="layui-textarea layui-video-url" placeholder="嵌入视频链接mp4"></textarea>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="d-flex mb-10">

                        <form class="layui-form flex-1"
                              action="{{ admin_url('FileUpload','handle',['type'=>'list']) }}">
                            @if(!empty(request()->all()))
                                @foreach(request()->all() as $k=>$v)
                                    @if($k!='key')
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endif
                                @endforeach
                            @endif
                            <div class="d-flex">
                                <div class="flex-1">
                                    <input type="text" name="key" class="layui-input f14"
                                           placeholder="{{ lang('搜索视频名称') }}">
                                </div>
                                <div class="layui-block">
                                    <button class="layui-btn layui-btn-primary f14"
                                            style="border-radius: 0 2px 0 2px;margin-left: -2px" type="submit">
                                        <i class="layui-icon layui-icon-search "></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="ml-10">
                            <button class="layui-btn layui-btn-primary "
                                    data-target="#placeArea" data-group_id="{{ request()->input('group_id') }}"
                                    data-more="1"
                                    data-event="placeUpload"
                                    data-accept_type="{{ request()->input('accept_type','file') }}"
                                    data-file_type="{{ request()->input('file_type','file') }}">
                                <i class="layui-icon layui-icon-upload"></i> {{ lang('点击上传') }}
                            </button>
                        </div>
                    </div>
                    <div class="layui-row  layui-col-space15">

                        <div class="layui-col-xs12 layui-col-sm4">
                            <form action="" class="layui-form mb-10 d-flex">
                                <div class="flex-1">
                                    <input type="text" name="name" class="layui-input" lay-verify="rq"
                                           placeholder="{{ lang('新增分组名称') }}">
                                </div>
                                <div class="">
                                    <button class="layui-btn layui-btn-primary"
                                            style="border-radius: 0 2px 0 2px;margin-left: -2px" lay-submit
                                            lay-filter="addGroup" type="button">
                                        添加
                                    </button>
                                </div>

                            </form>
                            <div class="list-group  " id="listGroup" style="max-height: 340px;overflow-y: scroll">
                                <a class="list-group-item list-group-item-action {{ empty(request()->input('group_id'))?'active':'' }}"
                                   href="{{ admin_url('FileUpload','handle',array_merge(request()->all(),['type'=>'list','group_id'=>''])) }}">{{ lang('全部') }}</a>
                                @if(!empty($groups))
                                    @foreach($groups as $k=>$v)
                                        <a class="list-group-item list-group-item-action {{ $v['id']==request()->input('group_id')?'active':'' }}"
                                           href="{{ admin_url('FileUpload','handle',array_merge(request()->all(),['type'=>'list','group_id'=>$v['id']])) }}">{{ lang($v['name']) }}</a>
                                    @endforeach
                                @endif


                            </div>
                        </div>
                        <div class="layui-col-xs12 layui-col-sm8 " id="placeArea">
                            <div class="layui-form-item">
                                @include('admin.default.tpl.form.imgInput',['form_item'=>[
                                   'file_type'=>'image',
                                   'field'=>'video_poster2',
                                   'value'=>'',
                                   'tips'=>'视频封面图片',
                                   'addClass'=>'upload-area-input layui-video-poster',
                                   'up_attr'=>'data-file_type=image',
                                   'place_attr'=>'data-file_type=image',
                               ]])
                            </div>
                            <div class="file-choose-list upload-area-list">

                            </div>
                            <div class="w-100" id="page"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('foot_js')
    <script>
      layui.use(['uploader', 'verify', 'uform', 'request', 'listTable'], function () {
        var up = layui.uploader;
        var form = layui.uform;
        var req = layui.request;
        var verify = layui.verify;
        var listTable = layui.listTable;
        up.placeUpload('[data-event="placeUpload"]');
        var uploadListUrl = "{!!  admin_url('FileUpload','handle',array_merge(request()->all(),['type'=>'api']))  !!}";
        var onUrl = "{!! request()->getUri()  !!}";
        var isMore = "{{ request()->input('is_more') }}";


        //取得列表
        listTable.custom(".upload-area-list", uploadListUrl);


        //添加分组
        form.on('submit(addGroup)', function (data) {
          req.post('{{ route('admin.upload',['type'=>'addGroup']) }}', data.field, function (res) {
            var goUrl = '';
            goUrl = onUrl.replace(/\?group_id\=\d/g, '');
            goUrl = goUrl.replace(/\?group_id\=\d\&/g, '?');
            goUrl = goUrl.replace(/\&group_id\=\d/g, '');
            if (goUrl.indexOf("?") == -1) {
              goUrl += '?group_id=' + res.data.id;
            } else {
              goUrl += '&group_id=' + res.data.id;
            }
            if (res.code == 200) {
              $("#listGroup").append('<a  href="' + goUrl + '" class="list-group-item list-group-item-action" >' + res.data.name + '</a>');
            }
          })
          return false;

        });

        var picIndex = 1;
        $(document).on('click', '.upload-area-more-item', function () {

          if (isMore == 1) {
            $(this).toggleClass('active');
            $(this).find('.card').toggleClass('border-primary ');
            if ($(this).hasClass('active')) {
              $(this).attr('data-index', picIndex);
              picIndex++;
            } else {
              picIndex--
            }
            console.log($(this).find('.layui-form-checkbox').toggleClass('layui-form-checked'));

          } else {
            $(".upload-area-more-item .card").removeClass('border-primary');
            $(".upload-area-more-item ").removeClass('active');
            $(this).toggleClass('active');
            $(this).find('.card').toggleClass('border-primary ');
            $('.upload-area-more-item .layui-form-checkbox').removeClass('layui-form-checked');
            $(this).find('.layui-form-checkbox').toggleClass('layui-form-checked');

          }

        })


      });


      /*   $(".getImg").click(function () {
             var img = [];
             $(".upload-area-more-item.active").each(function () {
                 var json = {
                     index: $(this).data('index'),
                     img: $(this).find('img').attr('src'),
                     text: $(this).find('.card-title').text()
                 };
                 img.push(json);
             });
             img.sort(function (x, y) {
                 return x.index - y.index
             });
             console.log(img);
         })*/
    </script>

@endsection