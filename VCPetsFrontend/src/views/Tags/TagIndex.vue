<template>
    <div class="row form-pet">
        <div class="col-12">             
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th style="text-align:center"><router-link :to='{name:"tags.create"}' class="btn btn-success">Create</router-link></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tag in tags.value" :key="tag.id">
                                    <td>{{ tag.id }}</td>
                                    <td>{{ tag.name }}</td>
                                    <td style="text-align:center">
                                    <router-link :to='{name:"tags.edit",params:{id:tag.id}}' class="btn btn-info">&#9997;</router-link>
                                    <a type="button" @click="deleteUser(tag.id)" class="btn btn-danger">&#9940;</a>
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
import {useTagsApi } from "@/composables";
export default {
    name:"CategoryIndex",
    setup() {
    
    
    const tags = reactive([]);
    const {GetTags, DeleteTag} = useTagsApi();

    const showTags = () => {
        GetTags().then(data => {
            if(data){
              tags.value = data;
            }
        });
    }

    const deleteUser = async(id) => {
      if(confirm("¿Confirm That Tou Wish Delete This Registry?")){
            DeleteTag(id).then(data => {
              if(data){
                const index = tags.value.findIndex(object => {
                  return object.id === id;
                });

                tags.value.splice(index,1);
              }
            });
        }
    }

    return {
      tags,
      showTags,
      deleteUser
    }
  },
    mounted(){
        this.showTags()
    },
}
</script>
<style>

.form-pet {margin: 4% 20%;}

@media only screen and (max-width: 480px) {
  .form-pet {margin: 5% 2%;}
}


</style>