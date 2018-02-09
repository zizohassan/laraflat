<script>
    var commands = $('#commands'), form = $('#form'), command_val, cols_val, output, cols = $('#cols'), commandName = $('.name');

    commands.on('change', function () {
        command_val = commands.val();
        cols.html('');
        if (command_val == 'laraflat:admin_model') {
            adminModel();
        } else if (command_val == 'laraflat:comment') {
            adminModel("Comment", "display:none", true);
        } else if (command_val == 'laraflat:rate') {
            adminModel("Rate", "display:none", true);
        } else {
            name();
        }
    });

    function name() {
        form.html(' ');
        output = '';
        output += '<div class="form-group name">' +
                '<label for="name">{{ trans("contact.name") }}</label>' +
                ' <input type="text" name="name" id="name"  class="form-control"/>' +
                '</div>';
        form.html(output);
    }

    function adminModel(value, show, showModel) {
        v = value === undefined && value == null ? '' : value;
        s = show === undefined && value == null ? '' : show;
        form.html(' ');
        output = '';
        output += '<div class="form-group" style="' + s + '">' +
                '<label for="name">{{ trans("admin.name") }}</label>' +
                ' <input type="text" name="name" id="name"  class="form-control" value="' + v + '"/>' +
                '</div>';
        if (showModel === undefined && showModel == null) {
            output += '<span  class="btn btn-danger" onclick="addNewColumn();" style="position: fixed;left: 270px;z-index: 10000"><i class="fa fa-plus"></i></span>';
        } else {
            output += showModel === undefined && showModel == null ? '' : appendModels();
        }
        form.html(output);
    }

    function addNewColumn() {
        output = '';
        var count = $('.parent').length;
        output += '<div class="parent clearfix"><div class="row well "><div class="col-lg-6"><div class="form-group col-lg-12">' +
                '<label for="name">{{ trans("admin.col name") }}</label>' +
                ' <input type="text" name="colsName[' + count + ']" id="name"  class="form-control" required/>' +
                '</div>';
        output += '<div class="form-group col-lg-5">' +
                '<label for="name">{{ trans("admin.col type") }}</label>' +
                '<select name="migration[' + count + ']" class="form-control" required>';
        @foreach($migrationTypes as $type)
                output += '<option value="{{ $type }}">{{ $type }}</option>';
        @endforeach
                output += '</select>' +
                '</div>';
        output += '<div class="form-group col-lg-6">' +
                '<label for="name">{{ trans("admin.lang") }}</label>' +
                '<select name="lang[' + count + ']" class="form-control"><option value="0">{{ trans("admin.no") }}</option><option value="1">{{ trans("admin.yes") }}</option></select>' +
                '</div>';
        output += '<div class="form-group col-lg-1 " style="margin-top: 20px">' +
                '<span class="btn btn-danger" onclick="removeThisRow(this)"><i class="fa fa-trash"></i></span>' +
                '</div>';
        output += '</div><div class="col-lg-6"><div class="form-group col-lg-12">' +
                '<label for="name">{{ trans("admin.col validation") }}</label><div class="row">';
        @foreach($validationTypes as $key =>  $type)
                output += '<div class="col-lg-2 inline-form"><input type="checkbox" name="validation[' + count + '][{{ $key }}]" /> {{ $key }} </div>';
        @if($type)
                output += '<div class="col-lg-10"><input type="text" name="validationVal[' + count + '][{{ $key }}]" id="name"  class="form-control"/></div>';
        @endif
                @endforeach
                output += '</div></div></div></div><br><hr /></div>';
        cols.append(output);
    }

    function removeThisRow(e) {
        $(e).closest('div.parent').remove();
    }

    function appendModels() {
        output = '';
        output += '<div class="col-lg-12 clearfix">';
        output += '<div class="form-group">';
        output += '<div class="">';
        output += '<label for="">{{ trans('admin.Select Model') }}</label>';
        output += '<select name="foreign_key" id="foreign_key" class="form-control" required>';
        @foreach($models as $model)
                output += '<option value="{{ $model }}">{{ $model }}</option>';
        @endforeach
                output += '</select>';
        output += '</div>';
        output += '</div>';
        output += '</div>';
        return output;
    }


    commands.trigger("change");

</script>