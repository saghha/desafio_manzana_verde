/* eslint-disable */
import router from '../../router'
const { default: Axios } = require("axios")

const state = {
    token: null,
    user: null,
    profile: null
}

const mutations = {
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
        return Axios.post('auth/login', user).then((response) => {
            commit('setUser', response.data)
            window.localStorage.setItem('token', response.data.access_token)
            window.localStorage.setItem('user', JSON.stringify(response.data))
        }).catch((err) => {
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
    }
}

export default {
    state,
    mutations,
    actions
}