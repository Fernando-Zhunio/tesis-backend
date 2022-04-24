// var center = [-79.89844529968079, -2.181452614962342];
// mapboxgl.accessToken = 'pk.eyJ1IjoiZmVybmFuZG8xOTkxIiwiYSI6ImNrOGRlcHF2czBxd28zbW5wa3hsaTZnaWcifQ.g1IjAr-9rd65D5W93ftlew';
// var map = new mapboxgl.Map({
//     container: 'map',
//     style: 'mapbox://styles/mapbox/streets-v11',
//     center,
//     zoom: 15
// });

// document.getElementById("lat").value = center[1];
// document.getElementById("lng").value = center[0];


// const marker = new mapboxgl.Marker({
//         draggable: true
//     })
//     .setLngLat(center)
//     .addTo(map);

// function onDragEnd() {
//     const lngLat = marker.getLngLat();
//     console.log(`Longitude: ${lngLat.lng}<br />Latitude: ${lngLat.lat}`);
//     document.getElementById("lat").value = lngLat.lat;
//     document.getElementById("lng").value = lngLat.lng;
// }

// marker.on('dragend', onDragEnd);

// document.getElementById('fly').addEventListener('click', () => {
//     center = [document.getElementById("lng").value, document.getElementById("lat").value];
//     map.flyTo({
//         center,
//         essential: true // this animation is considered essential with respect to prefers-reduced-motion
//     });
//     marker.setLngLat(center)
// });

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('create-events-component', require('./components/CreateEventComponent.vue').default);
Vue.component('events-list-component', require('./components/EventsListComponent.vue').default);
Vue.component('create-user-component', require('./components/CreateUserComponent.vue').default);
Vue.component('users-list-component', require('./components/UsersIndexComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
