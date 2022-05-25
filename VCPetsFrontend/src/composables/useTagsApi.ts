import {useStore} from "vuex";
import {useRouter} from "vue-router";

export const useTagsApi = () =>{
    
    const store = useStore();
    const router = useRouter();
	
    return {
        GetTags : () =>{
           return new Promise((resolve, reject) => {
            fetch(process.env.VUE_APP_API_URL+'/api/tags', {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                  if (response.status != 200) {
                      alert("Error: " + response.statusText);
                  }    
                  return response.json();
            })
            .then(data => {
                resolve(data);
            }).catch((error) => {
              console.error('Error:', error);
              reject(false);
            });
          });
        },

        GetTagById : (id:number) =>{
           return new Promise((resolve, reject) => {
            let hasErrors = false;
            fetch(`${process.env.VUE_APP_API_URL}/api/tags/${id}`, {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                
                if (response.status != 200) {
                    hasErrors = true;
                    router.push('/tags');
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

        

        StoreTag : (form:object) =>{

            return new Promise((resolve, reject) => {
                fetch(`${process.env.VUE_APP_API_URL}/api/tags/`, {
                    method:"POST",
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
                    store.dispatch("succesRequest",`Registry Was Register Succesfully`);
                }).catch((error) => {
                  store.dispatch("errorRequest",`${error}`);
                  reject(false);
                });
            });
        },

        UpdateTag : (id:number, form:object) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/tags/${id}`, {
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
                store.dispatch("succesRequest",`Registry Was Udpate Succesfully`);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        },

        DeleteTag : (id:number) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/tags/${id}`, {
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
                store.dispatch("succesRequest",`Registry Was Delete Succesfully`);
            }).catch((error) => {
              store.dispatch("errorRequest",`${error}`);
              reject(false);
            });
          });
        } 
	}
}