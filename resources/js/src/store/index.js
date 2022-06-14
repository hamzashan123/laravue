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
import contract from './contract'
import dashboard from './dashboard'
import chat from './chat'

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
    contract,
    dashboard,
    chat,
  },
  strict: process.env.DEV,
})
