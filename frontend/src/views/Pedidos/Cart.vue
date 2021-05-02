<template>
  <CModal
    title="Carrito de Compras"
    size="lg"
    :show.sync="true"
  >
    carrito de compras
  </CModal>
</template>
<script>
export default {
  name: 'Cart',
  props: {
  },
  computed: {
    seleccionados () {
      return this.$store.getters.platos_seleccionados
    }
  },
  methods: {
    deletePlato: function (index) {

    }
  }
}
</script>