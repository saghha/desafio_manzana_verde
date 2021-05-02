/* eslint-disable */
const { default: Axios } = require("axios")
const _ = require('lodash');
import Vue from 'vue'
import Vuex from 'vuex'
import * as getters from './getters'
Vue.use(Vuex)

const state = {
  sidebarShow: 'responsive',
  sidebarMinimize: false,
  token: null,
  user: null,
  profile: null,
  loading: false,
  logged: false,
  messageLogin: null,
  errorLogin: false,
  platosSeleccionados: [],
}

const mutations = {
  toggleSidebarDesktop (state) {
    const sidebarOpened = [true, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarOpened ? false : 'responsive'
  },
  toggleSidebarMobile (state) {
    const sidebarClosed = [false, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarClosed ? true : 'responsive'
  },
  set (state, [variable, value]) {
    state[variable] = value
  },
  setUser(state, user) {
    state.user = user
    state.token = user.access_token
  },
  setProfile(state, profile) {
    state.profile = profile
  },
  setLogout(state) { 
    state.user = null
    state.token = null
    state.profile = null
    state.platosSeleccionados = []
  },
  setLoading(state, busy) {
    state.loading = busy
  },
  setLogin(state, cond) {
    state.logged = cond
  },
  setMessageLogin(state, message) {
    state.messageLogin = message
  },
  setErrorLogin(state, cond) {
    state.errorLogin = cond
  },
  deletePlato(state, index) {
    state.platosSeleccionados.splice(index, 1)
  },
  clearSelected(state) {
    state.platosSeleccionados = []
  }
}
const actions = {
  authenticate({ commit, state }) {
    return new Promise((resolve, reject) => {
      if(state.token == null && state.user == null){
        if(localStorage.getItem('token')){
          var data = JSON.parse(localStorage.getItem('user'))
          commit('setUser', data)
          commit('setLogin', true)
          console.log("obtengo los datos desde el localstore")
          resolve()
        } else {
          reject()
        }
      } else {
        console.log("los tengo en mi store")
        resolve()
      }
    })
  },
  login({ commit }, user) {
    commit('setMessageLogin', null)
    commit('setErrorLogin', false)
    return Axios.post('auth/login', user).then((response) => {
      commit('setUser', response.data)
      window.localStorage.setItem('token', response.data.access_token)
      window.localStorage.setItem('user', JSON.stringify(response.data))
    }).catch((err) => {
      commit('setMessageLogin', err.response.data.message)
      commit('setErrorLogin', true)
      console.log(err)
    })
  },
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      console.log("eliminando localStore")
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      console.log('eliminando vuex')
      commit('setLogin', false)
      commit('setLogout')
      resolve()
    })
  },
  addPlato({commit, state}, plato) {
    return new Promise((resolve, reject) => {
      try {
        if(_.find(state.platosSeleccionados, (value) => {return value.id == plato.id})) {
          var index = _.findIndex(state.platosSeleccionados, (value) => {return value.id == plato.id})
          state.platosSeleccionados[index].cantidad += plato.cantidad
        } else {
          state.platosSeleccionados.push(plato)
        }
        resolve()
      } catch (error) {
        reject()
      }
    })
  }
}

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
})