<template>
  <div class="d-flex align-items-center min-vh-100 back-image">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <ValidationObserver v-slot="{invalid}">
                <CForm>
                  <h1>Ingresa tu información!</h1>
                  <p class="text-muted">Obtén la mejor comida acá</p>
                  <CAlert show color="danger" v-if="errorRegister">
                    {{messageError}}
                  </CAlert>
                  <ValidationProvider rules="required" v-slot="v">
                    <span class="text-danger" v-if="v.failedRules.required">El nombre es requerido</span>
                    <CInput
                      placeholder="Nombre"
                      autocomplete="Nombre"
                      v-model="user.name"
                    >
                      <template #prepend-content><CIcon name="cil-user"/></template>
                    </CInput> 
                  </ValidationProvider>
                  <ValidationProvider rules="required" v-slot="v">
                    <span class="text-danger" v-if="v.failedRules.required">El apellido es requerido</span>
                    <CInput
                      placeholder="Apellido"
                      autocomplete="Apellido"
                      v-model="user.lastname"
                    >
                      <template #prepend-content><CIcon name="cil-user"/></template>
                    </CInput>
                  </ValidationProvider>
                  <ValidationProvider rules="required|email"  v-slot="v">
                    <span class="text-danger" v-if="v.failedRules.required">El correo es requerido</span>
                    <span class="text-danger" v-if="v.failedRules.email">El formato del correo no es correcto</span>
                    <CInput
                      placeholder="Correo"
                      autocomplete="email"
                      prepend="@"
                      v-model="user.email"
                    />
                  </ValidationProvider>
                  <ValidationProvider rules="required|confirmed:confirmation" v-slot="v">
                    <span class="text-danger" v-if="v.failedRules.required">La contraseña es requerida</span>
                    <span class="text-danger" v-if="v.failedRules.confirmed">Las contraseñas no coinciden</span>
                    <CInput
                      placeholder="Contraseña"
                      type="password"
                      autocomplete="new-password"
                      v-model="user.password"
                    >
                      <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                    </CInput>
                  </ValidationProvider>
                  <ValidationProvider vid="confirmation" v-slot="v">
                    <CInput
                      placeholder="Confirma Contraseña"
                      type="password"
                      autocomplete="new-password"
                      class="mb-4"
                      v-model="user.password_confirmation"
                    >
                      <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                    </CInput>
                  </ValidationProvider>
                  <CButton color="success" block @click="registro()" :disabled="invalid">Crea tu cuenta</CButton>
                </CForm>
                <router-link to="/auth/login">¿Ya tienes una cuenta?</router-link>
              </ValidationObserver>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data () {
    return {
      user: {

      },
      errorRegister: false,
      messageError: null
    }
  },
  methods: {
    registro: function () {
      this.$store.commit('setLoading', true)
      this.errorRegister = false
      this.messageError = null
      axios.post('auth/register', this.user).then((response) => {
        this.$swal({
          toast: true,
          icon: 'success',
          title: 'Te has registrado correctamente',
          position: 'top-end',
          timer: 3000,
          showConfirmButton: false,
          timerProgressBar: true,
          onOpen: (toast) => {
              toast.addEventListener('mouseenter', this.$swal.stopTimer)
              toast.addEventListener('mouseleave', this.$swal.resumeTimer)
          }
        })
        this.$router.push('/auth/login')
      }).catch((err) => {
        this.errorRegister = true
        this.messageError = err.response.data.message
      }).finally(() => {
        this.$store.commit('setLoading', false)
      })
    }
  }
}
</script>
<style>
.back-image {
  background: url('/img/restaurant-interior.jpg') no-repeat;
  background-size: cover;
}
.back-image::before {
    background-color: rgba(0,0,0,0.25);
}
</style>