<template>
  <div class="c-app flex-row align-items-center back-image">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <ValidationObserver v-slot="{invalid}">
                  <CForm>
                    <h1>bienvenido!</h1>
                    <p class="text-muted">Ingresa con tu cuenta</p>
                    <CAlert show color="danger" v-if="error">
                      {{message}}
                    </CAlert>
                    <ValidationProvider rules="required|email" v-slot="v">
                      <span class="text-danger" v-if="v.failedRules.required">El correo es requerido</span>
                      <span class="text-danger" v-if="v.failedRules.email">El correo no tiene el formato correcto</span>
                      <CInput
                        placeholder="email"
                        autocomplete="email"
                        v-model="user.email"
                      >
                        <template #prepend-content><CIcon name="cil-user"/></template>
                      </CInput>
                    </ValidationProvider>
                    <ValidationProvider rules="required" v-slot="v">
                      <span class="text-danger" v-if="v.failedRules.required">La contraseña es requerida</span>
                      <CInput
                        placeholder="Password"
                        type="password"
                        autocomplete="curent-password"
                        v-model="user.password"
                      >
                        <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                      </CInput>
                    </ValidationProvider>
                    <CRow>
                      <CCol col="6" class="text-left">
                        <CButton color="primary" class="px-4" :disabled="invalid" @click="login()">Ingresar</CButton>
                      </CCol>
                      <CCol col="6" class="text-right">
                        <!-- <CButton color="link" class="px-0">Forgot password?</CButton>
                        <CButton color="link" class="d-lg-none">Register now!</CButton> -->
                      </CCol>
                    </CRow>
                  </CForm>
                </ValidationObserver>
              </CCardBody>
            </CCard>
            <CCard
              color="primary"
              text-color="white"
              class="text-center py-5 d-md-down-none"
              body-wrapper
            >
              <CCardBody>
                <h2>¿Aún no Tienes tu cuenta?</h2>
                <p>No te pierdas los mejores descuentos en platos gourmet directo a tu hogar. Crea tu cuenta ahora.</p>
                <router-link
                  tag="button"
                  class="btn btn-outline-secondary"
                  to="/auth/register"
                >
                  Registrarme!
                </router-link>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      user: {
        email: null,
        password: null
      },
      errorLogin: false,
      messageError: null,
    }
  },
  computed: {
    error () {
      if(this.$store.state.errorLogin) { 
        return true
      } else return false
    },
    message () {
      if(!!this.$store.state.messageLogin) {
        return this.$store.state.messageLogin
      } else {
        return null
      }
    }
  },
  methods: {
    login: function () {
      this.$store.commit('setLoading', true)
      this.errorLogin = false
      this.messageError = null
      this.$store.dispatch('login', this.user).then(() => {
        this.$router.push('/')
        this.$store.commit('setLoading', false)
      }).catch((err) => {
        this.$store.commit('setLoading', false)
      })
    }
  }
}
</script>
<style>
.back-image {
  background-image: url('/img/restaurant-interior.jpg');
  background-repeat: no-repeat;
  background-size: cover;
}
</style>