<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <form method="post" action="{{ url('/admin/addNewItemToMenu') }}">
        {{ csrf_field() }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Menu Item</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="name" id="itemName" placeholder="Item Name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="link" id="itemLink" placeholder="Item Link" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="icon" id="itemIcon" placeholder="Item icon" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="">
                            <label for="">Item  Target</label>
                            {!! Form::select('type' , menuTarget()  , null , ['class' => 'form-control' , 'id' => 'type'] ) !!}
                        </div>
                    </div>
                    <input type="hidden" name="menu_id" id="menu_id" class="form-control" value="{{ $item->id }}" />
                    <input type="hidden" name="parent_id" id="parent_id" class="form-control" value="0" />
                    <input type="hidden" name="order" id="order" class="form-control" value="0" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect" id="actionBtn">Add Item</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </form>
</div>