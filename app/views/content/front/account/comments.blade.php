<div style="padding:20px">
    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    @if ($comments->count())

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                </tr>
            </thead>

            <tbody>
                @foreach ($comments as $comment)                    
                        <tr>
                            <td>{{ $comment->created_at }}</td>
                            <td><a href="/post/{{ $comment->post_id }}">{{ $comment->post }}</a></td>
                        </tr>                    
                @endforeach
            </tbody>
        </table>
        {{ $comments->links() }}     
    @else
        <br>
        <h4 style="text-align:center">Комментарии отсутствуют</h4>
    @endif    
</div>
