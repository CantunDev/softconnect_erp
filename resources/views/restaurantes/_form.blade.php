  <form action="{{ route('config.restaurants.store') }}" method="POST" enctype="multipart/form-data" id="restaurantForm">
      @csrf
      @method($method)

      <div class="row">
          <div class="col-lg-8">
              <!-- Información Básica -->
              <div class="card">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Información Básica</h5>
                  </div>
                  <div class="card-body">
                      <div class="row g-3">
                          <div class="col-sm-6 col-lg-4">
                              <label for="inputName" class="form-label">Nombre <span
                                      class="text-danger">*</span></label>
                              <input name="name" type="text"
                                  class="form-control @error('name') is-invalid @enderror" id="inputName"
                                  placeholder="Ej: Nombre Restaurante" value="{{ old('name', $restaurant->name) }}">
                              @error('name')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-8">
                              <label for="inputDescription" class="form-label">Descripción</label>
                              <input name="description" type="text"
                                  class="form-control @error('description') is-invalid @enderror" id="inputDescription"
                                  placeholder="Ej: Descripción del restaurante"
                                  value="{{ old('description', $restaurant->description) }}">
                              @error('description')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Colores del Restaurante -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Colores del Restaurante</h5>
                  </div>
                  <div class="card-body">
                      <div class="row g-3">
                          <div class="col-sm-6 col-lg-4">
                              <label for="color_primary" class="form-label">Color primario</label>
                              <input name="color_primary" type="color"
                                  class="form-control form-control-color @error('color_primary') is-invalid @enderror"
                                  id="color_primary" value="{{ old('color_primary', $restaurant->color_primary) }}"
                                  style="height: 38px;">
                              @error('color_primary')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <label for="color_secondary" class="form-label">Color secundario</label>
                              <input name="color_secondary" type="color"
                                  class="form-control form-control-color @error('color_secondary') is-invalid @enderror"
                                  id="color_secondary"
                                  value="{{ old('color_secondary', $restaurant->color_secondary) }}"
                                  style="height: 38px;">
                              @error('color_secondary')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                          <div class="col-sm-6 col-lg-4">
                              <label for="color_accent" class="form-label">Color de Acento</label>
                              <input name="color_accent" type="color"
                                  class="form-control form-control-color @error('color_accent') is-invalid @enderror"
                                  id="color_accent" value="{{ old('color_accent', $restaurant->color_accent) }}"
                                  style="height: 38px;">
                              @error('color_accent')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Ocupación y Capacidad -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Ocupación y Capacidad</h5>
                  </div>
                  <div class="card-body">
                      <div class="row g-3">
                          <div class="col-sm-6 col-lg-3">
                              <label for="occupancy_status" class="form-label">Estado de Ocupación</label>
                              <select name="occupancy_status"
                                  class="form-control @error('occupancy_status') is-invalid @enderror"
                                  id="occupancy_status">
                                  <option value="low"
                                      {{ old('occupancy_status', $restaurant->occupancy_status) == 'low' ? 'selected' : '' }}>
                                      Baja
                                  </option>
                                  <option value="moderate"
                                      {{ old('occupancy_status', $restaurant->occupancy_status) == 'moderate' ? 'selected' : '' }}
                                      selected>Moderada
                                  </option>
                                  <option value="high"
                                      {{ old('occupancy_status', $restaurant->occupancy_status) == 'high' ? 'selected' : '' }}>
                                      Alta
                                  </option>
                                  <option value="full"
                                      {{ old('occupancy_status', $restaurant->occupancy_status) == 'full' ? 'selected' : '' }}>
                                      Lleno
                                  </option>
                                  <option value="closed"
                                      {{ old('occupancy_status', $restaurant->occupancy_status) == 'closed' ? 'selected' : '' }}>
                                      Cerrado</option>
                              </select>
                              @error('occupancy_status')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="total_capacity" class="form-label">Capacidad Total</label>
                              <input name="total_capacity" type="number" min="0"
                                  class="form-control @error('total_capacity') is-invalid @enderror" id="total_capacity"
                                  placeholder="Ej: 100"
                                  value="{{ old('total_capacity', $restaurant->total_capacity) }}">
                              @error('total_capacity')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="current_occupancy" class="form-label">Ocupación Actual</label>
                              <input name="current_occupancy" type="number" min="0"
                                  class="form-control @error('current_occupancy') is-invalid @enderror"
                                  id="current_occupancy" placeholder="Ej: 45"
                                  value="{{ old('current_occupancy', 0) }}">
                              @error('current_occupancy')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="tables_count" class="form-label">Número de Mesas</label>
                              <input name="tables_count" type="number" min="0"
                                  class="form-control @error('tables_count') is-invalid @enderror" id="tables_count"
                                  placeholder="Ej: 20" value="{{ old('tables_count', $restaurant->tables_count) }}">
                              @error('tables_count')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Ubicación y Geolocalización CON MAPA -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Ubicación y Geolocalización</h5>
                  </div>
                  <div class="card-body">
                      <!-- Contenedor del mapa -->
                      <div id="map"
                          style="height: 350px; width: 100%; margin-bottom: 15px; border-radius: 5px;">
                      </div>

                      <div class="row g-3">
                          <div class="col-sm-12">
                              <label for="address" class="form-label">Dirección</label>
                              <input name="address" type="text"
                                  class="form-control @error('address') is-invalid @enderror" id="address"
                                  placeholder="Ej: Av. Principal #123"
                                  value="{{ old('address', $restaurant->address) }}">
                              @error('address')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="city" class="form-label">Ciudad</label>
                              <input name="city" type="text"
                                  class="form-control @error('city') is-invalid @enderror" id="city"
                                  placeholder="Ej: Ciudad de México" value="{{ old('city', $restaurant->city) }}">
                              @error('city')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="state" class="form-label">Estado</label>
                              <input name="state" type="text"
                                  class="form-control @error('state') is-invalid @enderror" id="state"
                                  placeholder="Ej: CDMX" value="{{ old('state', $restaurant->state) }}">
                              @error('state')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="country" class="form-label">País</label>
                              <input name="country" type="text"
                                  class="form-control @error('country') is-invalid @enderror" id="country"
                                  placeholder="Ej: México" value="{{ old('country', 'México') }}">
                              @error('country')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="postal_code" class="form-label">Código Postal</label>
                              <input name="postal_code" type="text"
                                  class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
                                  placeholder="Ej: 12345" value="{{ old('postal_code', $restaurant->postal_code) }}">
                              @error('postal_code')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-6">
                              <label for="latitude" class="form-label">Latitud</label>
                              <input name="latitude" type="number" step="any"
                                  class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                  placeholder="Ej: 19.432608" value="{{ old('latitude', $restaurant->latitude) }}"
                                  readonly>
                              @error('latitude')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-6">
                              <label for="longitude" class="form-label">Longitud</label>
                              <input name="longitude" type="number" step="any"
                                  class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                                  placeholder="Ej: -99.133209" value="{{ old('longitude', $restaurant->longitude) }}"
                                  readonly>
                              @error('longitude')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-12">
                              {{-- <button type="button" class="btn btn-outline-secondary" id="getCurrentLocation">
                                  <i class="mdi mdi-map-marker"></i> Obtener mi ubicación actual
                              </button> --}}
                              <button type="button" class="btn btn-outline-primary" id="resetMap">
                                  <i class="mdi mdi-refresh"></i> Centrar mapa
                              </button>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Configuración del Reloj Checador CON CHECKBOX ACTIVAR/DESACTIVAR -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <div class="d-flex justify-content-between align-items-center">
                          <h5 class="card-title mb-0 text-white">Configuración del Reloj Checador</h5>
                          <div class="form-check form-switch">
                              <input type="checkbox" name="timeclock_active" class="form-check-input"
                                  id="timeclock_active" value="1"
                                  {{ old('timeclock_active', $restaurant->timeclock_active) ? 'checked' : '' }}>
                              <label class="form-check-label text-white" for="timeclock_active">Activar
                                  Checador</label>
                          </div>
                      </div>
                  </div>
                  <div class="card-body" id="checkerFields"
                      style="{{ old('timeclock_active', $restaurant->timeclock_active) ? '' : 'display: none;' }}">
                      <div class="row g-3">
                          <div class="col-sm-6 col-lg-4">
                              <label for="timeclock_host" class="form-label">Host/IP <span
                                      class="text-danger">*</span></label>
                              <input name="timeclock_host" type="text"
                                  class="form-control @error('timeclock_host') is-invalid @enderror"
                                  id="timeclock_host" placeholder="Ej: 192.168.1.100"
                                  value="{{ old('timeclock_host') }}">
                              @error('timeclock_host')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-3">
                              <label for="timeclock_port" class="form-label">Puerto</label>
                              <input name="timeclock_port" type="number" min="1" max="65535"
                                  class="form-control @error('timeclock_port') is-invalid @enderror"
                                  id="timeclock_port" placeholder="Ej: 4370"
                                  value="{{ old('timeclock_port', '4370') }}">
                              @error('timeclock_port')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-5">
                              <label for="timeclock_type" class="form-label">Tipo/Marca</label>
                              <select name="timeclock_type"
                                  class="form-control @error('timeclock_type') is-invalid @enderror"
                                  id="timeclock_type">
                                  <option value="">Seleccione una opción</option>
                                  <option value="steren"
                                      {{ old('timeclock_type', $restaurant->timeclock_type) == 'steren' ? 'selected' : '' }}>
                                      BioRhythm</option>
                                  <option value="zkteco"
                                      {{ old('timeclock_type', $restaurant->timeclock_type) == 'zkteco' ? 'selected' : '' }}>
                                      ZKTeco</option>
                                  <option value="biorhythm"
                                      {{ old('timeclock_type', $restaurant->timeclock_type) == 'biorhythm' ? 'selected' : '' }}>
                                      BioRhythm</option>
                                  <option value="suprema"
                                      {{ old('timeclock_type', $restaurant->timeclock_type) == 'suprema' ? 'selected' : '' }}>
                                      Suprema</option>
                                  <option value="otros"
                                      {{ old('timeclock_type', $restaurant->timeclock_type) == 'otros' ? 'selected' : '' }}>
                                      Otros
                                  </option>
                              </select>
                              @error('timeclock_type')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="timeclock_serial" class="form-label">Número de Serie</label>
                              <input name="timeclock_serial" type="text"
                                  class="form-control @error('timeclock_serial') is-invalid @enderror"
                                  id="timeclock_serial" placeholder="Ej: SN12345678"
                                  value="{{ old('timeclock_serial', $restaurant->timeclock_serial) }}">
                              @error('timeclock_serial')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="timeclock_database" class="form-label">Base de Datos</label>
                              <input name="timeclock_database" type="text"
                                  class="form-control @error('timeclock_database') is-invalid @enderror"
                                  id="timeclock_database" placeholder="Ej: reloj_checador"
                                  value="{{ old('timeclock_database', $restaurant->timeclock_database) }}">
                              @error('timeclock_database')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="timeclock_username" class="form-label">Usuario</label>
                              <input name="timeclock_username" type="text"
                                  class="form-control @error('timeclock_username') is-invalid @enderror"
                                  id="timeclock_username" placeholder="Ej: admin"
                                  value="{{ old('timeclock_username', $restaurant->timeclock_username) }}">
                              @error('timeclock_username')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="timeclock_password" class="form-label">Contraseña</label>
                              <div class="input-group">
                                  <input name="timeclock_password" type="password"
                                      class="form-control @error('timeclock_password') is-invalid @enderror"
                                      id="timeclock_password" placeholder="••••••••"
                                      value="{{ old('timeclock_password', $restaurant->timeclock_password) }}">
                                  <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                      <i class="mdi mdi-eye"></i>
                                  </button>
                              </div>
                              @error('timeclock_password')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Configuración de Base de Datos Externa -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Configuración de Base de Datos Externa</h5>
                  </div>
                  <div class="card-body">
                      <div class="row g-3">
                          <div class="col-sm-6 col-lg-4">
                              <label for="ip" class="form-label">VPN IP</label>
                              <input name="ip" type="text" placeholder="Ej: 192.168.1.100"
                                  class="form-control text-uppercase @error('ip') is-invalid @enderror"
                                  id="ip" value="{{ old('ip', $restaurant->ip) }}">
                              @error('ip')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="db_port" class="form-label">Puerto</label>
                              <input name="db_port" type="text"
                                  class="form-control @error('db_port') is-invalid @enderror" id="db_port"
                                  placeholder="Ej: 3306" value="{{ old('db_port', '3306') }}">
                              @error('db_port')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="database" class="form-label">Base de Datos</label>
                              <input type="text" name="database" id="database"
                                  class="form-control @error('database') is-invalid @enderror"
                                  placeholder="Ej: nombre_bd" value="{{ old('database', $restaurant->database) }}">
                              @error('database')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="db_username" class="form-label">Usuario</label>
                              <input type="text" name="db_username" id="db_username"
                                  class="form-control @error('db_username') is-invalid @enderror"
                                  placeholder="Ej: root" value="{{ old('db_username', $restaurant->db_username) }}">
                              @error('db_username')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="db_password" class="form-label">Contraseña</label>
                              <input type="password" name="db_password" id="db_password"
                                  class="form-control @error('db_password') is-invalid @enderror"
                                  placeholder="••••••••" value="{{ old('db_password', $restaurant->db_password) }}">
                              @error('db_password')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6 col-lg-4">
                              <label for="db_connection_type" class="form-label">Tipo de Conexión</label>
                              <select name="db_connection_type"
                                  class="form-control @error('db_connection_type') is-invalid @enderror"
                                  id="db_connection_type">
                                  <option value="mysql"
                                      {{ old('db_connection_type', $restaurant->db_connection_type) == 'mysql' ? 'selected' : '' }}>
                                      MySQL</option>
                                  <option value="pgsql"
                                      {{ old('db_connection_type', $restaurant->db_connection_type) == 'pgsql' ? 'selected' : '' }}>
                                      PostgreSQL</option>
                                  <option value="sqlsrv"
                                      {{ old('db_connection_type', $restaurant->db_connection_type) == 'sqlsrv' ? 'selected' : '' }}>
                                      SQL Server</option>
                              </select>
                              @error('db_connection_type')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-4">
              <!-- Logo del Restaurante -->
              <div class="card">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Logo del Restaurante</h5>
                  </div>
                  <div class="card-body">
                      <div class="image-upload-container text-center mb-4">
                          <div class="image-preview-wrapper">
                              <img id="imagePreview"
                                  src="{{ $restaurant->restaurant_file ? asset('storage/restaurants/' . $restaurant->restaurant_file) : 'https://markleisherproductions.com/wp-content/uploads/2021/01/logo-placeholder-png-2.png' }}"
                                  alt="Previsualización" class="img-thumbnail mb-3"
                                  style="max-width: 100%; max-height: 200px; cursor: pointer;"
                                  onclick="document.getElementById('inputLogo').click();">
                          </div>

                          <div class="mb-3">
                              <label for="inputLogo" class="form-label">Seleccionar imagen</label>
                              <input type="file" name="restaurant_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                                  class="form-control @error('restaurant_file') is-invalid @enderror">
                              @error('restaurant_file')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                              <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG</small>
                          </div>

                          <div class="image-options d-none">
                              <button type="button" class="btn btn-outline-danger btn-sm w-100" id="removeImage">
                                  <i class="mdi mdi-delete-outline me-1"></i> Quitar imagen
                              </button>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Resumen y Acciones -->
              <div class="card mt-3">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0 text-white">Acciones</h5>
                  </div>
                  <div class="card-body">
                      <div class="d-grid gap-2">
                          <button type="submit" class="btn btn-primary btn-lg">
                              <i class="mdi mdi-plus-circle-outline me-1"></i> Crear Restaurante
                          </button>
                          <a class="btn btn-outline-secondary" href="{{ route('config.restaurants.index') }}">
                              <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </form>
