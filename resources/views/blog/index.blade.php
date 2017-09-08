{{ Session::get('message') }}

<br>
All Blog List

@foreach($blogs as $blog)
	<a href="/blog/{{$blog->id}}"><p>{{$blog->title}}</p></a>
	<p>{{$blog->subject}}</p>
	<a href="/blog/{{$blog->id}}/edit">Edit</a>
<hr>
@endforeach

