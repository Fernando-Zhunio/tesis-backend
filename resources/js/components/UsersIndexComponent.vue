<template>
  <div class="container">
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
        <h2 class="me-2 m-0">Usuarios</h2>
        <div class="center justify-content-start">
          <button class="px-3 border-0 position-absolute bg-transparent">
            <i class="fas fa-search"></i>
          </button>
          <input
            v-model="searchText"
            placeholder="Buscador de usuarios"
            type="text"
            class="input-search"
          />
        </div>
      </div>
      <div>
        <a
          href="/users/create"
          class="btn btn-sm mx-2 btn-warning rounded-pill text-white"
        >
          <i class="fas fa-plus"></i> Crear usuario
        </a>
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
    <div class="card-body shadow rounded-20">
      <table class="table table-borderless table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombres</th>
            <th>Email</th>
            <th>Fecha Nacimiento</th>
            <th>Rol</th>
            <th>Estudiante?</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" v-bind:key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.birthday }}</td>
            <!-- <td>{{ user.role }}</td> -->
            <td>{{ user.roles[0].description }}</td>

            <td>{{ user.is_student }}</td>
            <td>

                <button @click="quitAdmin(user.id)" v-if="user.roles[0].name == 'admin'" type="submit" class="btn btn-sm btn-warning">
                  Quitar administrador
                </button>

                <button @click="beAdmin(user.id)" v-else type="submit" class="btn btn-sm btn-success">
                  Hacer Administrador
                </button>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteUser(user.id)"
              >
                Eliminar
              </button>
            </td>
          </tr>
          <tr class="text-center" v-if="users.length < 1 && !isLoading">
            <td colspan="7" class="text-danger">Sin resultados</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      users: [],
      isLoading: false,
      searchText: "",
    };
  },
  watch: {
    searchText: function (val) {
      this.searchUsers();
    },
  },
  mounted() {
    this.searchUsers();
  },
  methods: {
    searchUsers() {
      this.isLoading = true;
      axios
        .get("/users?search=" + this.searchText)
        .then((response) => {
          this.users = response.data.data;
          this.isLoading = false;
        })
        .catch((e) => {
          console.log(e);
          this.isLoading = false;
        });
    },
    deleteUser(id) {
      swal
        .fire({
          icon: "warning",
          title: "¿Estás seguro?",
          text: "No podrás revertir esto",
        })
        .then((res) => {
          if (res.isConfirmed) {
            axios
              .delete("/users/" + id)
              .then((response) => {
                this.searchUsers();
              })
              .catch((e) => {
                console.log(e.response.data.errors);
                swal.fire("Error", e.response.data.errors, "error");
              });
          }
        });
    },
    beAdmin(id) {
      axios
        .put("/users/" + id + "/admin")
        .then((response) => {
          this.searchUsers();
        })
        .catch((e) => {
          console.log(e.response.data.errors);
          swal.fire("Error", e.response.data.errors, "error");
        });
    },
    quitAdmin(id) {
      axios
        .put("/users/" + id + "/quit-admin")
        .then((response) => {
          this.searchUsers();
        })
        .catch((e) => {
          console.log(e.response.data.errors);
          swal.fire("Error", e.response.data.errors, "error");
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
