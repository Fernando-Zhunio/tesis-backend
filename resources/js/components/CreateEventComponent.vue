<template>
  <form>
    <div class="form-group">
      <label for="name">Nombre del evento:</label>
      <input
        required
        v-model="name"
        type="text"
        placeholder="Escribe el nombre del evento"
        id="name"
        class="form-control"
        name="name"
      />
    </div>
    <div class="row my-3">
      <div class="form-group col-md-6 col-12">
        <label for="description">Descripción:</label>
        <textarea
          required
          name="description"
          placeholder="Escribe una descripción del evento"
          id="description"
          cols="30"
          rows="5"
          class="form-control textarea-description"
          v-model="description"
        ></textarea>
      </div>
      <div class="col-md-6 col-12 position-relative">
        <div class="form-group">
          <label for="image"
            ><span class="btn btn-info rounded-pill fw-bold btn-create-image"
              ><i class="far fa-plus-square"></i> Agregar</span
          ></label>
          <input
            required
            type="file"
            id="image"
            class="form-control d-none"
            @change="onFileChange"
          />
        </div>
        <img :src="image.url" class="w-100 img-event bg-dark rounded-20 shadow" alt="image event" />
        <button
          type="button"
          class="btn btn-danger rounded-pill fw-bold btn-remove-image"
          v-on:click="clearImage"
        >
          <i class="far fa-trash-alt"></i> Eliminar
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="form-group">
          <label for="name">Fechas de inicio del evento</label>
          <input
          readonly
            required
            type="text"
            id="start_date"
            class="form-control"
            name="start_date"
          />
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-group">
          <label for="name">Fechas de fin del evento</label>
          <input
          readonly
            required
            type="text"
            id="end_date"
            class="form-control"
            name="end_date"
          />
        </div>
      </div>
      <div class="col-md-6 col-12 align-items-md-end d-md-flex my-3">
        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            value=""
            id="flexCheckDefault"
            v-model="is_active"
          />
          <label class="form-check-label" for="flexCheckDefault">
            Evento activo? <span class="text-danger">importante!</span>
          </label>
        </div>
      </div>
    </div>
    <div class="card-body shadow-lg mt-3 rounded-20">
      <div class="my-2">Seleccione la posición del evento</div>
      <div class="d-md-flex mb-2">
        <div class="row m-0">
          <div class="form-group col-md-6 col-12">
            <label for="name">Longitud</label>
            <input
              required
              type="text"
              id="lng"
              class="form-control"
              name="lng"
              v-model="lng"
            />
          </div>
          <div class="form-group col-md-6 col-12">
            <label for="name">Latitud</label>
            <input
              required
              type="text"
              id="lat"
              class="form-control"
              name="lat"
              v-model="lat"
            />
          </div>
        </div>
        <div class="d-flex align-content-end btn-apply-location">
          <button
            v-on:click="fly"
            class="btn btn-outline-primary"
            id="fly"
            type="button"
          >
            Aplicar
          </button>
        </div>
      </div>
      <div
        ref="map"
        style="width: 100%; height: 500px"
        class="rounded-20 shadow"
      ></div>
    </div>
    <button
      type="button"
      v-on:click="saveInServer"
      class="btn btn-primary my-2"
    >
      Guardar
    </button>
  </form>
</template>

<script>
import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEs from "air-datepicker/locale/es";

