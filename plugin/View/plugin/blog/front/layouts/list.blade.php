@if(!empty($list))
    @forelse($list as $k=>$v)
        <div class="blog-post">
            <h2 class="blog-post-title "><a href="{{ proute('blog.show',['id'=>$v->id]) }}">{{ $v['name'] }}</a></h2>
            <p class="blog-post-meta">{{ $v->created_at->diffForHumans() }} <a href="{{ proute('blog.userPage',['id'=>$v->user_id]) }}">{{ $v['user']['name'] }}</a></p>
            {!! clean($v['content']) !!}
        </div>

    @empty
        <div class="text-muted">
            空空如也
        </div>
    @endforelse
@endif
<div class="page">
  {!! $page !!}
</div>