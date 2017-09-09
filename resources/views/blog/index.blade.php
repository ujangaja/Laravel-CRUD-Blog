{{ Session::get('message') }}

<br>
All Blog List

@foreach($blogs as $blog)
	<a href="/blog/{{$blog->slug}}"><p>{{$blog->title}}</p></a>
	<p>{{$blog->subject}}</p>
	<br>

	{{date('F,D,y',strtotime($blog->created_at))}}
	<br>
	<a href="/blog/{{$blog->id}}/edit">Edit</a>

	<form action="/blog/{{$blog->id}}" method="post">
		<input type="hidden" name="_method" value="delete">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="delete">
	</form>
<hr>
@endforeach

