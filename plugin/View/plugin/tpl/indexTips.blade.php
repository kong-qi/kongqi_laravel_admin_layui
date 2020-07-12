@if(isset($index_list_tips) && !empty($index_list_tips))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {!! $index_list_tips !!}
        <button type="button" class="  close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif