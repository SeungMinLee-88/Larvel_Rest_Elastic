<!-- resources/views/comments/index.blade.php -->
{{ method_field('PUT') }}
<div class="container__forum">
    @if($currentUser)
        @include('comments.partial.create')
    @endif
    <span class="media-heading">
    @forelse($comments as $comment)
        @if(!$comment->parent_id)
            @include('comments.partial.comment', ['parentId' => $comment->id,
              'isReply'   => false,
              'hasChild'  => count($comment->replies)])
        @endif
@empty
@endforelse

</span>

</div>
@section('style')
<style>
    div.media__create:not(:first-child),
    div.media__edit {
        display: none;
    }
</style>
@stop

@section('script')
<script>
    $("button.btn__reply").on("click", function(e) {
        $(this).closest(".media__item").find(".media__create").first().toggle().focus();;
        $(this).closest(".media__item").find(".media__edit").first().hide();
    });

    $("a.btn__edit").on("click", function(e) {
        $(this).closest(".media__item").find(".media__create").first().hide();
        $(this).closest(".media__item").find(".media__edit").first().toggle().focus();;

    });

    $("a.btn__delete").on("click", function(e) {
        var commentId = $(this).closest(".media__item").data("id");
        if (confirm("Are you sure to delete this comment?")) {
            $.ajax({
                type: "POST",
                url: "/comment/destroy/" + commentId,
                data: {
                    _method: "GET"
                },
                success : function(data) {
                    alert("comment is deleted");
                    location.reload(3000);
                },
                error:function(){
                    alert("error");
                }
            })
        }
    });
</script>
@stop
