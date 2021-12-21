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
    <form action="{{route('admin.posts.update', ['post' => $post])}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        @csrf
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Add New Post</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <div class="dropdown mr-2" style="position: relative;">
                    @if ($post->slug)
                        <a target="_blank" class="btn btn-outline-primary w-32" href="{{ route('blog.show', $post->slug) }}"><i class="far fa-eye mr-2"></i> Preview</a>
                    @endif
                    <button class="btn btn-primary w-32"><i class="far fa-save mr-2"></i> Enregistrer</button>
                </div>
            </div>
        </div>

        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                {{-- Titre --}}
                <input type="text" name="name" id="name"
                       class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13" placeholder="Titre"
                       value="{{ $post->name }}">

                <div class="post intro-y overflow-hidden box mt-5 p-5">
                    {{-- Description --}}
                    <div class="mt-3">
                        <label for="description" class="form-label">Meta Description</label>
                        <textarea id="description" name="description" cols="30" rows="3"
                                  class="form-control w-full">{{ $post->description }}</textarea>
                    </div>

                    {{-- Contenu --}}
                    <div class="mt-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea data-id="{{ $post->id }}" data-type="{{ get_class($post) }}"
                                  data-url="{{ route('admin.attachments.store') }}" name="content"
                                  cols="30" rows="20"
                                  class="form-control w-full" id="editor">{{ $post->content }}</textarea>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">

                    {{-- Tags --}}
                    <div>
                        <label for="tags" class="form-label">Tags</label>
                        <input name="tags" id="tags" type="text" class="form-control w-full"
                               value="{{ $tags }}">
                    </div>

                    {{-- Category --}}
                    <div class="mt-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select name="category_id" class="form-control w-full">
                            <option value="">-</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{(int)$category->id === (int)$post->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Parent --}}
                    <div class="mt-3">
                        <label for="parent_id" class="form-label">Article parent</label>
                        <select name="parent_id" class="form-control w-full">
                            <option value="">-</option>
                            @foreach($posts as $parentPost)
                                <option value="{{ $parentPost->id }}" {{(int)$parentPost->id === (int)$post->parent_id ? 'selected' : ''}}>{{ $parentPost->name }}</option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Keywords --}}
                    <div class="mt-3">
                        <label for="keywords" class="form-label">Meta Keywords</label>
                        <input name="keywords" id="keywords" type="text" class="form-control w-full"
                               value="{{ $post->keywords }}">
                    </div>

                    {{-- Main Image --}}
                    <div class="mt-3">
                        <label for="image_id" class="form-label">Image principale</label>
                        <select name="image_id" class="form-control w-full">
                            <option value="">-</option>
                            @foreach($images as $image)
                                <option value="{{ $image->id }}" {{(int)$image->id === (int)$post->image_id ? 'selected' : ''}}>{{ $image->filename }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-check flex-col items-start mt-3">
                        <label for="published" class="form-check-label ml-0 mb-2">En ligne</label>
                        <input id="published" name="published" class="form-check-switch"
                               type="checkbox" {{ $post->published ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>


    </form>

@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/eeni0d95cmhl16ws9y1696cyj98jo1vsmffefbipzzv3hxwd/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
		var textarea = document.querySelector('#editor');

		if (window.tinyMCE) {
			tinymce.init({
				selector: '#editor',
				plugins: 'image,paste,lists,wordcount,link, codesample, preview, table, wordcount, code, hr',
				// plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable',

				menubar: 'file edit view insert format tools table tc help',
				toolbar: 'undo redo | bold italic underline strikethrough hr |  formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist |  preview | image media link codesample | wordcount code',

				paste_data_image: true,
				automatic_uploads: true,
				relative_urls: false,
				remove_script_host: false,
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
