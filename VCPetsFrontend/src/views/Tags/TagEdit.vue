<template>
    <div class="row" style="margin: 0% 15%;">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Edit Tag</h4></div>
                <div class="card-body">
                    <form @submit.prevent="updateTag">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name Tag</label>
                                    <input type="text" class="form-control" v-model="tag.name">
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
import { useTagsApi } from "@/composables";
import {useRoute,useRouter} from "vue-router";

export default {
    name:"TagEdit",
    setup() {

        
        const {GetTagById,UpdateTag} = useTagsApi();



        const tag = ref({
                name:""
                });

        const route = useRoute();

        const router = useRouter();

        const showTag = async() =>{
            GetTagById(route.params.id).then( data => {
                if(data){
                   tag.value = data;
                }
            });
        }

        const updateTag = () =>{
            UpdateTag(route.params.id,tag.value).then(data => {
                if(data){
                  router.push({name:"tags.index"})
                }
            });
        }  

        return {
            tag,
            updateTag,
            showTag
        }
    },
    mounted(){
      this.showTag();
    }
}
</script>