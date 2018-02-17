<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <form method="post" class="saveMenus" action="{{ concatenateLangToUrl('admin/addNewItemToMenu') }}">
        {{ csrf_field() }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">
                        {{ trans('menu.add_new_item') }}
                    </h4>
                </div>
                <div class="modal-body">
                    {!! extractFiled(null,'name' , null , $type = 'text' , 'ItemName') !!}

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="link" id="itemLink" placeholder="{{ trans('menu.item_link') }}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="icon" id="itemIcon" placeholder="{{ trans('menu.item_icon') }}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                           <div class="controller_path">

                           </div>
                            <span  onclick="addNewControllerPath()" class="btn btn-success"> <i class="fa fa-plus"></i></span>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="">
                            <label for="">{{ trans('menu.type') }}</label>
                            {!! Form::select('type' , menuTarget()  , null , ['class' => 'form-control' , 'id' => 'type'] ) !!}
                        </div>
                    </div>
                    <input type="hidden" name="menu_id" id="menu_id" class="form-control" value="{{ $item->id }}" />
                    <input type="hidden" name="parent_id" id="parent_id" class="form-control" value="0" />
                    <input type="hidden" name="order" id="order" class="form-control" value="0" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect" id="actionBtn">{{ trans('menu.add_item') }}</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">{{ trans('menu.close') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>