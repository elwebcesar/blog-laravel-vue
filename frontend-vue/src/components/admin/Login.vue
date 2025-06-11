<template>
  <div class="container-sm mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center">Iniciar Sesión</h2>
            <!-- <form @submit.prevent="login"> with localstorage -->
            <form @submit.prevent="handleLogin">
              <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="email"
                  required
                />
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="password"
                  required
                />
              </div>

              <hr>
              <div class="container-fluid d-flex justify-content-between g-1">
                <router-link :to="{ name: 'BlogPostsPagination' }" class="btn btn-dark">&#8592; Volver</router-link>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<!--
ACCESS
elwebcesar@gmail.com
holamundo
-->

<script>
/*
// VALIDATE WITH AXIOS

import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/v1/auth/login', {
          email: this.email,
          password: this.password,
        });
        console.log('Inicio de sesión exitoso:', response.data);
        const token = response.data.resultado.data.token;
        console.log('Token generado:', token);

        // Save token in localStorage
        // localStorage.setItem('token', token);
        // console.log('Token guardado en localStorage.');

      } catch (error) {
        console.error('Error al iniciar sesión:', error);
        alert('Error al iniciar sesión. Por favor, verifica tus credenciales.');
      }
    },
  },
};
*/


// VALIDATE WITH VUEX

import { mapActions } from 'vuex';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    ...mapActions(['login']),
    async handleLogin() {
      try {
        const token = await this.login({ email: this.email, password: this.password });
        console.log('Successful login:', token);
        // redirect
        this.$router.push('/dashboard');
      } catch (error) {
        console.error('Login failed:', error);
        alert('Error al iniciar sesión. Por favor, verifica tus datos.');
      }
    },
  },
};
</script>
