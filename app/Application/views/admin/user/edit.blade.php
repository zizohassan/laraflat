@extends(layoutExtend())

@section('title')
    {{ adminTrans('user' , 'user') }} {{  isset($item) ? adminTrans('curd' , 'edit')  : adminTrans('curd' , 'add') }}
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('/admin/plugins/multi-select/css/multi-select.css') }}">
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('user' , 'user')  , 'model' => 'user' , 'action' => isset($item) ? adminTrans('curd' , 'edit') : adminTrans('curd' , 'add') ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/user/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post">
            {{ csrf_field() }}
           <div class="form-group">
                <div class="form-line">
                  <label for="name">{{ adminTrans('user' , 'name') }}</label>
                    <input type="text" name="name" id="name" placeholder="{{ adminTrans('user' , 'name') }}" class="form-control" value="{{ isset($item) ? $item->name : old('name') }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                  <label for="username">{{ adminTrans('user' , 'username') }}</label>
                    <input type="text" name="username" id="username" placeholder="{{ adminTrans('user' , 'username') }}" class="form-control" value="{{ isset($item) ? $item->username : old('name') }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                  <label for="email">{{ adminTrans('user' , 'email') }}</label>
                     <input type="email" name="email" id="email" {{ isset($item) ? '' : 'required' }} placeholder="{{ adminTrans('user' , 'email') }}"  class="form-control" value="{{ isset($item) ? $item->email : old('email')  }}"/>
                 </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                  <label for="password">{{ adminTrans('user' , 'password') }}</label>
                    <input type="password" name="password" id="password" placeholder="{{ adminTrans('user' , 'password') }}"    class="form-control"/>
                </div>
            </div>


            <div class="form-group">
                <div class="">
                    @php $gourp = isset($item) && $item->group_id != 0 ? $item->group_id : null @endphp
                    <label for="">{{ adminTrans('user' , 'group') }} </label>
                    {!! Form::select('group_id' , $data['groups'] , $gourp , ['calss' => 'form-control'] ) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label for="">{{ adminTrans('user' , 'role') }}</label>
                    @php $roles = isset($data['roles_permission']) ? $data['roles_permission']->role->pluck('id')->all() : null @endphp
                    {!! Form::select('roles[]' , $data['roles'] , $roles, ['multiple' => true  , 'id' => 'roles' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label for="">{{ adminTrans('user' , 'permission') }}</label>
                    @php $permission = isset($data['roles_permission']) ? $data['roles_permission']->permission->pluck('id')->all()  : null @endphp
                    {!! Form::select('permission[]' , $data['permissions'] , $permission , ['multiple' => true , 'id' => 'permissions' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ adminTrans('home' , 'save') }} {{ adminTrans('user' , 'user') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection




@section('script')
    <script src="{{ url('/admin/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ url('/admin/js/search.js') }}"></script>
    <script>
        $('#roles').multiSelect(search("{{ adminTrans('user' , 'role') }}"));
        $('#permissions').multiSelect(search("{{ adminTrans('user' , 'permission') }}"));
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
