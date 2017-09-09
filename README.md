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

#Membuat link berdasarkan title atau nama jika membuka halam single
	-buka index.blade.php ubah 
		<a href="/blog/{{$blog->id}}"><p>{{$blog->title}}</p></a>
	 menjadi :
	 	<a href="/blog/{{$blog->title}}"><p>{{$blog->title}}</p></a>

	 -pada bagian BlogController function show ganti:

        	public function show($id)
        menjadi :
    		public function show($title)

    		dan :

        $blog = Blog::find($id);

      -menjadi:
        $blog = Blog::where('title',$title)->first();
        

       - lalu pada database buat fild baru dengan nama slug
       -pada file migration table tambahkan:
            $table->string('slug');
       	-lalu pada BlogController pada function store tambahkan script berikut:
        $blog->slug    = str_slug($request->title,'-');

        -pada index.blade.php 
	 		<a href="/blog/{{$blog->title}}"><p>{{$blog->title}}</p></a>

	 		 title diganti menjadi slug:

	 	<a href="/blog/{{$blog->slug}}"><p>{{$blog->title}}</p></a>

	 	-pada BlogController  title di ganti juga jd slug
	 		function show($title)
			{
				$blog = Blog::find($id);
				$blog    = Blog::where('title',$title)->first();
				if(!$blog){
				abort(404);
			}

		

			ganti menjadi:

			function show($title)
			{
				$blog = Blog::find($id);
				$blog = Blog::where('slug',$title)->first();
				if(!$blog){
				abort(404);
			}

        		

		-selanjutnya pada functionn edit ditambahkan script berikut:
        	$blog->slug    = str_slug($request->title,'-');



#menampilkan waktu
	-pada file index.balde .php tambah kan script berikut
	{{date('F,d,y',strtotime($blog->created_at))}}
		