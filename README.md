# Laravel-CRUD-Blog
Laravel CRUD Blog sederhana

Tahap yang dilakukan :

#1.persiapan laravel
	#pada comandline ketikan printah install composer
	#instalasi juga laravelnya degan mengetik perintah pada comandline:

	composer create-project --prefer-dist laravel/laravel blog

#2.persiapan database
	#untuk databasnya sendiri ,dengan laravel hanya perlu membuat databasenya saja .
	nama databasenya : "laravel_blog"

	#selanjutnya kita membuat migration,ketikan perintah berikut pada terminal:

		php artisan make:migration create_blog_table

		

#3. pengaturan pada file .envi 
	
		DB_CONNECTION=mysql
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=laravel_blog
		DB_USERNAME=root
		DB_PASSWORD=

#4.menambah funtion up dan down pada  database/migratin/create_blog_table 	
		#funtion up:

		public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('subject');
            $table->timestamps();
        });
    }


    #function down:

        Schema::dropIfExists('blog');

	#selanjutnya jalankan dengan mengetkan printah berikut pada terminal:

		php artisan migrate

		#dan ketika dibuka pada databasenya kita sudah membunyai table  migration & blog


#5.mengatur routing dan controller

	#mambuat controller restfull/controller yang kumplit
	#ketikan pada terminal :

		php artisan make:controller BlogController --resource

	#lihat pada teks editor  App/Http/Controller/ , kita sudah mempunyai 1 file BlogController

	#buka web.php pada route ketikan perintah berikut:
		Route::group(['middleware' => ['web']], function() {
    
	Route::resource('blog','BlogController');
});


#6. Eloquent pada blogController
	#membuat model,pada terminal ketikan  perintah berikut:

	php artisan make:model Blog

	#kalau sudah lihat pada folder App didalamnya sudah ada file Blog yang td kita buat.

	#ketikan peritah berikut pada Blog.php :	
		
		protected $table = 'blog';

		#script diatas  hanya untuk menegaskan table pada database yang tidak plural jd menggunakan ini

	#buka file BlogControoler dan tambahkan baris kode berikut :

		use App\Blog;

		#dan juga  pada indexnya:

		$blogs = Blog::all();
		return view('blog.index',['blog'=>blogs]);

	#buat folde baru dengan nama blog di dalam volder resources/views

	#selanjutnya buat file baru didalamnya dengan nama :
		index.blade.php

		#didalamnya isi dengan:

		@foreach($blogs as $blog)
			<p>{{$blog->title}}</p>
			<p>{{$blog->subject}}</p>
			<hr>
		@endforeach
	#buka browser dan  lihat apa yang akan tampil


#7.inset dan validasi

	#pada BlogController create ketikan kode berikut:

		return view('blog.create');

	#pad folder blog buat file baru dengan nama:

		creat.baldephp

	#masukan kode berikut:

	<h1>Create Blog Post</h1>
<form class="" action="/blog" method="post">
	<input type="text" name="title" placeholder="judul"><br>
    <br>
    <textarea name="subject" id="" cols="40" rows="10" placeholder="isi...."></textarea>
    <br>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="submit" name="name" value="post">
</form>

	#pada route web.php  ubah dan tambahkan  kode berikut:

		Route::group(['middleware' => ['web']], function() {
		
		Route::resource('blog','BlogController');
		});

	#pada file BlogController  store tambah kan kode berikut:

		 $request->validate([
        'title'   => 'required',
        'subject' => 'required',
    ]);

    #untuk menampilkan pada saat melkukan kesalahan input tabahkan kode berikut pada create.blade.php:


    	@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
	#kalau mau ebih spesifik dapat menambahkan ternary operator ,rubah semua kodenya menjadi kode dibaha ini:

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

	#pada contollernya  tambahkan bariskode berikut:

	$blog          = new Blog;
	$blog->title   = $request->title;
	$blog->subject = $request->subject;

	$blog->save();

	#lalu coba masukan data pada browser, lihat pada database ada data yang tersimpan.

#8.pesan pada session dan redirect
	#pda controller storenya  tambah kan baris kode berikut:

        return redirect('blog')->with('message','blog sudah di update!');

    #kemudian  pada index.blade.php buat akses dengan sistem templating blade,ketkan kode berikut

    	{{Session::get('message')}}

