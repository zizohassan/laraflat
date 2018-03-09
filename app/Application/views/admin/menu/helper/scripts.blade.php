{{ Html::script('admin/plugins/nestable/jquery.nestable.js') }}
{{ Html::script('admin/js/pages/ui/modals.js') }}
{{ Html::script('admin/plugins/bootstrap-notify/bootstrap-notify.js') }}
<script>
    var url = "{{ concatenateLangToUrl('admin/update/menuItem')  }}";
    var id = "{{ $item->id }}";
    var _token = "{{ csrf_token() }}";
    $('.dd').nestable({
        maxDepth:2
    });
    $('.dd').on('change', function () {
        var $this = $(this);
        var serializedData = window.JSON.stringify($($this).nestable('serialize'));
        $this.parents('div.body').find('textarea').val(serializedData);
        $.post(url , {id:id,_token:_token,data:serializedData} , function(result){
            showNotification('<strong>Saving</strong> You have been update Items position!');
        });
    });
    $('#defaultModal').on('shown.bs.modal', function(evt) {
        clearFields();
        if($(evt.relatedTarget).data('url') && $(evt.relatedTarget).data('id')){
            var id = $(evt.relatedTarget).data('id');
            $.get("{{ concatenateLangToUrl('admin/getItemInfo/') }}/"+id , function(result){
                var json = JSON.parse(result);
                var names = JSON.parse(json.name);
                @foreach(getAvLang() as $K => $L)
                    $('#{{ 'name_'.$K }}').val(names.{{ $K }});
                @endforeach
                $('#itemIcon').val(json.icon);
                $('#itemLink').val(json.link);
                if(json.controller_path != undefined && json.controller_path != ''){
                    var controller_path = JSON.parse(json.controller_path);
                    $.each(controller_path , function (key , value) {
                        addNewControllerPath(value);
                    });
                }

                $("#type").val(json.type == undefined || json.type ==  '' ? 'self' : json.type).change();
                $('#menu_id').val(json.id);
                $('#actionBtn').attr('onclick' , 'UpdateItem();return false;');
                $('#actionBtn').html('{{ trans('menu.save_item') }}');
            });
        }else{
            clearFields();
            $('#actionBtn').removeAttr('onclick');
            $('#menu_id').val({{$item->id}});
            $('#actionBtn').html('{{ trans('menu.add_item') }}');
        }
    });
    function clearFields(){
        $('.controller_path').html('');
        $('#itemName , #itemLink , #itemIcon').val('');
    }
    function UpdateItem(){
        $(this).preventDefault;
        var data = $('.saveMenus').serialize();
        $.post("{{ concatenateLangToUrl('admin/updateOneMenuItem/') }}/",data, function(result){
            showNotification('<strong>Saving</strong> You have been update this item!');
            $('#defaultModal').modal('hide');
        });
    }

    function showNotification(message){
        $.notify(message, {
            allow_dismiss: true ,
            timer: 1000 ,
            type: 'success',
            placement: {
                from: "bottom",
                align: "right"
            },
            newest_on_top: true
        });
    }
    
    function addNewControllerPath(value) {
        if(value == undefined || value == null){
            value = '';
        }
        $('.controller_path').append('<div class="item_controller_path form-inline" style="margin-top:5px;margin-bottom:5px"><input type="text" name="controller_path[]"  placeholder="{{ trans('menu.Controller Path') }}" class="form-control" value="'+value+'" /><span onclick="removeControllerPath(this)" class="btn btn-danger"><i class="fa fa-trash"></i></span></div>');
    }
    
    function removeControllerPath(e) {
        $(e).closest('div .item_controller_path').remove();
    }
</script>