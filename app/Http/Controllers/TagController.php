<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::get();

        return view('Adm.Tags.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Adm.Tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        try {
            DB::beginTransaction();

            $tag = new Tag();
            $tag->nombre = $request->nombre;
            $tag->save();

            $log = new Log();
            $log->accion = 'Nueva etiqueta '.$tag->nombre.' ('.$tag->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('etiquetas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $etiqueta)
    {
        return view('Adm.Tags.edit', [
            'etiqueta' => $etiqueta,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $etiqueta)
    {
        try {
            DB::beginTransaction();

            $etiqueta->nombre = $request->nombre;
            $etiqueta->save();

            $log = new Log();
            $log->accion = 'Editar etiqueta '.$etiqueta->nombre.' ('.$etiqueta->id.'(';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('etiquetas.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $etiqueta)
    {
        try {
            DB::beginTransaction();

            $etiqueta->delete();

            $log = new Log();
            $log->accion = 'Eliminar etiqueta '.$etiqueta->nombre.' ('.$etiqueta->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('etiquetas.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
