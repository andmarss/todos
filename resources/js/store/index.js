export default {
    state: {
        active: null
    },
    mutations: {
        /**
         * @param state
         * @param type
         * @param todo
         */
        active(state, {type, todo}) {
            state[type] = todo;
        }
    },
    /**
     * @param commit
     * @param todo
     */
    actions: {
        async setActive({commit}, todo) {
            commit('active', {type: 'active', todo});
        }
    },
    getters: {
        /**
         * Returns active todo
         * @param store
         * @returns {*}
         */
        active(store){
            return store.active;
        }
    }
}