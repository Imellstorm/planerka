<div class="row chat_cont" style="margin:10px;max-width:500px;padding:10px;">
    <div class="col-md-12" style="padding: 0;">
        <img src="{{ Common_helper::getUserAvatar($message->user_id) }}" style="width:40px; float:left; margin-right:10px">
        @if(!empty($message->name) || !empty($message->surname))
            <div class="pull-left" style="font-weight:bold">{{ $message->name }} {{ $message->surname }}</div>
        @else
            <div class="pull-left" style="font-weight:bold">{{ $message->alias }}</div>
        @endif
        <span class="{{ $message->online?'online':'offline' }}"></span>
        <div style="font-size:12px; margin-bottom:10px">{{ $message->city }}</div>
    </div>
    <div class="col-md-12" style="background:#FAFAF5;padding:20px;margin-top:5px;">
        <div style="font-size:12px">{{ $message->created_at }}</div>
        <div style="overflow: hidden;">{{ $message->text }}</div>
    </div>
</div>