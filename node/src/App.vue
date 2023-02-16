<template>
  <div v-if="$store.state.auth.logged">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Cobranças - Amar Assist</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <router-link class="nav-link" to="/clientes">Clientes</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/cobrancas">Cobranças</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" @click="logoff()" to="/sair">Sair</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mt-3">
      <router-view></router-view>
    </div>
  </div>
  <div v-else>
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <form class="p-4 bg-light border rounded-3" @submit.prevent="handleSubmit">
        <h1 class="text-center mb-4">Login</h1>
        <div class="form-floating mb-3">
          <input v-model="auth.email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
          <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
          <input v-model="auth.password" type="password" class="form-control" id="password" placeholder="Senha" required>
          <label for="password">Senha</label>
        </div>
        <div class="d-grid">
          <button @click="login();" class="btn btn-primary">Entrar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    name: "App",
    data() {
      return {
        auth: {
          email: 'admin@amar.com.br',
          password: 'admin'
        }
      }
    },
    mounted() {
      console.log('Componente montado!')
    },
    methods: {
      async login() {

        const payload = {
          email: this.auth.email,
          password: this.auth.password
        };

        try {
          const response = await this.$http.post('/login', payload);
          console.log('response', response.data);

          const auth = {
            name: this.auth.email,
            token: response.data.token
          }

          this.$store.commit('login', auth );

        } catch (error) {
          console.log('error', error);
        }
      },
      logoff() {
        this.$store.commit('logoff');
      },
    }
  };
</script>