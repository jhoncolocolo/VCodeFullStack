<template>
    <div class="row form-pet"  v-if="!isLoading">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Edit Pet</h4></div>
                <div class="card-body">
                    <form @submit.prevent="updatePet">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select id="categories" class="form-control" v-model="pet.category_id">
                                        <option  :value="category.id" v-for="category in categories.value" :key="category.id">{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="pet.name">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                 <div class="form-floating">
                                    <input type="text" class="form-control" v-model="pet.photoUrls">
                                    <label for="photoUrls">Photo</label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-floating">
                                    <select id="statuses" class="form-control" v-model="pet.status">
                                        <option  :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>
                                    </select>
                                    <label for="floatingTextarea2">Status</label>
                                </div>
                            </div>
                            <div  class="col-12 mb-2">
                                <TagsByPet  v-for="tag in tags.value" :tags="pet.tags" :key="tag.id" :tagName="tag" @seletedTag="addTag"></TagsByPet>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <template v-else>
        <loading v-model:active="isLoading"
            :can-cancel="false"
            :is-full-page="true"/>
    </template>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {reactive,ref} from 'vue';
import { useCategoriesApi, usePetsApi, useTagsApi } from "@/composables";
import {useRoute,useRouter} from "vue-router";
import TagsByPet from "@/components/TagsByPet";


export default {
    name:"PetEdit",
    components: {TagsByPet,Loading},
    setup() {

        
        const {GetCategories} = useCategoriesApi();

        const {GetPetsById, UpdatePet} = usePetsApi();

        const categories = reactive([]);

        const isLoading = ref(true); 


        const {GetTags} = useTagsApi();

        const tags = reactive([]); 


        const statuses = [{'id':'available', 'name':'AVAILABLE'},{'id':'pending', 'name':'PENDING'},{'id':'sold', 'name':'SOLD'}]; 

        const pet = ref({                
                category_id:"",
                name:"",
                photoUrls:"",
                status:"",
                tags:[]
                });

        const route = useRoute();

        const router = useRouter();

        const showPet = async() =>{
            GetPetsById(route.params.id).then( data => {
                if(data){
                   pet.value = data;
                   isLoading.value= false;
                }
            });
        }

        const updatePet = () =>{
            UpdatePet(route.params.id,pet.value).then(data => {
                if(data){
                  router.push({name:"pet.index"})
                }
            });
        }

        const showCategories = () => {
          GetCategories().then(data => {
            if(data){
              categories.value = data; 
              showPet();
            }
          });
        }


        const showTags = () => {
            GetTags().then(data => {
                if(data){
                  tags.value = data;
                }
            });
        }

        const addTag = (element, status) => {
           const existsElement = pet.value.tags.some(tag => tag.id == element.value.id);
           if(status){
             if(!existsElement ){
                pet.value.tags.push(element.value);
             }
           }else{
            const iControl = pet.value.tags.findIndex(object => {
              return object.id === element.value.id;
            });
             pet.value.tags.splice(iControl,1);
           }
        }   

        return {
          updatePet,
          showPet,
          showCategories,
          pet,
          categories,
          statuses,
          showTags,
          tags,
          addTag,
          isLoading,
          fullPage: true
        }
    },
    mounted(){
      this.showCategories();
      this.showTags(); 
    }
}
</script>
<style>

.form-pet {margin: 4% 20%;}

@media only screen and (max-width: 480px) {
  .form-pet {margin: 5% 2%;}
}


</style>