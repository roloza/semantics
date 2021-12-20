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

    <h2 class="intro-y text-lg font-medium mt-10">Articles</h2>
    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a  href="{{ route('admin.posts.create') }}" class="btn btn-primary shadow-md mr-2">Créer un nouvel article</a>
        </div>


        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

            <table class="table table-report -mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap">Titre</th>
                    <th class="whitespace-nowrap">Tags</th>
                    <th class="whitespace-nowrap">Catégorie</th>
                    <th class="text-center whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($posts as $post)
                    <tr class="intro-x">
                        <td>{{ $post->name }}</td>
                        <td>
                            @foreach($post->tags as $tag)
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded  uppercase last:mr-0 mr-1">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $post->category->name ?? '' }}</td>
                        <td><a  href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-info shadow-md mr-2">Edition</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>



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
          images_upload_handler: function (blobinfo, success, failure) {
            var data = new FormData();
            data.append('attachable_id', textarea.dataset.id);
            data.append('attachable_type', textarea.dataset.type);
            data.append('image', blobinfo.blob(), blobinfo.filename());
            axios.post(textarea.dataset.url, data)
              .then(function (res) {
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
