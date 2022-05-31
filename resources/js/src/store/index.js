import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import auth from './auth'
import listing from './listing'
import setting from './setting'
import proposal from './proposal'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    app,
    appConfig,
    verticalMenu,
    auth,
    listing,
    setting,
    proposal,
  },
  strict: process.env.DEV,
})
