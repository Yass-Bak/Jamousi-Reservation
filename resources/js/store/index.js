import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';
import Features from './modules/Features'
export default createStore({
    modules: {
        Features
                },
    plugins: [createPersistedState()],
})
