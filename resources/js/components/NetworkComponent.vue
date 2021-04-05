<template>
  <div class="content">
    <div class="card">
        <div class="card-header d-flex">
            <h2 class="card-title">Lista de Empresários</h2>
            <button  class="btn btn-success ml-5"  data-toggle="modal" data-target="#addNew"  @click="openModalWindow">
                CADASTRAR NOVO EMPRESÁRIO
            </button>
        </div>
        <div class="card-body table-responsive p-0">
            <p class="h2 mx-auto text-center font-weight-bold" v-if="affiliates < 1">Não há Empresários Cadastrado.</p>
            <table v-else class="table table-hover">
                <tbody><tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Cidade/UF</th>
                    <th>Cadastrado em</th>
                    <th>Padrinho</th>
                    <th>Rede</th>
                    <th>Ações</th>
                    </tr>
                    <tr v-for="affiliate in affiliates" :key="affiliate.id">
                    <td>{{ affiliate.name }}</td>
                    <td>{{ affiliate.email }}</td>
                    <td>{{ affiliate.phone }}</td>
                    <td>{{ affiliate.city }}/{{ affiliate.uf }}</td>
                    <td>{{ affiliate.created_at | formatDate }}</td>
                    <td v-if="affiliate.godfather">{{ affiliate.godfather.name }}</td>
                    <td v-else><a href="#"></a></td>
                    <td>
                        <button class="btn btn-warning" @click="showNetwork(affiliate.id)" href="#">Ver Rede</button>
                    </td>
                    <td>
                        <button  href="#" class="btn btn-info d-inline"  data-id="affiliate.id"  @click="editModalWindow(affiliate)">Editar</button>
                        <button href="#" class="btn btn-danger ml-1 d-inline" @click="deleteAffiliate(affiliate.id)"> Excluir</button>
                    </td>
                </tr></tbody>
            </table>
            <div class="modal fade" id="addNew" tabindex="-1"  role="dialog"  aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Cadastrar novo empresário</h5>
                            <h5 v-show="editMode" class="modal-title" id="addNewLabel">Atualizar empresário</h5>
                            <button  type="button"  class="close"  data-dismiss="modal"  aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <form  @submit.prevent="editMode ? updateAffiliate() : createAffiliate()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nome Completo:</label>
                                <input required  @blur="checkName($event)"  v-model="form.name"  type="text"  name="name"
                                placeholder="Seu nome Completo"  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"/>
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input required  v-model="form.email"  type="email"  name="email"
                                placeholder="fulano@mail.com"  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"/>
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefone:</label>
                                <input required  v-model="form.phone"  type="tel"  @blur="phoneMask($event)"  name="phone"
                                placeholder="(88) 98888-7777" class="form-control"  :class="{ 'is-invalid': form.errors.has('phone') }" />
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="uf">Estado:</label>
                                <select required   name="uf"  @change="loadCities()"  v-model="form.uf"  id="uf"  class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('uf') }" >
                                    <option value="">Selecione...</option>
                                    <option v-for="state in states" :key="state.id" v-bind:value="state.sigla" >{{ state.sigla }}</option>
                                </select>
                                <has-error :form="form" field="uf"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="city">Cidade:</label>
                                <select required  name="city"   v-model="form.city" id="city"  class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('city') }">
                                    <option value="">Selecione</option>
                                    <option v-for="city in cities" :key="city.id" v-bind:value="city.nome" >{{ city.nome }}</option>
                                </select>
                                <has-error :form="form" field="city"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="network_id">Selecione um Padrinho:</label> 
                                <select  name="network_id"  v-model="form.network_id" id="network_id" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('network_id') }">
                                    <option value="">Selecione...</option>
                                    <option v-for="affiliate in affiliates" :key="affiliate.id" v-bind:value="affiliate.id">
                                        {{ affiliate.name }}
                                    </option>
                                </select>
                                <has-error :form="form" field="network_id"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-danger"   data-dismiss="modal">Fechar</button>
                            <button v-show="editMode"  type="submit"  class="btn btn-primary" >Atualizar</button>
                            <button v-show="!editMode" type="submit"  class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
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
      editMode: false,
      x:"",
      affiliates: {},
      cities: {},
      states: {},
      apiLocalUrl: "https://servicodados.ibge.gov.br/api/v1/localidades/estados",
      form: new Form({
        id: "",
        name: "",
        email: "",
        phone: "",
        uf: "",
        city: "",
        network_id: "",
      }),
    };
  },

  methods: {
    async showNetwork(id) {
      await axios.get(`api/network/${id}`).then((response) => {
        this.$router.push({
          name: "network",
          params: { data: response.data },
        });
      });
    },
    editModalWindow(affiliate) {
      this.loadCities(affiliate.uf);
      this.form.clear();
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(affiliate);
    },
    updateAffiliate() {
      this.form
        .put("api/affiliate" + this.form.id)
        .then(() => {
          Toast.fire({
            icon: "success",
            title: "Affiliate updated successfully",
          });

          Fire.$emit("AfterCreatedAffiliateLoadIt");

          $("#addNew").modal("hide");
        })
        .catch(() => {
          console.log("Error.....");
        });
    },
    openModalWindow() {
      this.editMode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },

    async loadAffiliates() {
        // data da callback - data do response - data do paginate
     await axios.get("api/affiliate").then((data) => (this.affiliates = data.data.data));
      //pick data from controller and push it into affiliates object
    },
    loadCities(uf) {
      uf = uf ? uf : this.form.uf;
      this.$Progress.start();
      axios.get(`${this.apiLocalUrl}/${uf}/municipios?orderBy=nome`).then((cities) => {
          Toast.fire({
            icon: "success",
            title: "Todas as Cidades foram Carregadas.",
            });

          this.$Progress.finish();
          this.cities = cities.data;

          Fire.$emit("loadedCities"); //custom events
        }).catch(() => {
          console.log("error...");
        });
    },

    createAffiliate() {
      this.$Progress.start();

      this.form.post("api/affiliate").then(() => {
          Fire.$emit("AfterCreatedAffiliateLoadIt"); //custom events

          Toast.fire({
            icon: "success",
            title: "Empresário cadastrado com sucesso!",
            });   

          this.$Progress.finish();

          $("#addNew").modal("hide");
        }).catch((err) => {
          console.log(err);
        });
    },
    deleteAffiliate(id) {
      Swal.fire({
        title: "Você tem certeza?",
        text:"Esta ação irá excluir definitivamente este empresário.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, tenho certeza!",
        cancelButtonText: "Cancelar!",
      }).then((result) => {
        if (result.value) {
          //Send Request to server
          this.form.delete("api/affiliate/" + id).then((response) => {
              Swal.fire(
                "Excluido!",
                "Empresário excluído com sucesso!",
                "success"
              );
              this.loadAffiliates();
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Desculpe-nos, Ocorreu um erro!",
                // footer: '<a href>Why do I have this issue?</a>'
              });
            });
        }
      });
    },
  phoneMask(e) {
      if(e.target.value.length >= 11){
        this.x = e.target.value.replace(/\D/g, '').match(/(\d{2})(\d{5})(\d{4})/);
          this.form.phone = `(${this.x[1]}) ${this.x[2]}-${this.x[3]}`;
          Toast.fire({
            icon: "info",
            title: "Número de Telefone formatado!",
          });
      }else{
          Toast.fire({
            icon: "warning",
            title: "Número de Telefone inválido!",
          });
          this.form.phone = ""
          }
          
  },
  checkName(){
      if(this.form.name.trim().split(" ").length < 2){
          Toast.fire({
                icon: "info",
                title: "Atenção!",
                text: "Você deve informar Seu sobrenome!",
                
              });
      }
  }
  },
    mounted(){
      axios.get(`${this.apiLocalUrl}?orderBy=nome`).then((data) => (this.states = data.data));

    },
  created() {
    this.loadAffiliates();

    Fire.$on("AfterCreatedAffiliateLoadIt", () => {
      //custom events fire on
      this.loadAffiliates();
    });
  },
};
</script> 