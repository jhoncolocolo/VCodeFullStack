import {useStore} from "vuex";
import {useRouter} from "vue-router";

export const useCategoriesApi = () =>{
    const store = useStore();
    const router = useRouter();
	return {
        GetCategories : () =>{
           return new Promise((resolve, reject) => {
            fetch(process.env.VUE_APP_API_URL+'/api/categories', {
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

        GetCategoryById : (id:number) =>{
           return new Promise((resolve, reject) => {
            let hasErrors = false;
            fetch(`${process.env.VUE_APP_API_URL}/api/categories/${id}`, {
                headers: { authorization: "Bearer " + localStorage.getItem('token') }
            })
            .then((response) => {
                
                if (response.status != 200) {
                    hasErrors = true;
                    router.push('/categories');
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

        

        StoreCategory : (form:object) =>{

            return new Promise((resolve, reject) => {
                fetch(`${process.env.VUE_APP_API_URL}/api/categories/`, {
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

        UpdateCategory : (id:number, form:object) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/categories/${id}`, {
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

        DeleteCategory : (id:number) =>{
           return new Promise((resolve, reject) => {
            fetch(`${process.env.VUE_APP_API_URL}/api/categories/${id}`, {
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