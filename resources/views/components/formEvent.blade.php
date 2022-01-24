<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" id="name" class="form-control" name="name" value="{{ $event ??  $event?->name }}">
</div>
<div class="form-group">
    <label for="description">Descripcion</label>
    <textarea name="description" id="description" cols="30" rows="5"
        class="form-control">{{ $event ?? $event?->description }}</textarea>
</div>
<div>
    <div class="my-2">Seleccione una posicion del evento</div>
    <div id='map' style='width: 100%; height: 500px;' class="rounded-20 shadow"></div>
</div>
<button type="submit" class="btn btn-primary my-2">Guardar </button>