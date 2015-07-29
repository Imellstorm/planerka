<ul class="theme-list">
    @foreach($blogThemes as $item)
        <li>
        <div class="title"><a href="/blog/theme/{{ $item->id }}">{{ $item->name }}</a></div>
            <div class="comment">{{ $item->postscount }}</div>
            <div class="date">{{ Common_helper::translateDate(strtotime($item->created_at)) }}</div>
        </li>
    @endforeach
</ul>