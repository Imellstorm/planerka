@extends ('containers.frontend')

@section('title') {{ $post->title }} @stop

@section('scripts')
	<script>
		$(document).ready(function() {
			$(".fancybox").fancybox();
			$(".sendmessage").fancybox({
				type: 'ajax'
			});
			$('.contact_button').on('click',function(){
				$('.contact_info').toggle();
			});
		});

		function editComment(elem,action){		
			if(action=='edit'){	
				content = $(elem).parent().parent().parent().find('.comment_content');			
				content.html('<div><textarea class="form-control">'+content.text().trim()+'</textarea></div>');
				$(elem).text('{{ Lang::get('main.save') }}');
				$(elem).attr('onClick',"editComment(this,'save')");
				$(elem).attr('class','pointer');
			} else if(action=='save') {
				content = $(elem).parent().parent().parent().find('textarea').val();
				$.ajax({
					type: 'post',
					url: '/comments/ajaxupdate',
					data: {
						'id': $(elem).data('id'),
						'content': content 
					},
					success: function(ret){
						$(elem).parent().parent().parent().find('.comment_content').html(ret);
						$(elem).text('');
						$(elem).attr('onClick',"editComment(this,'edit')");
						$(elem).addClass('fa fa-pencil');
					} 
				});
			}
		}

		function deleteComment(elem){
			if (confirm("{{ Lang::get('main.delete') }}?")){
				$.ajax({
					type: 'delete',
					url: '/comments/destroy/'+$(elem).data('id'),
					success: function(){
						$(elem).parent().parent().parent().remove();
					} 
				});
			}
		}
	</script>
@stop

@section('main')

    <h1 class="fa fa-posts pull-left"> {{ $post->title }}</h1>
    <div class="pull-right" style="margin-top:35px;">{{ Lang::get('main.added') }}: {{ $post->created_at }}</div>

    <div class="post clear">			
			<div>
				{{ $post->description }}
			</div>

			<ul class="post_info">
				<li><b>{{ Lang::get('main.type_of_ownership') }}</b>: {{ $post->ownershipname }}</li>
				<li><b>{{ Lang::get('main.tax_forms') }}</b>: {{ $post->ndsname }}</li>
				<li><b>{{ Lang::get('main.location') }}</b>: {{ $post->region }}, {{ $post->city }}</li>
				@if (!empty($licenses))
					<li><b>{{ Lang::get('main.licenses') }}</b>:
					@if(isset($licenses) && count($licenses))
						@foreach($licenses as $license)
							{{ $license->name }},
						@endforeach
					@endif
					</li>
				@endif
				@if ($post->files)
					<li>
						<b>{{ Lang::get('main.docs') }}</b>:
						@if (Auth::guest())
							Для просмотра загруженных документов <a href="/auth">войдите</a> или <a href="/account/register">зарегистрируйтесь</a>
						@else
							@foreach (json_decode($post->files) as $key=>$file)
									<a href="/{{ $file }}" class="fancybox">{{ $key }}</a>
							@endforeach
						@endif
					</li>
				@endif
				<li>
					<div><b>{{ Lang::get('main.contacts') }}</b>:
					@if (Auth::guest())
							{{ Lang::get('main.to_view_the_contacts') }} <a href="/auth/ajax" class="login">{{ Lang::get('main.please_enter') }}</a> {{ Lang::get('main.or') }} <a href="/registration">{{ Lang::get('main.register') }}</a></div>
					@else
						<a class="contact_button pointer">{{ $post->username }}</a></div>
						<div class="contact_info" style="display:none">
							<div>{{ Lang::get('main.phone') }}: {{ $post->phone }}</div>
							<div>{{ Lang::get('main.address') }}: {{ $post->address }}</div>
							<div>Email: {{ $post->email }}</div>
							<div>
								@if(!Auth::guest() && $post->user_id != Auth::User()->id)
									<a class="pointer sendmessage" href="/message/create/{{ $post->user_id }}">{{ Lang::get('main.write_to_author') }}</a>
								@endif
							</div>
						</div>
					@endif
				</li>
				<li><b>{{ Lang::get('main.price') }}</b>:
			        @if($course)
                        <span style="font-size:20px;">{{ round((int)$post->price/(int)$course[$selectedCurrency]) }}</span> <span class="cur-ident">{{ $selectedCurrency }}</span>
                    @else
                        <span style="font-size:20px;">{{ $post->price }}</span> <span class="cur-ident">UAH</span>
                    @endif
				</li>
			</ul>			
	</div>

	<h4>{{ Lang::get('main.comments') }}:</h4>
	@if(!$comments)
		<div>{{ Lang::get('main.there_are_no_comments') }}</div>
		<hr>
	@else
		@foreach($comments as $comment)
			<div class="comment panel panel-default">
				<div class="panel-body">
					<b>{{ $comment->username }}</b>, <span style="font-size:10px">{{ $comment->created_at }}</span>
					@if (!Auth::guest() && ($comment->user_id == Auth::User()->id || Auth::User()->role->id == 1))
						<div class="comment_actions">
							<span onClick="editComment(this,'edit')" class="pointer comment_edit_button fa fa-pencil right5" data-id="{{ $comment->id }}" title="{{ Lang::get('main.redact') }}"></span>
							<span onClick="deleteComment(this)" class="pointer fa fa-times right5" data-id="{{ $comment->id }}" title="{{ Lang::get('main.delete') }}"></span>
							@if(!Auth::guest() && $comment->user_id != Auth::User()->id)							
								<a class="pointer sendmessage" href="/message/create/{{ $comment->user_id }}">{{ Lang::get('main.write_to_author') }}</a>
							@endif
						</div>
					@elseif(!Auth::guest() && $comment->user_id != Auth::User()->id)
						<div class="comment_actions">
							<a class="pointer sendmessage" href="/message/create/{{ $comment->user_id }}">{{ Lang::get('main.write_to_author') }}</a>
						</div>
					@endif
					<div class="comment_content" style="margin-top:20px">
						{{ $comment->content }}
					</div>
				</div>
			</div>
		@endforeach
		{{ $comments->links() }}
	@endif	

	@if(!Auth::guest())
		<form method="POST" action="/comments/store">
			<div class='form-group'>
				{{ Form::label('content', Lang::get('main.add_comment') ) }}
		        {{ Form::textarea('content', null, array('class' => 'form-control', 'style'=>'height:100px')) }}
		        {{ Form::hidden('post_id',  $post->id) }}
		    </div>
		    <div class='form-group'>
		        {{ Form::submit(Lang::get('main.send'), array('class' => 'btn btn-success')) }}
		    </div>
		</form>
	@endif

@stop