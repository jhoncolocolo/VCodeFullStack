<template>
    <div class="row form-pet">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Create Pet</h4></div>
                <div class="card-body">
                    <form @submit.prevent="savePet" enctype="multipart/form-data">
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
                                    <div v-if="errors && pet.name == ''" style="font-size:12;color:red">Name is required</div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                 <div class="form-floating">
                                    <input type="file" id="file" ref="photoUrls" class="form-control-file" v-on:change="handleFileUpload"/>
                                    <div v-if="errors && pet.photoUrls == ''" style="font-size:12;color:red">Photo is required</div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-floating">
                                    <select id="statuses" class="form-control" v-model="pet.status">
                                        <option  :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>
                            </div>
                            <div  class="col-12 mb-2">
                                <TagsByPet  v-for="tag in tags.value" :key="tag.id" :tagName="tag" @seletedTag="addTag"></TagsByPet>
                            </div>
                            <div class="col-12">
                                <button  type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive,ref} from 'vue';
import { useCategoriesApi, usePetsApi,useTagsApi } from "@/composables";
import {useRouter} from "vue-router";
import TagsByPet from "@/components/TagsByPet";

export default {
    name:"PetCreate",
    components: {TagsByPet},
    setup() {
        const {GetCategories} = useCategoriesApi();

        const { StorePet} = usePetsApi();

        const {GetTags} = useTagsApi();

        const categories = reactive([]); 

        const tags = reactive([]); 

        const errors = ref(true); 

        const tagSelected = reactive([]); 

        const photoUrls = ref(null);

        const statuses = [{'id':'available', 'name':'AVAILABLE'},{'id':'pending', 'name':'PENDING'},{'id':'sold', 'name':'SOLD'}]; 

        const pet = ref({                
                category_id:"",
                name:"",
                photoUrls:"",
                status:"available",
                tags:[]
                });

        const router = useRouter();

        const checkForm = () => {
          if (pet.value.name && pet.value.photoUrls) {
            return true;
          }
          return false;
        }


        const showCategories = () => {
          GetCategories().then(data => {
            if(data){
              categories.value = data; 
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

        const savePet = async () => {
            //if(checkForm()){
                const form = new FormData();
                form.append('category_id',pet.value.category_id);
                form.append('name',pet.value.name);
                form.append('photoUrls',pet.value.photoUrls.name);
                form.append('status',pet.value.status);
                form.append('tags',JSON.stringify(pet.value.tags));
                form.append('photoUrlsFile',pet.value.photoUrls);
                //console.log(pet.value.tags);
                StorePet(form).then(data => {
                    if(data){
                      router.push({name:"pet.index"})
                    }
                });
            //}
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

        /*
            Handles a change on the file upload
        */
        const handleFileUpload = (e) => {
            pet.value.photoUrls = e.target.files[0]
        }

        return {
          savePet,
          showCategories,
          showTags,
          pet,
          categories,
          tags,
          statuses,
          tagSelected,
          addTag,
          checkForm,
          errors,
          handleFileUpload,
          photoUrls
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