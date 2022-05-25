import {createStore} from 'vuex'
import { useToast } from 'vue-toastification'

const toast = useToast();

export default createStore({
    state: {
        lastNotification:""
    },
    mutations: {
        SET_LAST_NOTIFICATION(state,message){
            state.lastNotification = message
        }
    },
    actions: {
        succesRequest({commit},message){
            toast.success(message, {
              timeout: 2000
            });
            commit("SET_LAST_NOTIFICATION", message);
        },
        errorRequest({commit},message){
            toast.error(message, {
              timeout: 2000
            });
            commit("SET_LAST_NOTIFICATION", message);
        }
        
    },
    modules: {}
})