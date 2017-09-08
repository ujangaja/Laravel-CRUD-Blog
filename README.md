# Laravel-CRUD-Blog
Laravel CRUD Blog sederhana

Tahap yang dilakukan :



-action Delete
	ketikan perintah berikut pada index.blade.php:

	<form action="/blog/{{$blog->id}}" method="post">
		<input type="hidden" name="_method" value="delete">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="delete">
	</form>

-pada controller 
	tambah kan kode berikut pada function destroy:

	$blog = Blog::find($id);
        $blog->delete();
        return redirect('blog')->with('message','blog sudah di hapus!');

