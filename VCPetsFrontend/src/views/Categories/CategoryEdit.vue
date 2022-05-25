<template>
    <div class="row form-pet">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Edit Category</h4></div>
                <div class="card-body">
                    <form @submit.prevent="updateCategory">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name Category</label>
                                    <input type="text" class="form-control" v-model="category.name">
                                </div>
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
</template>

<script>
import {ref} from 'vue';
import { useCategoriesApi } from "@/composables";
import {useRoute,useRouter} from "vue-router";

export default {
    name:"CategoryEdit",
    setup() {

        
        const {GetCategoryById,UpdateCategory} = useCategoriesApi();



        const category = ref({
                name:""
                });

        const route = useRoute();

        const router = useRouter();

        const showCategory = async() =>{
            GetCategoryById(route.params.id).then( data => {
                if(data){
                   category.value = data;
                }
            });
        }

        const updateCategory = () =>{
            UpdateCategory(route.params.id,category.value).then(data => {
                if(data){
                  router.push({name:"categories.index"})
                }
            });
        }  

        return {
            category,
            updateCategory,
            showCategory
        }
    },
    mounted(){
      this.showCategory();
    }
}
</script>
<style>

.form-pet {margin: 4% 20%;}

@media only screen and (max-width: 480px) {
  .form-pet {margin: 5% 2%;}
}


</style>
