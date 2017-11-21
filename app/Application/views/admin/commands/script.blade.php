<script>
    var commands = $('#commands'), form = $('#form'), command_val,cols_val, output, cols = $('#cols');

    commands.on('change' , function(){
        command_val = commands.val()
        if(command_val != 'laraflat:admin_model'){
            name();
        }else{
            adminModel();
        }
    });

    function name(){
        form.html(' ');
        output = '';
        output += '<div class="form-group">'+
                '<label for="name">{{ trans("contact.name") }}</label>'+
                ' <input type="text" name="name" id="name"  class="form-control"/>'+
                '</div>';
        form.html(output);
    }

    function adminModel(){
        form.html(' ');
        output = '';
        output += '<div class="form-group">'+
                '<label for="name">{{ trans("admin.name") }}</label>'+
                ' <input type="text" name="name" id="name"  class="form-control"/>'+
                '</div>';
        output += '<span  class="btn btn-danger" onclick="addNewColumn();"><i class="fa fa-plus"></i></span>';
        form.html(output);
    }

    function addNewColumn(){
        output = '';
        var count = $('.parent').length;
        output += '<div class="parent row well"><div class="col-lg-6"><div class="form-group col-lg-12">'+
                '<label for="name">{{ trans("admin.col name") }}</label>'+
                ' <input type="text" name="colsName['+count+']" id="name"  class="form-control" required/>'+
                '</div>';
        output += '<div class="form-group col-lg-5">'+
                '<label for="name">{{ trans("admin.col type") }}</label>'+
                '<select name="migration['+count+']" class="form-control" required>';
                @foreach($migrationTypes as $type)
                        output += '<option value="{{ $type }}">{{ $type }}</option>';
                @endforeach
                output += '</select>'+
                '</div>';
        output += '<div class="form-group col-lg-6">'+
                '<label for="name">{{ trans("admin.lang") }}</label>'+
                '<select name="lang['+count+']" class="form-control"><option value="0">{{ trans("admin.no") }}</option><option value="1">{{ trans("admin.yes") }}</option></select>'+
                '</div>';
        output += '<div class="form-group col-lg-1 " style="margin-top: 20px">'+
                '<span class="btn btn-danger" onclick="removeThisRow(this)"><i class="fa fa-trash"></i></span>'+
                '</div>';
        output += '</div><div class="col-lg-6"><div class="form-group col-lg-12">'+
                '<label for="name">{{ trans("admin.col validation") }}</label><div class="row">';
                @foreach($validationTypes as $key =>  $type)
                        output += '<div class="col-lg-2 inline-form"><input type="checkbox" name="validation['+count+'][{{ $key }}]" /> {{ $key }} </div>';
                @if($type)
                        output += '<div class="col-lg-10"><input type="text" name="validationVal['+count+'][{{ $key }}]" id="name"  class="form-control"/></div>';
                @endif
                @endforeach
        output += '</div></div></div></div><hr />';
        cols.append(output);
    }

    function removeThisRow(e){
        $(this).parent('div.form-group').parent('div.parent').remove();
    }


    commands.trigger( "change" );

</script>