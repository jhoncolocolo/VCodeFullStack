<template>
    <div class="row form-pet">
        <div class="col-12">             
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th style="text-align:center"><router-link :to='{name:"categories.create"}' class="btn btn-success">Create</router-link></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in categories.value" :key="category.id">
                                    <td>{{ category.id }}</td>
                                    <td>{{ category.name }}</td>
                                    <td style="text-align:center">
                                    <router-link :to='{name:"categories.edit",params:{id:category.id}}' class="btn btn-info">&#9997;</router-link>
                                    <a type="button" @click="deleteCategory(category.id)" class="btn btn-danger">&#9940;</a>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>                          
        </div>
    </div>
    <router-view/>
</template>

<script>
import {reactive} from 'vue';
import {useCategoriesApi } from "@/composables";
export default {
    name:"CategoryIndex",
    setup() {
    
    
    const categories = reactive([]);

    const {GetCategories,DeleteCategory} = useCategoriesApi();

    const showCategories = () => {
        GetCategories().then(data => {
            if(data){
              categories.value = data;
            }
        });
    }

    const deleteCategory = async(id) => {
      if(confirm("¿Confirm That Tou Wish Delete This Registry?")){
            DeleteCategory(id).then(data => {
              if(data){
                const index = categories.value.findIndex(object => {
                  return object.id === id;
                });

                categories.value.splice(index,1);
              }
            });
        }
    }

    return {
      categories,
      showCategories,
      deleteCategory
    }
  },
    mounted(){
        this.showCategories()
    },
}
</script>
<style>

.form-pet {margin: 4% 20%;}

@media only screen and (max-width: 480px) {
  .form-pet {margin: 5% 2%;}
}


</style>