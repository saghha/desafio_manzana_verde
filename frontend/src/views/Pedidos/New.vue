<template>
  <div>
    <CRow>
      <CCol sm="12" class="text-right">
        <CButton color="info" @click="CartModal()">
          Carrito&nbsp;<span class="badge badge-danger">{{cantidadSeleccionada}}</span>
        </CButton>
      </CCol>
      <CCol sm="12">
        <form-wizard :subtitle="''" :nextButtonText="'Siguiente'" finishButtonText="Realizar Pedido" backButtonText="Atrás" @on-complete="confirmPedido()">
          <template v-slot:title>
            <h3><strong>Realiza tu Pedido</strong></h3>
          </template>
          <tab-content title="Selección de platos">
            <CCard style="max-height:400px">
              <CCardBody>
                <CRow>
                  <CCol sm="12" md="6" v-for="(plato, index) in platos" :key="index">
                    <div class="card shadow-card overflow-auto">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12 col-md-4 col-lg-4 text-center">
                            <img :src="photoPlato(plato.url_photo)" alt="Plato" class="img-responsive size-photo"/>
                          </div>
                          <div class="col-sm-12 col-md-8 col-lg-8">
                            <div class="row">
                              <div class="col-12">
                                <h4>{{plato.nombre}}</h4>
                                <p>{{plato.descripcion}}</p>
                                <p><strong>Precio: </strong>${{formatAllMoney(plato.precio)}}</p>
                                <span><strong>Seleccione cantidad</strong></span>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <plusminsfield v-model="plato.cantidad"></plusminsfield>
                              </div>
                              <div class="col-sm-12 col-lg-6 col-md-6 text-right">
                                <button class="btn btn-success" @click="addPlato(index)">Agregar al pedido</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </CCol>
                </CRow>
              </CCardBody>
            </CCard>
          </tab-content>
          <tab-content title="Información del pedido">
            <CCard>
              <CCardBody>
                <ValidationObserver>
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <div class="form-group">
                        <label>Código de Pedido</label>
                        <input class="form-control" v-model="pedido.codigo_pedido" disabled/>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <ValidationProvider rules="required" v-slot="v">
                        <div class="form-group">
                          <label :class="{'text-danger': v.failedRules.required}">Tipo de retiro</label>
                          <v-select :options="tipo_retiro" v-model="pedido.tipo_entrega" @input="selectTipoEntrega"/>
                          <span class="text-danger" v-if="v.failedRules.required">Seleccione un tipo de retiro</span>
                        </div>
                      </ValidationProvider>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <ValidationProvider rules="required" v-slot="v">
                        <div class="form-group">
                          <label :class="{'text-danger': v.failedRules.required}">Dirección Entrega</label>
                          <input class="form-control" v-model="pedido.direccion_entrega" :disabled="pedido.tipo_entrega == 'Retiro en tienda'"/>
                          <span class="text-danger" v-if="v.failedRules.required">Debe Ingresar la dirección</span>
                        </div>
                      </ValidationProvider>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <div class="form-group">
                        <label>Fecha del Pedido</label>
                        <input class="form-control" v-model="pedido.fecha_pedido" disabled/>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <ValidationProvider rules="required" v-slot="v">
                        <div class="form-group">
                          <label :class="{'text-danger': v.failedRules.required}">Tipo de pago</label>
                          <v-select :options="tipos_pagos" v-model="pedido.tipo_pago"/>
                          <span class="text-info"><strong>*Actualmente solo disponemos de pago en Efectivo</strong></span>
                          <span class="text-danger" v-if="v.failedRules.required">Seleccione un tipo de pago</span>
                        </div>
                      </ValidationProvider>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label>¿Algún comentario sobre el pedido?</label>
                        <textarea class="form-control" v-model="pedido.notas" placeholder="Tipo de masa, quien recibe, etc"></textarea>
                      </div>
                    </div>
                  </div>
                </ValidationObserver>
              </CCardBody>
            </CCard>
          </tab-content>
          <tab-content title="Confirmación">
            <CCard>
              <CCardBody>
                <CRow v-if="computedSeleccionados.length > 0">
                  <CCol sm="12">
                    <h4>El precio total de tu pedido es: ${{formatAllMoney(computedTotalPedido)}}</h4>
                    <h5>Se entregrá en la dirección <strong>{{pedido.direccion_entrega}}</strong></h5>
                  </CCol>
                  <CCol sm="12">
                    <CButton @click="collapse = !collapse" color="primary" class="mb-2">
                      Ver Detalle del pedido
                    </CButton>
                    <CCollapse :show="collapse" :duration="400">
                      <CCard body-wrapper>
                        <CCol sm="12" md="12" v-for="(plato, index) in computedSeleccionados" :key="index">
                          <div class="card shadow-card overflow-auto">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4 text-center">
                                  <img :src="photoPlato(plato.url_photo)" alt="Plato" class="img-responsive size-photo"/>
                                </div>
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                  <div class="row">
                                    <div class="col-12">
                                      <h4>{{plato.nombre}}</h4>
                                      <p>{{plato.descripcion}}</p>
                                      <p><strong>Precio: </strong>${{formatAllMoney(plato.precio)}}</p>
                                      <span><strong>Seleccione cantidad</strong></span>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                      <plusminsfield v-model="plato.cantidad"></plusminsfield>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 col-md-6 text-right">
                                      <button class="btn btn-danger" @click="deletePlato(index)">Eliminar del pedido</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </CCol>
                      </CCard>
                    </CCollapse>
                  </CCol>
                </CRow>
              </CCardBody>
            </CCard>
          </tab-content>
        </form-wizard>
      </CCol>
      <CModal
        title="Carrito de Compras"
        size="lg"
        :show.sync="showCartModal"
      >
        <CRow v-if="computedSeleccionados.length > 0">
          <CCol sm="12" md="12" v-for="(plato, index) in computedSeleccionados" :key="index">
            <div class="card shadow-card overflow-auto">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4 text-center">
                    <img :src="photoPlato(plato.url_photo)" alt="Plato" class="img-responsive size-photo"/>
                  </div>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                      <div class="col-12">
                        <h4>{{plato.nombre}}</h4>
                        <p>{{plato.descripcion}}</p>
                        <p><strong>Precio: </strong>${{formatAllMoney(plato.precio)}}</p>
                        <span><strong>Seleccione cantidad</strong></span>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6">
                        <plusminsfield v-model="plato.cantidad"></plusminsfield>
                      </div>
                      <div class="col-sm-12 col-lg-6 col-md-6 text-right">
                        <button class="btn btn-danger" @click="deletePlato(index)">Eliminar del pedido</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </CCol>
        </CRow>
        <CRow v-else>
          <CCol sm="12">
            <h4>No hay platos seleccionados</h4>
          </CCol>
        </CRow>
      </CModal>
    </CRow>
  </div>
