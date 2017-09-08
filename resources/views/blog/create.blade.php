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
<h1>Create Blog Post</h1>

<form class="" action="/blog" method="post">
	<input type="text" name="title" placeholder="judul"><br>
    {{($errors->has('title')) ? $errors->first('title'): ''}}
    <br>
    <textarea name="subject" id="" cols="40" rows="10" placeholder="isi...."></textarea>
    {{($errors->has('subject')) ? $errors->first('subject'): ''}}
    <br>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="submit" name="name" value="post">
</form>