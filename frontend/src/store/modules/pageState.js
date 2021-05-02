/* eslint-disable */
const state = {
    loading: false,
    logged: false
}

const mutations = {
    setLoading(state, busy) {
        state.loading = busy
    },
    setLogin(state, cond) {
        state.logged = cond
    }
}

const actions = {
}

export default {
    state,
    mutations,
    actions
}