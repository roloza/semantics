@extends('layout')

@section('title')
    Lancer une analyse
@endsection

@section('description')
    Analyser la sémantique, un page unique, un site entier ou encore le web en général
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">{{ $post->name === null ? 'Nouvel article' : 'Editer l\'article ' . $post->name }}</h2>
        <div class="grid grid-cols-12 gap-6">

    @if(session('success'))
        <div class="alert alert-success show mb-2" role="alert">{{ session('success') }}</div>
    @endif


        <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
            <div class="grid grid-cols-12 gap-6">

                <div class="col-span-12 mt-6">
                    <div class="intro-y box p-5">
                        <form action="{{route('admin.posts.update', ['post' => $post])}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="put">
                            @csrf
                            {{-- Titre --}}
                            <div class="mt-3">
                                <label for="name" class="form-label">Titre</label>
                                <input name="name" id="name" type="text" class="form-control w-full"
                                       value="{{ $post->name }}">
                            </div>

                            {{-- Description --}}
                            <div class="mt-3">
                                <label for="content" class="form-label">Description</label>
                                <textarea name="description" cols="30" rows="3" class="form-control w-full" >{{ $post->description }}</textarea>
                            </div>

                            {{-- Contenu --}}
                            <div class="mt-3">
                                <label for="content" class="form-label">Contenu</label>
                                <textarea data-id="{{ $post->id }}" data-type="{{ get_class($post) }}"
                                          data-url="{{ route('admin.attachments.store') }}" name="content"
                                          cols="30" rows="10"
                                          class="form-control w-full" id="editor">{{ $post->content }}</textarea>
                            </div>

                            {{-- Tags --}}
                            <div class="mt-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input name="tags" id="tags" type="text" class="form-control w-full"
                                       value="{{ $tags }}">
                            </div>

                            {{-- Category --}}
                            <div class="mt-3">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select  name="category_id" class="form-control w-full">
                                    <option value="">-</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{(int)$category->id === (int)$post->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Parent --}}
                            <div class="mt-3">
                                <label for="parent_id" class="form-label">Article parent</label>
                                <select  name="parent_id" class="form-control w-full">
                                    <option value="">-</option>
                                    @foreach($posts as $parentPost)
                                        <option value="{{ $parentPost->id }}" {{(int)$parentPost->id === (int)$post->parent_id ? 'selected' : ''}}>{{ $parentPost->name }}</option>
                                    @endforeach

                                </select>

                            </div>


                            {{-- Keywords --}}
                            <div class="mt-3">
                                <label for="keywords" class="form-label">Keywords</label>
                                <input name="keywords" id="keywords" type="text" class="form-control w-full"
                                       value="{{ $post->keywords }}">
                            </div>

                            {{-- Main Image --}}
                            <div class="mt-3">
                                <label for="image_id" class="form-label">Identifiant Image principale</label>
                                <select  name="image_id" class="form-control w-full">
                                    <option value="">-</option>
                                    @foreach($images as $image)
                                        <option value="{{ $image->id }}" {{(int)$image->id === (int)$post->image_id ? 'selected' : ''}}>{{ $image->filename }}</option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="text-right mt-5">
                                <button class="btn btn-primary w-24">Enregistrer</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>


    </div>

@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/eeni0d95cmhl16ws9y1696cyj98jo1vsmffefbipzzv3hxwd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
      var textarea = document.querySelector('#editor');

      if (window.tinyMCE) {
        tinymce.init({
          selector: '#editor',
          plugins: 'image,paste',
          paste_data_image: true,
          automatic_uploads: true,
          relative_urls : false,
          remove_script_host : false,
          images_upload_handler: function (blobinfo, success, failure) {
            var data = new FormData();
            data.append('attachable_id', textarea.dataset.id);
            data.append('attachable_type', textarea.dataset.type);
            data.append('image', blobinfo.blob(), blobinfo.filename());
            axios.post(textarea.dataset.url, data)
              .then(function (res) {
                console.log(res.data.url);
                success(res.data.url);
              })
              .catch(function (err) {
                alert(err.response.statusText);
                success('')
              })
          }
        })
      }
    </script>
@endsection
