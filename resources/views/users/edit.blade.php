@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Nueva usuario
        @endslot
        @slot('bcPrevText')
            Usuario
        @endslot
        @slot('bcPrevLink')
            {{ route('users.index') }}
        @endslot
        @slot('bcActiveText')
            Nueva usuario
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
            <form id="create_users" class="row g-3" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-sm-6 col-lg-4">
                    <label for="inputName" class="form-label">Nombre</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        id="inputName" placeholder="Nombre" value="{{ $user->name }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputBusinessName" class="form-label">A. Paterno</label>
                    <input name="lastname" type="text"
                        class="form-control @error('lastname ') is-invalid @enderror" id="inputBusinessName"
                        placeholder="Apellido" value="{{ $user->lastname }}">
                    @error('lastname ')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputRfc" class="form-label">A. Materno</label>
                    <input name="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                        id="surname" placeholder="Apellido" value="{{ $user->surname }}">
                    @error('surname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <label for="inputPhone" class="form-label">Teléfono</label>
                    <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                        id="inputPhone" minlength="10" maxlength="15" placeholder="Ej: 9380000000"
                        value="{{ $user->phone }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputEmail" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="inputEmail"
                        class="form-control text-lowercase @error('email') is-invalid @enderror"
                        placeholder="softconnect_erp@mail.com" value="{{ $user->email }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4">
                    <label for="inputLogo" class="form-label">Imagen <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="file" name="user_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                        class="form-control @error('user_file') is-invalid @enderror">
                    @error('user_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Seleccina tu empresa</h4>

            <div class="row g-3">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <select class="form-control selectpicker" multiple name="business_id" id="business_id">
                        <option disabled >Selecciona una opcion</option>
                        @foreach ($business as $bs)
                        <option value="{{ $bs->id }}" {{ in_array($bs->id, $user->business->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $bs->business_name }}</option>
                        @endforeach
                    </select>
                    @error('business_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 col-md-3 col-lg-6">
                    <h4 class="card-title mb-4">Selecciona tu restaurante</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0" id="restaurants-table">
                            <tbody id="restaurants-body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Cancelar</a>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        if ($.fn.selectpicker) {
            $('.selectpicker').selectpicker();
        } else {
            console.error("Bootstrap Select no está cargado.");
        }
    });
</script>

<script>
 $(document).ready(function() {
$('#business_id').on('change', function() {
    var businessIds = $(this).val(); // Obtener los IDs seleccionados
    $('#restaurants-body').empty(); // Limpiar la tabla antes de agregar nuevos datos

    if (businessIds && businessIds.length > 0) {
        // Enviar los IDs seleccionados al servidor
        $.ajax({
            url: "{{ route('restaurants.get') }}", // Ruta para obtener los restaurantes
            type: 'POST',
            dataType: 'json',
            data: {
                business_ids: businessIds // Enviar los IDs como un array
            },
            success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(index, restaurant) {
                        var imageUrl = restaurant?.restaurant_file ?
                            `${restaurant.restaurant_file}` :
                            `https://avatar.oxro.io/avatar.svg?name=${encodeURIComponent(restaurant.name || 'Restaurante')}&caps=3&bold=true`;

                        var row = `
                            <tr>
                                <td style="width: 40px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" name="restaurant_ids[]" value="${restaurant.id}" id="restaurantCheck${restaurant.id}">
                                        <label class="form-check-label" for="restaurantCheck${restaurant.id}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group-item me-2">
                                            <a href="javascript: void(0);" class="d-inline-block">
                                                <img src="${imageUrl}" alt="" class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                        <h5 class="text-truncate font-size-14 m-0 ms-2">
                                            <a href="#" class="text-dark">${restaurant.name}</a>
                                        </h5>
                                    </div>
                                </td>
                            </tr>`;
                        $('#restaurants-body').append(row);
                    });
                } else {
                    $('#restaurants-body').append(
                        '<tr><td colspan="4" class="text-center">No se encontraron restaurantes.</td></tr>'
                    );
                }
            },
            error: function() {
                alert('Error al cargar los restaurantes.');
            }
        });
    } else {
        $('#restaurants-body').append(
            '<tr><td colspan="4" class="text-center">Seleccione al menos un negocio.</td></tr>'
        );
    }
});
});
</script>
<script>
    $('#create_users').on('submit', function (e) {
      e.preventDefault(); 
      var seleccionados = [];
        $('input[name="restaurant_ids[]"]:checked').each(function () {
            seleccionados.push($(this).val());
        });
      // console.log('Seleccionados:', seleccionados);
      if (seleccionados.length === 0) {
          alert('Debe seleccionar al menos un restaurante.');
          return; 
      }
      $('#restaurant_ids_field').remove();
      $('<input>')
          .attr('type', 'hidden')
          .attr('name', 'restaurant_ids') 
          .attr('id', 'restaurant_ids_field')
          .val(seleccionados.join(','))
          .appendTo('#create_users'); 
      this.submit();
      });
  </script>

@endsection
