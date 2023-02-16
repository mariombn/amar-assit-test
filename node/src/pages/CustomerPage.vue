<template>
  <div class="container my-3">
    <div v-if="error !== null" class="alert alert-danger" role="alert">
      {{ error }}
    </div>
    <div v-if="!editMode">
      <h1>Filtro de Clientes</h1>

      <form class="row">
        <div class="col-12 col-md-4 mb-2">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" v-model="searchFilter.name">
        </div>
        <div class="col-12 col-md-4 mb-2">
          <label for="documento" class="form-label">Documento:</label>
          <input type="number" class="form-control" id="documento" v-model="searchFilter.document" :max="99999999999999">
        </div>
        <div class="col-12 col-md-4 mb-2">
          <label for="status" class="form-label">Status:</label>
          <select class="form-select" id="status" v-model="searchFilter.status">
            <option value="">Todos</option>
            <option value="active">Ativo</option>
            <option value="inactive">Inativo</option>
          </select>
        </div>
        <div class="col-12 text-end">
          <button type="button" class="btn btn-primary" @click="buscarClientes">Buscar</button>
        </div>
      </form>

      <hr>

      <table class="table table-hover">
        <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Documento</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="customerLine in customers" :key="customerLine.id">
          <td>{{ customerLine.id }}</td>
          <td>{{ customerLine.name }}</td>
          <td>{{ customerLine.document }}</td>
          <td>{{ customerLine.status }}</td>
          <td>
            <button type="button" class="btn btn-outline-primary" @click="abrirModal(customerLine)">Editar</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <h1>Edição de Clientes</h1>
      <form>
        <div class="mb-3">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" v-model="customer.name">
        </div>
        <div class="mb-3">
          <label for="documento" class="form-label">Documento:</label>
          <input type="number" class="form-control" id="documento" v-model="customer.document" :max="99999999999999">
        </div>
        <div class="mb-3">
          <label for="endereco" class="form-label">Endereço:</label>
          <input type="text" class="form-control" id="endereco" v-model="customer.address">
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status:</label>
          <select class="form-select" id="status" v-model="customer.status">
            <option value="active">Ativo</option>
            <option value="inactive">Inativo</option>
          </select>
        </div>
      </form>
      <button type="button" class="btn btn-outline-primary" @click="fecharModal()">Voltar</button>
      <button type="button" class="btn btn-outline-success" @click="salvarCliente()">Salvar</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      error: null,
      searchFilter: {
        name: '',
        document: null,
        status: ''
      },
      editMode: false,
      customer: {
        id: null,
        nome: null,
        document: null,
        address: null,
        contact: null,
        status: null
      },
      customers: []
    };
  },
  mounted() {
    this.buscarClientes();
  },
  methods: {
    async buscarClientes() {
      try {
        this.clearError();
        const response = await this.$http.post('/customer', this.searchFilter);
        this.customers = response.data.data;
      } catch (error) {
        this.error = error.response.data.message;
      }
    },
    abrirModal(customer) {
      this.customer = customer;
      this.editMode = true;
    },
    fecharModal() {
      this.editMode = false;
    },
    async salvarCliente() {
      try {
        this.clearError();
        await this.$http.put('/customer/' + this.customer.id, this.customer);
        this.fecharModal();
        await this.buscarClientes();
      } catch (error) {
        this.error = error.response.data.message;
      }
    },
    clearError() {
      this.error = null
    }
  }
};
</script>