@section('scripts')
<script>
    $('document').ready(function(){
        $('.vip_select').change(function(){
            var param = $(this).find('option:selected').val();
            var postId = $(this).attr('post_id');           
            if(param.length > 0){
                window.location.href = "/account/posts/vip/"+postId+'/'+param;
            }
        })
    });      
</script>
@stop
    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>

    @if ($posts->count())
        <div role="tabpanel" class="tab-pane active pull-left" id="myposts">
            <table class="table table-striped table-bordered" style="margin:0">
                <thead>
                    <tr>
                        {{ Common_helper::sorting_table_fields($table_fields) }}
                        <td style="min-width:100px">VIP</td>
                        <td style="min-width:55px"></td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post)                                         
                            <tr class="post_row" {{ strtotime('now') > strtotime($post->created_at.' + '.$settings->post_keep_front.' days')?'style="color:lightgrey;"':'' }}>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->price }}</td>
                                <td>{{ $post->city }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>
                                    <select class="vip_select" post_id="{{ $post->id }}">
                                        <option value="">Выбрать</option>
                                        <option value="main">На главной</option>
                                        <option value="region">Для региона</option>
                                        <option value="city">Для города</option>
                                    </select>
                                </td>                            
                                <td>
                                    <a href="/account/posts/edit/{{ $post->id }}" class="fa fa-pencil right5" title="Править"></a>
                                    <a href="/post/delete/{{ $post->id }}" class="fa fa-times right5" title="Удалить" onclick="return confirm('Удалить?')?true:false"></a>
                                </td>
                            </tr>                  
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    @else 
        <br>
        <h4 class="text-center">Объявления отсутствуют</h4>
    @endif
