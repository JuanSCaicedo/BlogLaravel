<input type="hidden" name="user_id" value="{{auth()->user()->id}}">

<div class="form-group mb-2">
    <label for="name">Nombre</label>
    <input name="name" id="name" type="text" class="form-control"
        value="{{ old('name', isset($post) ? $post->name : '') }}" placeholder="Ingrese el nombre del post">

    @error('name')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group mb-2">
    <label for="slug">Slug</label>
    <input readonly name="slug" id="slug" type="text" class="form-control"
        value="{{ old('slug', isset($post) ? $post->slug : '') }}" placeholder="Ingrese el slug del post">

    @error('slug')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="category_id">Categoria</label>

    <select name="category_id" id="category_id" class="form-control">
        <option value="" selected disabled>-- Seleccione --</option>
        @foreach ($categories as $key => $category)
            <option value="{{ $key }}" @if (old('category_id') == $key || (isset($post) && $post->category == $key)) selected @endif>
                {{ $category }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <p class="font-weight-bold">Etiquetas</p>

    @foreach ($tags as $tag)
        <label class="mr-2">
            <input type="checkbox" id="{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
            <label for="{{ $tag->id }}">{{ $tag->name }}</label>
        </label>
    @endforeach

    @error('tags')
        <br>
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <p class="font-weight-bold">Estado</p>

    <label class="mr-2">
        <input type="radio" id="status_borrador" name="status" value="1" checked
            {{ old('status') === null && !isset($post) ? 'checked' : old('status', isset($post) && $post->status == 1 ? 'checked' : '') }}>
        Borrador
    </label>

    <label>
        <input type="radio" id="status_publicado" name="status" value="2"
            {{ old('status', isset($post) && $post->status == 2 ? 'checked' : '') }}>
        Publicado
    </label>

    @error('status')
        <br>
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="extract">Extracto:</label>
    <textarea name="extract" id="extract" class="form-control">{{ old('extract', isset($post) ? $post->extract : '') }}</textarea>

    @error('extract')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="body">Cuerpo del post:</label>
    <textarea name="body" id="body" class="form-control">{{ old('body', isset($post) ? $post->body : '') }}</textarea>

    @error('body')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
