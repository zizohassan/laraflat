<script>
var foreign_key = $('#foreign_key'), primary_key = $('#primary_key'),val,relation_type = $('#relation_type');

function fChange() {
    val = foreign_key.val();
    removeFromSelect('primary_key' , val);
}

function pChange(){
    val = primary_key.val();
    removeFromSelect('foreign_key' , val);
}

foreign_key.on('change' ,function(){
    fChange();
    getCols2();
}) ;

primary_key.on('change' ,function(){
    pChange();
    getCols();
}) ;


relation_type.on('change' ,function(){
    controlRelationHtml();
}) ;




function removeFromSelect(id , val){
    var value = val;
    $('#'+id).find('option').each(function(index,element){
        if(element.value == value){
            $(this).hide();
        }else{
            $(this).show();
        }
    });
}

    function getCols(){
        var modelName = primary_key.val();
        $.get('{{ concatenateLangToUrl('admin/getCols') }}/'+modelName , function(result){
            var out = '';
            $.each(result , function(key , value){
                out += '<option value="'+value+'">'+value+'</option>'
            });
            $('#col1').html(out);
            $('#col2').html(out);
        });
    }

function getCols2(){
    var modelName = foreign_key.val();
    $.get('{{ concatenateLangToUrl('admin/getCols') }}/'+modelName , function(result){
        var out = '';
        $.each(result , function(key , value){
            out += '<option value="'+value+'">'+value+'</option>'
        });
        $('#fkey').html(out);
    });
}

function controlRelationHtml(){
    var rt =  relation_type.val();
    if(rt == 'mtm'){
        $('.mtmfc').show();
        $('.mtmtype').show();
    }else{
        $('.mtmfc').hide();
        $('.mtmtype').hide();
    }
}

primary_key.trigger("change");
foreign_key.trigger( "change" );
relation_type.trigger( "change" );
</script>