#9.menampilkan sigle page dari setiap posnya
	#pada contoller show ketikan kode berikut:

		$blog = Blog::find($id);
		if(!blog){
			abort(404);
		}

		return view('blog.single')-.with('blog',$blog);

	#buat file baru didalam folder blog:

		single.blade.php
	
	#isi dengan kode berikut didalamnya:

		<h1>Halaman Single</h1>

		<a href="/blog/{{$blog->id}}">{{$blog->title}}</a>
		<br>
		<a href="/blog/{{$blog->id}}">{{$blog->subject}}</a>

#10.Mengupdate data
	#pada controller edit ketikan baris kode berikut:

	$blog = Blog::find($id);
		if(!blog){
			abort(404);
		}

		return view('blog.edit')-.with('blog',$blog);

	#buat file baru pada folder blog:
		
		edit.blade.php

	#lalu ketikan kode berikut:

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


	#pada controller update tambahkan kode berikut:

		 $request->validate([
        'title'   => 'required',
        'subject' => 'required',
    ]);

        
        $blog = Blog::find($id);

        $blog->title = $request->title;
        $blog->subject = $request->subject;

        $blog->slug    = str_slug($request->title,'-');
        $blog->save();

        return redirect('blog')->with('message','blog sudah di edit!');

	#selanjutnya pada file index.blade.ph tambahkan kode berikut:

		<a href="/blog/{{$blog->id}}/edit">Edit</a>




	








#11.action Delete
	ketikan perintah berikut pada index.blade.php:

	<form action="/blog/{{$blog->id}}" method="post">
		<input type="hidden" name="_method" value="delete">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="delete">
	</form>

	#pada controller 
		tambah kan kode berikut pada function destroy:

		$blog = Blog::find($id);
	        $blog->delete();
	        return redirect('blog')->with('message','blog sudah di hapus!');

	#Membuat link berdasarkan title atau nama jika membuka halam single
		#buka index.blade.php ubah 
			<a href="/blog/{{$blog->id}}"><p>{{$blog->title}}</p></a>
		 menjadi :
		 	<a href="/blog/{{$blog->title}}"><p>{{$blog->title}}</p></a>

		 #pada bagian BlogController function show ganti:

	        	public function show($id)
	        menjadi :
	    		public function show($title)

	    		dan :

	        $blog = Blog::find($id);

	      #menjadi:
	        $blog = Blog::where('title',$title)->first();
	        

	        #lalu pada database buat fild baru dengan nama slug
	       #pada file migration table tambahkan:
	            $table->string('slug');
	       	#lalu pada BlogController pada function store tambahkan script berikut:
	        $blog->slug    = str_slug($request->title,'-');

	        #pada index.blade.php 
		 		<a href="/blog/{{$blog->title}}"><p>{{$blog->title}}</p></a>

		 		 title diganti menjadi slug:

		 	<a href="/blog/{{$blog->slug}}"><p>{{$blog->title}}</p></a>

		 	#pada BlogController  title di ganti juga jd slug
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

	        		

			#selanjutnya pada functionn edit ditambahkan script berikut:
	        	$blog->slug    = str_slug($request->title,'-');



#12.menampilkan waktu
	#pada file index.balde .php tambah kan script berikut

	{{date('F,d,y',strtotime($blog->created_at))}}


#13.membuat pagination builder
	#pada file BlogController function index ubah:

        $blogs = Blog::all();

	#menjadi:


        $blogs = DB::table('blog')->paginate(3);

   #selanjutnya pada :

    	namespace App\Http\Controllers;

		use Illuminate\Http\Request;
		use App\Blog;
		use App\Http\Requests;

		ditambahkan ini:
		
		use DB;
#14.membuat pagination eloquent
	#pada file BlogController function index ubah:

        $blogs = Blog::all();

	#menjadi:


        $blogs = Blog::paginate(2);
        
        

#15.untuk menampilkan angka  pada index.blade.php tambahkan scrip berikut setelah :
		@endforeach
		

		{!! $blogs->links()!!}

