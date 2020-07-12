@if(!empty($user_list))
    @foreach($user_list as $k=>$v)
        <li class="media align-items-center border-bottom mt-2">
            <img width="40" src="{{ $v->thumb }}"
                 class="mr-3 rounded" alt="{{ $v->name }}">
            <div class="media-body">
                <h5 class="mt-0 mb-1 "><a href="{{ proute('blog.userPage',['id'=>$v->id]) }}">{{ $v->name }} </a>
                </h5>
                <p class="text-muted">注册时间: {{ $v->created_at->diffForHumans() }}</p>
            </div>

        </li>
    @endforeach
@endif