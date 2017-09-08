{{ Session::get('message') }}

All Blog List

@foreach($blogs as $blog)
	<a href="/blog/{{$blog->id}}"><p>{{$blog->title}}</p></a>
	<p>{{$blog->subject}}</p>
<hr>
@endforeach

