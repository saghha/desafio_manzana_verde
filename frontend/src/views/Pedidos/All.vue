<template>
  <div>
    <div class="row">
      <div class="col-12">
        <CCard>
          <CCardHeader>
            <h4>Pedidos Vigentes</h4>
          </CCardHeader>
          <CCardBody>
            <CDataTable
              :hover="true"
              :striped="true"
              :border="true"
              small
              :fixed="true"
              sorter
              :items="vigentes"
              :fields="fields"
              :items-per-page="10"
              pagination
            >
              <template #fecha_pedido="{item}">
                <td>
                  {{formatDate(item.fecha_pedido)}}
                </td>
              </template>
              <template #precio_pedido="{item}">
                <td>
                  {{formatAllMoney(item.precio_pedido)}}
                </td>
              </template>
              <template #options="{item}">
                <td>
                  <router-link type="button" :to="'/pedidos/ver/'+item.id" class="btn btn-info btn-sm">Ver Pedido</router-link>
                </td>
              </template>
            </CDataTable>
          </CCardBody>
        </CCard>
      </div>
      <div class="col-12">
        <CCard>
          <CCardHeader>
            <h4>Pedidos Anteriores</h4>
          </CCardHeader>
          <CCardBody>
            <CDataTable
              :hover="true"
              :striped="true"
              :border="true"
              small
              :fixed="true"
              sorter
              :items="no_vigentes"
              :fields="fields"
              :items-per-page="10"
              pagination
            >
              <template #fecha_pedido="{item}">
                <td>
                  {{formatDate(item.fecha_pedido)}}
                </td>
              </template>
              <template #precio_pedido="{item}">
                <td>
                  {{formatAllMoney(item.precio_pedido)}}
                </td>
              </template>
              <template #options="{item}">
                <td>
                  <router-link type="button" :to="'/pedidos/ver/'+item.id" class="btn btn-info btn-sm">Ver Pedido</router-link>
                </td>
              </template>
            </CDataTable>
          </CCardBody>
        </CCard>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
export default {
  name: 'Pedidos',
  components: {

  },
  data () {
    return {
      vigentes: [],
      no_vigentes: [],
      fields: [
        {key: 'codigo_pedido', label: 'Código Pedido'},
        {key: 'fecha_pedido', label: 'Fecha Pedido'},
        {key: 'precio_pedido', label: 'Precio Total'},
        {key: 'options', label: 'Acciones'},
      ]
    }
  },
  created () {
    this.$nextTick(function() {
      this.$store.commit('setLoading', true)
      var promises = []
      promises.push(this.getPedidos())
      Promise.all(promises).then(() => {
        this.$store.commit('setLoading', false)
      }).catch((err) => {
        this.$store.commit('setLoading', false)
      })
    })
  },
  methods: {
    getPedidos:function () {
      return axios.get('pedido/cliente').then((response) => {
        this.vigentes = response.data.vigentes
        this.no_vigentes = response.data.no_vigentes
      }).catch((err) => {
        this.showToast('error', err.response.data.message)
      })
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
    formatAllMoney: function (monto) {
      return Intl.NumberFormat('de-DE').format(monto)
    },
    formatDate: function(date) {
      return moment(date).format('DD/MM/YYYY').toString()
    }
  }
}
</script>