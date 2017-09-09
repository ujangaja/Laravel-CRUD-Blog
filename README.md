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

		#dan ketika dibuka pada databasenya kita sudah membunyai table  migration $ blog




#action Delete
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



#menampilkan waktu
	#pada file index.balde .php tambah kan script berikut

	{{date('F,d,y',strtotime($blog->created_at))}}


#membuat pagination builder
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
#membuat pagination eloquent
	#pada file BlogController function index ubah:

        $blogs = Blog::all();

	#menjadi:


        $blogs = Blog::paginate(2);
        
        

#untuk menampilkan angka  pada index.blade.php tambahkan scrip berikut setelah :
		@endforeach
		

		{!! $blogs->links()!!}

