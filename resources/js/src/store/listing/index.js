import axios from "axios";

export default {
    namespaced: true,
    state: {
        listing: {},
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getListing: (state) => state.listing,
        getIsLoading: ( state ) => state.isLoading,
        getMessage: ( state ) => state.message,
        getError: ( state ) => state.error
    },
    mutations: {
        setListing(state, listing) {
            state.listing = listing
        }

    },
    actions: {
        // Getting All
        loadListings: ({ commit }) => {
            commit( 'isLoading', true )
            axios({ url: 'listing', method: 'GET' })
              .then( resp => {
                    const data = resp.data.data
                    console.log(data, 'Data')
                    commit( 'isLoading', false )
                    return commit('setListing', data)
                })
                .catch( err => { console.log( err )
                  commit( 'isLoading', false )
                 })
        },

        // Getting Single

        // Saving
        saveListing: ( {commit}, data ) => {
            return new Promise((resolve, reject) => {
                axios( { url:'listing', data:data, method:'post' } )
                .then((resp) => {
                    console.log( resp );
                    commit('isCreated', true)
                    resolve(resp)
                })
                .catch((err) => {
                      reject(err)
                })
            })
        },

        // Updating

        // Deleting

    },
};
