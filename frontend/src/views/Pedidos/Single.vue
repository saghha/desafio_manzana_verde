<template>
	<div>
		<CRow>
			<CCol sm="12">
				<CCard>
					<CCardHeader>
						<h4>Información del pedido</h4>
					</CCardHeader>
					<CCardBody>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Código de Pedido</label>
									<input class="form-control" v-model="pedido.codigo_pedido" disabled/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Tipo de retiro</label>
									<input class="form-control" v-model="pedido.tipo_entrega" disabled/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Dirección Entrega</label>
									<input class="form-control" v-model="pedido.direccion_entrega" disabled/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Fecha del Pedido</label>
									<input class="form-control" :value="formatDate(pedido.fecha_pedido)" disabled/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Tipo de pago</label>
									<input class="form-control" v-model="pedido.tipo_pago" disabled/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="form-group">
									<label>Precio Total</label>
									<input class="form-control" :value="formatAllMoney(pedido.precio_pedido)" disabled/>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="form-group">
									<label>Notas del pedido</label>
									<textarea class="form-control" v-model="pedido.notas" placeholder="Tipo de masa, quien recibe, etc" disabled></textarea>
								</div>
							</div>
							<CCol sm="12">
								<CButton @click="collapse = !collapse" color="primary" class="mb-2">
									Ver Detalle del pedido
								</CButton>
								<CCollapse :show="collapse" :duration="400">
									<CCard body-wrapper>
										<CCol sm="12" md="6" lg="6" v-for="(plato, index) in pedido.platos" :key="index">
											<div class="card shadow-card overflow-auto">
												<div class="card-body">
													<div class="row">
														<div class="col-sm-12 col-md-4 col-lg-4 text-center">
															<img :src="photoPlato(plato.url_photo)" alt="Plato" class="img-responsive size-photo"/>
														</div>
														<div class="col-sm-12 col-md-8 col-lg-8">
															<div class="row">
																<div class="col-12">
																	<h4>{{plato.comida.nombre}}</h4>
																	<p>{{plato.comida.descripcion}}</p>
																	<p><strong>Precio: </strong>${{formatAllMoney(plato.precio)}}</p>
																	<span><strong>Seleccione cantidad</strong></span>
																</div>
																<div class="col-sm-12 col-md-6 col-lg-6">
																	<plusminsfield v-model="plato.cantidad"></plusminsfield>
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
						</div>
					</CCardBody>
				</CCard>
			</CCol>
		</CRow>
	</div>
</template>
<script>
import PlusMinusField from '../MinusPlus.vue'
import moment from 'moment'
export default {
	name: 'OnePedido',
	props: ['id'],
	components: {
		'plusminsfield': PlusMinusField
	},
	data () {
		return {
			pedido: {},
			collapse: false
		}
	},
	created () {
		this.$nextTick(function () {
			this.getPedido()
		})
	},
	methods: {
		getPedido: function () {
			this.$store.commit('setLoading', true)
			axios.get('pedido/'+this.id).then((response) => {
				this.pedido = response.data
			}).catch((err) => {
				this.showToast('error', err.response.data.message)
			}).finally(() => {
				this.$store.commit('setLoading', false)
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