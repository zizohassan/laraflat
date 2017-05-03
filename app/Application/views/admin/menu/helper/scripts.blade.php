{{ Html::script('admin/plugins/nestable/jquery.nestable.js') }}
{{ Html::script('admin/js/pages/ui/modals.js') }}
{{ Html::script('admin/plugins/bootstrap-notify/bootstrap-notify.js') }}
<script>
    var url = "{{ url('admin/update/menuItem')  }}";
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
            $.get("{{ url('admin/getItemInfo/') }}/"+id , function(result){
                var json = JSON.parse(result);
                $('#itemName').val(json.name);
                $('#itemIcon').val(json.icon);
                $('#itemLink').val(json.link);
                $("#type").val(json.type == undefined || json.type ==  '' ? 'self' : json.type).change();
                $('#menu_id').val(json.id);
                $('#actionBtn').attr('onclick' , 'UpdateItem();return false;');
                $('#actionBtn').html('Save Item');
            });
        }else{
            clearFields();
            $('#actionBtn').removeAttr('onclick');
            $('#menu_id').val({{$item->id}});
            $('#actionBtn').html('Add Item');
        }
    });
    function clearFields(){
        $('#itemName , #itemLink , #itemIcon').val('');
    }
    function UpdateItem(){
        $(this).preventDefault;
        var id = $('#menu_id').val();
        var name = $('#itemName').val();
        var icon = $('#itemIcon').val();
        var link = $('#itemLink').val();
        var type = $('#type').val();
        type = type == '' ? 'self' : type;
        var data = {
            id:id,
            name:name,
            icon:icon,
            link:link,
            type:type,
            _token:"{{ csrf_token() }}"
        };
        $.post("{{ url('admin/updateOneMenuItem/') }}/",data, function(result){
            showNotification('<strong>Saving</strong> You have been update this item!');
        });
    }

    function showNotification(message){
        $.notify(message, {
            allow_dismiss: true ,
            timer: 1000 ,
            type: 'success',
//            showProgressbar: true,
//            progress: 20,
            placement: {
                from: "bottom",
                align: "right"
            },
            newest_on_top: true
        });
    }
</script>