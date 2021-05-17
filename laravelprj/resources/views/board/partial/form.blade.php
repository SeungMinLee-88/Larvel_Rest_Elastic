@if (auth()->user()->isAdmin())

<div class="form-group">
    <div class="checkbox help-block pull-right hidden-xs">
        <i class="fa fa-exclamation-circle"></i>
        <label>

            <input type="checkbox" name="noticed" value="1" {{ $board->noticed =="1" ? 'checked' : '' }}>
            {{ trans('noticed') }}
        </label>

    </div>
</div>
@endif
<div class="form-group">
    <label for="title">{{ trans('forum.title') }}</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $board->title) }}"/>
    {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>
<div class="form-group">

    <label for="content">{{ trans('forum.content') }}</label>
    <textarea name="content" class="form-control forum__content" rows="10">{{ old('content', $board->content) }}</textarea>
    {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>
@include('attachments.partial.list', ['attachments' => $board->attachments])
<div class="form-group">
    <label for="my-dropzone">
        Files
        <small class="text-muted">
            Click to attach files <i class="fa fa-chevron-down"></i>
        </small>
        <small class="text-muted" style="display: none;">
            Click to close pane <i class="fa fa-chevron-up"></i>
        </small>
    </label>
    <div id="my-dropzone" class="dropzone"></div>
</div>

@section('script')
    <script>
        var dropzone  = $("div.dropzone"),
            dzControl = $("label[for=my-dropzone]>small");
        dzControl.on("click", function(e) {
            dropzone.fadeToggle(0);
            dzControl.fadeToggle(0);
        });

        Dropzone.autoDiscover = false;
        var insertImage = function(objId, imgUrl) {
            var caretPos = document.getElementById(objId).selectionStart;
            var textAreaTxt = $("#" + objId).val();
            var txtToAdd = "![](" + imgUrl + ")";
            $("#" + objId).val(
                textAreaTxt.substring(0, caretPos) +
                txtToAdd +
                textAreaTxt.substring(caretPos)
            );
        };

        var myDropzone = new Dropzone("div#my-dropzone", {
            url: "/files",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            params: {
                _token: "{{ csrf_token() }}",
                boardId: "{{ $board->id }}"
            },
            dictDefaultMessage: "<div class=\"text-center text-muted\">" +
                "<h2>{{ trans('forum.msg_dropfile') }}</h2>" +
                "<p>{{ trans('forum.msg_dropfile_sub') }}</p></div>",
            addRemoveLinks: true
        });

        myDropzone.on("success", function(file, data) {
            file._id = data.id;
            file._name = data.name;
            $("<input>", {
                type: "hidden",
                name: "attachments[]",
                class: "attachments",
                value: data.id
            }).appendTo("form");

            if (/^image/.test(data.type)) {
                insertImage('content', data.url);
            }
        });

        myDropzone.on("removedfile", function(file) {
            $.ajax({
                type: "POST",
                url: "/files/" + file._id,
                data: {
                    _method: "DELETE",
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                error: function () {
                    alert("통신실패!!!!");
                },
                success: function (data) {
                    console.log(data);
                }
            });
        });

        function editfile(file){
            $.ajax({
                type: "POST",
                url: "/files/" + file,
                data: {
                    _method: "DELETE",
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                error: function () {
                    alert("통신실패!!!!");
                },
                success: function (data) {
                    jQuery('#file'+file).hide();
                    console.log(data);
                }
            });

        }
    </script>
@stop
