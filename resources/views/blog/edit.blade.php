{{-- 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 --}}
<h1>Edit Blog Post</h1>

<form class="" action="/blog/{{$blog->id}}" method="post">
	<input type="text" name="title" value="{{$blog->title}}" placeholder="judul"><br>
    {{($errors->has('title')) ? $errors->first('title'): ''}}
    <br>
    <textarea name="subject" id="" cols="40" rows="10" placeholder="isi....">{{$blog->subject}}</textarea>
    {{($errors->has('subject')) ? $errors->first('subject'): ''}}
    <br>
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="submit" name="name" value="edit">
</form>