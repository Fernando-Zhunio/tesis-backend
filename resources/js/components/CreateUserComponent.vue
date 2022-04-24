<template>
  <div class="container">
    <h2>Creando usuario</h2>
    <div>
      <form @submit.prevent="createUser" class="form-group">
        <div class="form-group">
          <label for="name">Nombre</label>
          <input
            type="text"
            class="form-control"
            id="name"
            v-model="user.name"
          />
        </div>
        <div class="form-group">
          <label for="name">Fecha de nacimiento</label>
          <input
            type="text"
            class="form-control"
            id="name"
            v-model="user.birthday"
          />
        </div>
        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            value=""
            id="flexCheckDefault"
            v-model="user.is_student"
          />
          <label class="form-check-label" for="flexCheckDefault">
            Es estudiante?
          </label>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            v-model="user.email"
          />
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input
            type="password"
            class="form-control"
            id="password"
            v-model="user.password"
          />
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirmar contraseña</label>
          <input
            type="password"
            class="form-control"
            id="password_confirmation"
            v-model="user.password_confirmation"
          />
        </div>
        <button type="submit" class="btn btn-primary">Crear usuario</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
        user: {
            name: "",
            birthday: "",
            is_student: false,
            email: "",
            password: "",
            password_confirmation: "",
        },
    };
  },
    methods: {
        createUser() {
            axios
                .post("/users", this.user)
                .then((response) => {
                    console.log(response);
                    this.$router.push("/users");
                })
                .catch((e) => {
                    console.log(e);
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
