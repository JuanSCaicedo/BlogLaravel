<div class="form-group mb-2">
    <label for="name">Nombre</label>
    <input name="name" id="name" type="text" class="form-control"
        value="{{ isset($post) ? $post->name : old('name') }}" placeholder="Ingrese el nombre del post">

    @error('name')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group mb-2">
    <label for="slug">Slug</label>
    <input readonly name="slug" id="slug" type="text" class="form-control"
        value="{{ isset($post) ? $post->slug : old('slug') }}" placeholder="Ingrese el slug del post">

    @error('slug')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="category_id">Categoria</label>

    <select name="category_id" id="category_id" class="form-control">
        <option value="" selected disabled>-- Seleccione --</option>
        @foreach ($categories as $key => $category)
            <option value="{{ $key }}"
                @if (isset($post) && $post->category == $key) selected @elseif (old('category_id') == $key) selected @endif>
                {{ $category }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <p class="font-weight-bold">Etiquetas</p>

    @foreach ($tags as $tag)
        <label class="mr-2">
            <input type="checkbox" id="{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
            <label for="{{ $tag->id }}">{{ $tag->name }}</label>
        </label>
    @endforeach
</div>

<div class="form-group">
    <p class="font-weight-bold">Estado</p>

    <label class="mr-2">
        <input type="radio" name="status" value="1" checked>
        Borrador
    </label>

    <label>
        <input type="radio" name="status" value="2">
        Publicado
    </label>
</div>

<div class="form-group">
    <label for="extract">Extracto:</label>
    <textarea name="extract" id="extract" class="form-control"></textarea>
</div>

<div class="form-group">
    <label for="body">Cuerpo del post:</label>
    <textarea name="body" id="body" class="form-control"></textarea>
</div>
