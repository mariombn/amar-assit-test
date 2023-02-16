<template>
  <div class="container my-3">
    <div v-if="error !== null" class="alert alert-danger" role="alert">
      {{ error }}
    </div>
    <div v-if="!editMode">
      <h1>Filtro de Clientes</h1>

      <form class="row">
        <div class="col-12 col-md-4 mb-2">
          <label for="nome" class="form-label">Periodo Inicial:</label>
          <input type="date" class="form-control" id="dataInicial" v-model="searchFilter.date_start" />
        </div>
        <div class="col-12 col-md-4 mb-2">
          <label for="documento" class="form-label">Periodo Final:</label>
          <input type="date" class="form-control" id="dataInicial" v-model="searchFilter.date_end" />
        </div>
        <div class="col-12 col-md-4 mb-2">
          <label for="status" class="form-label">Status:</label>
          <select class="form-select" id="status" v-model="searchFilter.status">
            <option value="">Todos</option>
            <option value="paid">Pago</option>
            <option value="pending">Pendentes</option>
          </select>
        </div>
        <div class="col-12 text-end">
          <button type="button" class="btn btn-primary" @click="buscarContratos">Buscar</button>
          <button type="button" class="btn btn-primary" @click="clearFilter">Limpar</button>
        </div>
      </form>

      <hr>

      <table class="table table-hover">
        <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Juros</th>
          <th>Status</th>
          <th>Data</th>
          <th>Id do Cliente</th>
          <th>Nome do Cliente</th>
          <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="contractLine in contracts" :key="contractLine.id">
          <td>{{ contractLine.id }}</td>
          <td>{{ contractLine.type }}</td>
          <td>{{ contractLine.value }}</td>
          <td>{{ contractLine.fine_value }}</td>
          <td>{{ contractLine.status }}</td>
          <td>{{ contractLine.created_at }}</td>
          <td>{{ contractLine.costumer_id }}</td>
          <td>{{ contractLine.costumer_name }}</td>
          <td>
            <button v-if="contractLine.status=='pending'" type="button" class="btn btn-outline-primary" @click="payCharge(contractLine)">Efetuar Pagamento</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <h1>Pagamento Realizado com sucesso</h1>
      <pre>{{JSON.stringify(paymentData, null, 4)}}</pre>
      <button type="button" class="btn btn-outline-primary" @click="fecharModal()">Voltar</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      error: null,
      searchFilter: {
        date_start: null,
        date_end: null,
        status: null
      },
      paymentData: {},
      editMode: false,
      contracts: []
    };
  },
  watch: {
    'searchFilter.date_start'(novoValor) {
      if (this.searchFilter.date_end == null || this.searchFilter.date_end < this.searchFilter.date_start) {
        this.searchFilter.date_end = novoValor;
      }
    },
    'searchFilter.date_end'(novoValor) {
      if (this.searchFilter.date_start == null || this.searchFilter.date_end < this.searchFilter.date_start) {
        this.searchFilter.date_start = novoValor;
      }
    }
  },
  mounted() {
    this.buscarContratos();
  },
  methods: {
    clearFilter() {
      this.searchFilter.date_start = null;
      this.searchFilter.date_end = null;
      this.searchFilter.status = null;
    },
    async buscarContratos() {
      try {
        this.clearError();
        const response = await this.$http.post('/charge', this.searchFilter);
        this.contracts = response.data.data;
      } catch (error) {
        this.error = error.response.data.message;
      }
    },
    async payCharge(charge) {
      try {
        this.clearError();
        const response = await this.$http.post('/charge/' + charge.id + '/make-payment', {});
        this.paymentData = response.data.data;
        this.editMode = true;
      } catch (error) {
        this.error = error.response.data.message;
      }
    },
    fecharModal() {
      this.buscarContratos();
      this.editMode = false;
    },
    clearError() {
      this.error = null
    }
  }
};
</script>