export default {
  data() {
    return {
      center: [-79.89844529968079, -2.181452614962342],
      map: null,
      name: null,
      description: null,
      marker: null,
      lat: null,
      lng: null,
      marker: null,
      start_date: null,
      end_date: null,
      is_active: true,
      url_img_default: "/assets/images/background-default.jpg",
      image: {
        url: "/assets/images/background-default.jpg",
        base64: null,
      },
      isEdit: false,
    };
  },
  props: {
    event_id: {
      type: Number,
      default: null,
    },
  },
  mounted: function () {
    console.log(this.event_id);
    if (this.event_id) {
      this.isEdit = true;
      this.getEvent();
    }
    mapboxgl.accessToken =
      "pk.eyJ1IjoiZmVybmFuZG8xOTkxIiwiYSI6ImNrOGRlcHF2czBxd28zbW5wa3hsaTZnaWcifQ.g1IjAr-9rd65D5W93ftlew";
    (this.lat = this.center[1]),
      (this.lng = this.center[0]),
      (this.map = new mapboxgl.Map({
        container: this.$refs.map,
        style: "mapbox://styles/mapbox/streets-v11",
        center: this.center,
        zoom: 15,
      }));
    this.marker = new mapboxgl.Marker({
      draggable: true,
    })
      .setLngLat(this.center)
      .addTo(this.map);
    this.marker.on("dragend", this.onDragEnd);
    this.start_date = new AirDatepicker("#start_date", {
      locale: localeEs,
      minDate: new Date(),
      multipleDatesSeparator: " - ",
      timepicker: true,
    });

    this.end_date = new AirDatepicker("#end_date", {
      locale: localeEs,
      minDate: new Date(),
      multipleDatesSeparator: " - ",
      timepicker: true,
    });
  },
  methods: {
    // addMarker() {
    //   coordinates.forEach((coordinate) => {
    //     new mapboxgl.Marker({
    //       draggable: true,
    //     })
    //       .setLngLat(coordinate)
    //       .addTo(this.map);
    //     console.log(coordinate);
    //   });
    // },
    getEvent() {
      axios.get(`/events/${this.event_id}/edit`).then((response) => {
        console.log(response.data);
        const {
          name,
          description,
          image,
          status,
          start_date,
          end_date,
          position,
        } = response.data.data;
        this.name = name;
        this.description = description;
        this.image.url = image || this.url_img_default;
        this.is_active = status;
        this.start_date.selectDate([start_date]);
        this.end_date.selectDate([end_date]);
        this.lat = position[1];
        this.lng = position[0];
        this.center = [this.lng, this.lat];
        this.marker.setLngLat(this.center);
      });
    },

    fly() {
      this.center = [this.lng, this.lat];
      this.map.flyTo({
        center: this.center,
        essential: true, // this animation is considered essential with respect to prefers-reduced-motion
      });
      this.marker.setLngLat(this.center);
      console.log(this.dates);
    },

    onDragEnd() {
      const lngLat = this.marker.getLngLat();
      console.log(`Longitude: ${lngLat.lng}<br />Latitude: ${lngLat.lat}`);
      this.lat = lngLat.lat;
      this.lng = lngLat.lng;
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.success, this.error);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    },

    success(showPosition) {
      const lat = showPosition.coords.latitude;
      const lng = showPosition.coords.longitude;
      this.center = [this.lng, this.lat];
      console.log(this.center);
      this.marker.setLngLat(this.center);
      axios
        .get(
          `/waypoints?lng=${this.lng}&lat=${this.lat}&lng_o=${lng}&lat_o=${lat}`
        )
        .then((response) => {
          console.log(response.data.data);
          const res = response.data.data;
          res.forEach((element) => {
            new mapboxgl.Marker({
              draggable: false,
            })
              .setLngLat(element)
              .addTo(this.map);
          });
          // this.marker.setLngLat(this.center);
        });
    },

    error(err) {
      console.error("ERROR(" + err.code + "): " + err.message);
    },
    saveInServer() {
      const data_form = this.getDataForm();
      console.log(data_form);
      if (!this.isEdit) {
        axios
          .post("/events", data_form)
          .then((response) => {
            console.log(response);
            window.location.href = "/events";
            //   this.$emit('save-event', response.data);
          })
          .catch((error) => {
            console.log(error.response.data);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              html: "Algo salio mal!<br>" + error?.response?.data?.errors,
            });
          });
      } else {
        axios
          .post(`/events/${this.event_id}`, data_form)
          .then((response) => {
            console.log(response);
            window.location.href = "/events";
            //   this.$emit('save-event', response.data);
          })
          .catch((error) => {
            console.log(error.response.data);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              html: "Algo salio mal!<br>" + error?.response?.data?.errors,
            });
          });
      }
    },
    getDataForm() {
      let errors = "";
      if (this.name == null || this.name == "") {
        errors += "El nombre es requerido<br>";
      }
      if (this.description == null || this.description == "") {
        errors += "La descripción es requerida<br>";
      }
      if (this.start_date == null || this.end_date == null) {
        errors += "Las fechas son requeridas<br>";
      }
      if (this.lat == null || this.lat == "") {
        errors += "La latitud es requerida<br>";
      }
      if (this.lng == null || this.lng == "") {
        errors += "La longitud es requerida<br>";
      }
      if (errors != "") {
        const error_html = '<div class="text-danger">' + errors + "</div>";
        Swal.fire({
          title: "Error",
          html: error_html,
          icon: "error",
          confirmButtonText: "Cerrar",
        });
        throw new Error("Debe completar todos los campos");
        return false;
      }
      const formData = new FormData();
      const {start_date, end_date} = this.getDates();
      formData.append("name", this.name);
      formData.append("description", this.description);
      formData.append("start_date", start_date);
      formData.append("end_date", end_date);
      formData.append("is_active", this.is_active);
      formData.append("lat", this.lat);
      formData.append("lng", this.lng);
      if (this.image.base64 != null) {
        formData.append("image", this.image.base64);
      }
      if (this.isEdit) {
        formData.append("_method", "PUT");
      }
      return formData;
    },
    getDates() {
      const start_date = this.start_date.selectedDates;
      const end_date = this.end_date.selectedDates;
        // throw new Error("Debe seleccionar un rango de fechas");

      // const dates = this.dates.selectedDates;
      if (start_date != null || end_date != null) {
        return {
          start_date: this.formatDate(start_date[0]),
          end_date: this.formatDate(end_date[0]),
        };
      } else {
        Swal.fire({
          title: "Complete los campos",
          text: "Debe seleccionar un rango de fechas",
          icon: "warning",
          confirmButtonText: "Cerrar",
        });

        throw new Error("Debe seleccionar un rango de fechas");
        return false;
      }
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.image.url = URL.createObjectURL(file);
      this.image.base64 = file;
    },
    clearImage() {
      this.image.url = "/assets/images/background-default.jpg";
      this.image.base64 = null;
    },
    formatDate(date) {
      var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear(),
        hours = d.getHours(),
        minutes = d.getMinutes(),
        seconds = "00";
      if (month.length < 2) month = "0" + month;
      if (day.length < 2) day = "0" + day;
      if (hours.length < 2) hours = "0" + hours;
      if (minutes.length < 2) minutes = "0" + minutes;

      return (
        [year, month, day].join("-") + " " + [hours, minutes, seconds].join(":")
      );
    },
  },
};
</script>

<style>
.btn-remove-image {
  position: absolute;
  top: 35px;
  right: 20px;
}
.btn-create-image {
  position: absolute;
  top: 35px;
  left: 20px;
}

.img-event,
.textarea-description {
  height: 300px;
}

.img-event {
  object-fit: contain;
}
</style>
