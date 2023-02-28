<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // Proteger la ruta de muro
    public function __construct()
    {
        // Restringir el acceso de like a usuarios no autenticados con except
        $this->middleware('auth')->except('show', 'index');
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', compact('user', 'posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id'=> auth()->user()->id
        // ]);

        // Otra forma de registrar datos en la db
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // 3cer forma de guardar implementando relaciones
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id'=> auth()->user()->id
        ]);



        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', compact('post', 'user'));
    }

    public function destroy(Post $post)
    {
        // Solo el autor puede eliminar el post, comprobacion:
        // if($post->user_id === auth()->user()->id) {} else {}

        // Verificar si el que elimina es el autor del post con policy
        $this->authorize('delete', $post);
        $post->delete();

        // Eliminar la imgaen
        $imagen_path = public_path('uploads/posts/' . $post->imagen);

        if(File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        // Eliminar los comentarios pertenecientes al post
        // Obtener todos los comentarios del post
        $comentarios = Comentario::where('post_id', $post->id)->get();
        // Eliminar los comentarios
        foreach ($comentarios as $comentario) {
            $comentario->delete();
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
