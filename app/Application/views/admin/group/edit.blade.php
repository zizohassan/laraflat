@extends(layoutExtend())

@section('title')
    {{ trans('group.group') }} {{  isset($item) ? trans('curd.edit') : trans('curd.add') }}
@endsection

@section('content')
    @component(layoutForm(), ['title' => trans('group.group'), 'model'=>'group' , 'action' => isset($item) ? trans('curd.edit')  : trans('curd.add') ])
    @include(layoutMessage())
    <form action="{{ concatenateLangToUrl('admin/group/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" placeholder="{{ trans('group.name') }}" class="form-control" value="{{ isset($item) ? $item->name : old('name') }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="slug" id="name" placeholder="{{ trans('group.slug') }}" class="form-control" value="{{ isset($item) ? $item->slug : old('slug') }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                    <textarea  name="description" id="description" placeholder="{{ trans('group.des') }}" class="form-control">{{ isset($item) ? $item->description : old('description') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label for="">{{ trans('group.per_role') }}</label>
                    @php $roles = isset($data['roles_permission']) ? $data['roles_permission']->role->pluck('id')->all() : null @endphp
                    {!! Form::select('roles[]' , $data['roles'] , $roles, ['multiple' => true  , 'id' => 'roles' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label for="">{{ trans('group.permission') }}</label>
                    @php $permission = isset($data['roles_permission']) ? $data['roles_permission']->permission->pluck('id')->all()  : null @endphp
                    {!! Form::select('permission[]' , $data['permissions'] , $permission , ['multiple' => true , 'id' => 'permissions' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }} {{ trans('group.group') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection

@section('script')
    <script src="{{ url('/admin/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ url('/admin/js/search.js') }}"></script>
    <script>
        $('#roles').multiSelect(search("Role Name"));
        $('#permissions').multiSelect(search("Permission Name"));
        function search(name){
            return {
                selectableHeader: "<input type='text' class='form-control' autocomplete='off'  placeholder='"+name+"'>",
                selectionHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='"+name+"'>",
                afterInit: function(ms){
                    var that = this,
                            $selectableSearch = that.$selectableUl.prev(),
                            $selectionSearch = that.$selectionUl.prev(),
                            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                            .on('keydown', function(e){
                                if (e.which === 40){
                                    that.$selectableUl.focus();
                                    return false;
                                }
                            });
                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                            .on('keydown', function(e){
                                if (e.which == 40){
                                    that.$selectionUl.focus();
                                    return false;
                                }
                            });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            }
        }
    </script>
@endsection
