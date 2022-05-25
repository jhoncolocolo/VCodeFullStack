import axios from 'axios';
import {useStore} from "vuex";
import {useRouter} from "vue-router";

export const usePetsApi = () =>{
    
    const store = useStore();
    const router = useRouter();

	return {
        GetPets : () =>{
           return new Promise((resolve, reject) => {
            fetch(process.env.VUE_APP_API_URL+'/api/pets', {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                  if (response.status != 200) {
                      store.dispatch("errorRequest",`${response.statusText}`);
                  }    
                  return response.json();
            })
            .then(data => {
                resolve(data);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        },

        GetPetsByStatus : (status:string) =>{
           return new Promise((resolve, reject) => {
            fetch(process.env.VUE_APP_API_URL+`/api/pets/findByStatus/${status}`, {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                  if (response.status != 200) {
                      store.dispatch("errorRequest",`${response.statusText}`);
                  }    
                  return response.json();
            })
            .then(data => {
                resolve(data);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        },

        GetPetsById : (id:number) =>{
           return new Promise((resolve, reject) => {
            let hasErrors = false;
            fetch(`${process.env.VUE_APP_API_URL}/api/pets/${id}`, {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                
                if (response.status != 200) {
                    hasErrors = true;
                    router.push('/pet');
                }  
                return response.json();
            })
            .then(data => {
                resolve(data);
                if(hasErrors) store.dispatch("errorRequest",`${data.message}`);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        },

        

        StorePet : (form:object) =>{

            return new Promise((resolve, reject) => {
                const  config = {
                    headers: { 
                        'content-type': "multipart/form-data;"  
                    }
                };
                axios.post(`${process.env.VUE_APP_API_URL}/api/pets/`,form,config)
                .then(function (){
                    resolve(true);
                    store.dispatch("succesRequest",`Registry Was Created Succesfully`);
                }).catch((error) => {
                  store.dispatch("errorRequest",`${error}`);
                  reject(false);
                });
            });
        },

        UpdatePet : (id:number, form:object) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/pets/${id}`, {
                method:"PUT",
                headers: { 
                    authorization: "Bearer " + localStorage.getItem('token'),
                    "Content-Type": "application/json",   
                },
                body:JSON.stringify(form)
                })
            .then((response) => {
                  if (response.status != 200) {
                      store.dispatch("errorRequest",`${response.statusText}`);
                  }    
                  return response.json();
            })
            .then(() => {
                resolve(true);
                store.dispatch("succesRequest",`Registry Was Udpated Succesfully`);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        },

        DeletePet : (id:number) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/pets/${id}`, {
                method:"DELETE",
                headers: { 
                    authorization: "Bearer " + localStorage.getItem('token'),
                    "Content-Type": "application/json",   
                }
                })
            .then((response) => {
                  if (response.status != 200) {
                      store.dispatch("errorRequest",`${response.statusText}`);
                  }    
                  return response.json();
            })
            .then(() => {
                resolve(true);
                store.dispatch("succesRequest",`Registry Was Deleted Succesfully`);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        }
	}
}