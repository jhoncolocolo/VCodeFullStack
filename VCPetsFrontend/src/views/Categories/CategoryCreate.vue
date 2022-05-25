<template>
  <div class="row  form-pet">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Create New Category</h4></div>
                <div class="card-body">
                    <form @submit.prevent="saveCategory">
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
import {useRouter} from "vue-router";
import { useCategoriesApi} from "@/composables";
import {ref} from 'vue';
export default {
    name:"PetCreate",
    setup() {

        const {StoreCategory} = useCategoriesApi();

        const category = ref({
                name:""
                });

        const router = useRouter();

        const checkForm = () => {
            
          if (category.value.name) {
            return true;
          }
          return false;
        }

        const saveCategory = async () => {
            if(checkForm()){
                StoreCategory(category.value).then(data => {
                    if(data){
                      router.push({name:"categories.index"})
                    }
                });
            }
        }

        return {
          saveCategory,
          category,
          checkForm
        }
    }
}
</script>
<style>

.form-pet {margin: 4% 20%;}

@media only screen and (max-width: 480px) {
  .form-pet {margin: 5% 2%;}
}


</style>