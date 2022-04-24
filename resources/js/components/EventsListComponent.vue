<template>
  <div class="container">
    <div class="">
      <div
        class="
          my-3
          sticky-top
          d-flex
          justify-content-between
          align-content-center
          pt-3
          bg-white
        "
      >
        <div class="d-flex align-items-center">
          <h2 class="me-2 m-0">Eventos</h2>
          <div class="center justify-content-start">
            <button class="px-3 border-0 position-absolute bg-transparent">
              <i class="fas fa-search"></i>
            </button>
            <input
              v-model="searchText"
              placeholder="Buscador de eventos"
              type="text"
              class="input-search"
            />
          </div>
        </div>
        <div>
          <a
            href="/events/create"
            class="btn btn-sm mx-2 btn-warning rounded-pill text-white"
          >
            <i class="fas fa-plus"></i> Crear evento
          </a>
          <!-- <span class="dropdown">
            <button
              class="btn rounded-pill btn-secondary dropdown-toggle"
              type="button"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fas fa-filter"></i> Filtros
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </span> -->
        </div>
      </div>
      <div v-if="isLoading">
        <div class="text-center">
          Cargando...
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
        </div>
      </div>
      <div class="text-center display-2" v-if="events.length < 1 && !isLoading">
        Sin resultados
      </div>
      <div v-if="events.length > 0 && !isLoading" class="row">
        <div
          class="col-md-4 col-12"
          v-for="event in events"
          v-bind:key="event.id"
        >
          <div class="card mb-4 shadow-sm">
            <img
              class="card-img-top"
              :src="
                event.image
                  ? event.image
                  : 'assets/images/background-default.jpg'
              "
              alt="Card image cap"
            />
            <div class="card-body">
              <p
               :class="event.status  =='1'? 'text-success' :
                  'text-danger'"
                class="
                  card-text
                "
              >
                {{ event.status ? "Activo" : "Inactivo" }}
              </p>
              <p>{{ event.created_at }}</p>
              <p class="m-0 fs-5 text-secondary">{{ event.name }}</p>
              <p class="card-text">{{ event.description }}</p>
              <div class="badge bg-info">Inicia: {{ event.start_date }}</div>
              <div class="badge bg-warning">Finaliza: {{ event.end_date }}</div>
              <br />
              <a
                :href="'events/' + event.id + '/edit'"
                class="btn rounded-pill btn-primary mt-2"
                >Editar <i class="far fa-edit"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      events: [],
      searchText: "",
      isLoading: false,
    };
  },
  watch: {
    searchText: function (val) {
      console.log(val);
      this.searchEvents();
    },
  },
  mounted() {
    this.searchEvents();
  },
  methods: {
    searchEvents() {
      this.isLoading = true;
      axios
        .get("/events?search=" + this.searchText)
        .then((response) => {
          this.events = response.data.data;
          console.log(this.events);
          this.isLoading = false;
        })
        .catch((e) => {
          console.log(e);
          this.isLoading = false;
        });
    },
  },
};
</script>

<style>
.input-search {
  border: none;
  background: #e9ecef;
  height: 40px;
  min-width: 250px;
  border-radius: 10px;
  padding-left: 50px;
  outline: none;
}
</style>