</template>
<script>
import PlusMinusField from '../MinusPlus.vue'
import moment from 'moment'
export default {
  name: 'NuevoPedido',
  components: {
    'plusminsfield': PlusMinusField
  },
  data () {
    return {
      platos: [],
      collapse: false,
      tipo_retiro: ['Entrega en domicilio', 'Retiro en tienda'],
      tipos_pagos: ['Efectivo'],
      pedido: {},
      showCartModal: false,
    }
  },
  created () {
    this.$nextTick(function () {
      this.$store.commit('setLoading', true)
      var promises = []
      this.pedido.fecha_pedido = moment().format('DD/MM/YYYY').toString()
      this.generacodigo();
      promises.push(this.getComida())
      Promise.all(promises).then(() => {
        this.$store.commit('setLoading', false)
      }).catch(() => {
        this.$store.commit('setLoading', false)
      })
    })
  },
  computed: {
    cantidadSeleccionada () {
      var cantidad = 0
      if(this.$store.getters.platos_seleccionados.length > 0) {
        _.forEach(this.$store.getters.platos_seleccionados, (value) => {
          cantidad+= value.cantidad
        })
      }
      return cantidad
    },
    computedSeleccionados () {
      return this.$store.getters.platos_seleccionados
    },
    computedTotalPedido () {
      var total = 0
      if(this.$store.getters.platos_seleccionados.length > 0) {
        _.forEach(this.$store.getters.platos_seleccionados, (value) => {
          total+= value.precio*value.cantidad
        })
      }
      return total
    }
  },
  methods: {
    getComida: function () {
      return axios.get('comida').then((response) => {
        this.platos = []
        _.forEach(response.data, (value) => {
          var data = JSON.parse(JSON.stringify(value))
          data.cantidad = 1
          this.platos.push(data)
        })
      }).catch((err) => {
        this.showToast('error', err.response.data.message)
      })
    },
    formatAllMoney: function (monto) {
      return Intl.NumberFormat('de-DE').format(monto)
    },
    addPlato: function (index) {
      console.log("plato en el posicion "+index)
      var plato = JSON.parse(JSON.stringify(this.platos[index]))
      this.$store.dispatch('addPlato', plato).then(() => {
        this.platos[index].cantidad = 1
        this.showToast('success', 'Se agregó correctamente al pedido')
      }).catch(() => {
        this.showToast('error', 'No se pudo agregar el plato')
      })
    },
    CartModal: function () {
      this.showCartModal = true
    },
    showToast: function (icon, title) {
      this.$swal({
        toast: true,
        icon: icon,
        title: title,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', this.$swal.stopTimer)
          toast.addEventListener('mouseleave', this.$swal.resumeTimer)
        }
      })
    },
    selectTipoEntrega: function (payload) {
      if(payload == 'Retiro en tienda') {
        this.pedido.direccion_entrega = 'Av Nombre Comuna #000, Ciudad'
      } else {
        this.pedido.direccion_entrega = null
      }
    },
    confirmPedido: function () {
      this.$swal({
        icon: 'question',
        title: 'Confirme para realizar el pedido',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if(result.value) {
          this.submitPedido()
        }
      })
    },
    submitPedido: function () {
      this.$store.commit('setLoading', true)
      if(this.$store.getters.platos_seleccionados < 1) {
        this.$swal({
          icon: 'warning',
          title: 'Debe seleccionar alguna comida para realizar el pedido',
        })
        this.$store.commit('setLoading', false)
      } else if (!this.pedido.direccion_entrega || !this.pedido.tipo_entrega || !this.pedido.tipo_pago) {
        this.$swal({
          icon: 'warning',
          title: 'Debe ingresar toda la información para realizar el pedido',
        })
        this.$store.commit('setLoading', false)
      } else {
        this.pedido.platos = []
        _.forEach(this.$store.getters.platos_seleccionados, (value) => {
          var plato = {
            cantidad: value.cantidad,
            precio: Number(value.precio),
            id_comida: value.id
          }
          this.pedido.platos.push(plato)
          this.pedido.precio_pedido = this.computedTotalPedido
        })
        axios.post('pedido', this.pedido).then((response) => {
          this.showToast('success', 'Pedido ingresado, le llamaremos cuando esté listo')
          this.$store.commit('clearSelected')
          this.$router.push('/pedidos')
        }).catch((err) => {
          this.showToast('error', err.response.data.message)
        }).finally(() => {
          this.$store.commit('setLoading', false)
        })
        console.log(this.pedido)
      }
    },
    generacodigo: function () {
      this.pedido.codigo_pedido = 'CRF'+String(Math.ceil(Math.random()*(9999 - 1000) +1000))
    },
    deletePlato: function (index) {
      this.$store.commit('deletePlato', index)
      this.showToast('success', 'Se eliminó correctamente')
    },
    photoPlato: function (url) {
      if(!!url) {
        return url
      } else {
        return '/img/coocking.jpg'
      }
    }
  }
}
</script>
<style>
.shadow-card {
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}
.size-photo {
  max-width: 10vw;
}
@media (max-width: 349.98px) {
  .size-photo {
    max-width: 25vh;
  }
}
@media (max-width: 449.98px) and (min-width: 350px) {
  .size-photo {
    max-width: 25vh;
  }
}
@media (min-width: 768px) and (max-width: 991.98px) {
  .size-photo {
    max-width: 10vw;
  }
}
@media (min-width: 992px) and (max-width: 1199.98px) {
  .size-photo {
    max-width: 10vw;
  }
}
</style>