@if(!isset($removeAdd) || $removeAdd!=1)
@acan($controller_blade_prefix.'create')
<button class="btn  btn-primary kongqi-handel" data-type="add"><i class="icon icon-add-1"></i> {{ lang('添加') }}</button>
@endacan
@endif
@if(!isset($removeDel)  || $removeDel!=1)
    @acan($controller_blade_prefix.'destroy')
    <button class="btn  kongqi-handel btn-danger" data-type="allDel"><i class="icon icon-close"></i> {{ lang('删除') }}
    </button>
    @endacan
@endif

