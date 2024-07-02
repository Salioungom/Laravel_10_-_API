<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePosteRequest;
use App\Http\Requests\EditPosteRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        try {
            // Initialize query
            $query = Post::query();
            // Define number of items per page
            $perPage = 3;
            // Get current page or default to 1
            $page = $request->input('page', 1);
            // Get search term if provided
            $search = $request->input('search');
            if ($search) {
                $query->where('titre', 'like', '%' . $search . '%');
            }
            // Get paginated results
            $posts = $query->paginate($perPage, ['*'], 'page', $page);
            // Return JSON response with pagination details
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Liste des postes',
                'current_page' => $posts->currentPage(),
                'total' => $posts->total(),
                'total_pages' => $posts->lastPage(),
                'last_page' => $posts->lastPage(),
                'item' => $posts->items(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur interne',
                'error_message' => $e->getMessage(),
            ]);
        }
    }


    public function store(CreatePosteRequest $request ){
     try{
        $post=new Post();
        $post->titre=$request->titre;
        $post->description=$request->description;
        $post->user_id=auth()->user()->id;
        $post->save();
        return response()->json([
          'status_code'=>200,
          'status_message'=>'Le poste a étè ajouté ',
          'data'=>$post

        ]);
     }catch(Exception $e){
        return response()->json([
         'status_message'=>'Erreur interne ',
         'error_message'=>$e->getMessage()

        ]);

     }
    }
    public function update(EditPosteRequest $request,Post $post){
     try{
        $post->titre=$request->titre;
        $post->description=$request->description;
        if($post->user_id=== auth()->user()->id)
        {
            $post->save();
        } else{
            return response()->json([
                'status_code'=>403,
                'status_message'=>'Vous n\'avez pas le droit de modifier ce poste',

            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=>'Le poste a étè modifier ',
            'data'=>$post
        ]);
     }catch(Exception $e){
        return response()->json([
         'status_message'=>'Erreur interne ',
         'error_message'=>$e->getMessage(),
         'data'=>$post,

        ]);
     }
        // return response()->json([
        //  'status_code'=>200,
        //  'status_message'=>'Le poste a étè modifié ',
        //  'data'=>$post

        // ]);
    }

    public function destroy(Post $post){

        try{

        if($post->user_id=== auth()->user()->id)
        {
            $post->delete();
        } else{
            return response()->json([
                'status_code'=>403,
                'status_message'=>'Vous n\'avez pas le droit de supprimer ce poste.
                suppression non authiriser',

            ]);
        }
            return response()->json([
                'status_code'=>200,
                'status_message'=>'Le poste a étè supprimer ',
                'data'=>$post
            ]);
        }catch(Exception $e){
            return response()->json([
             'status_message'=>'Erreur interne ',
             'error_message'=>$e->getMessage(),
             'data'=>$post,

            ]);
        }
    }
}

