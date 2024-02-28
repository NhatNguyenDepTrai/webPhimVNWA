import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state() {
        return {
            sideBarActive: true

        }
    },
    mutations: {
        toggleSidebar(state) {
            state.sideBarActive = !state.sideBarActive;
        },
    },


})
export default store
