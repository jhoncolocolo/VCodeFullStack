<template>
  <div class="row form-pet">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Create New Tag</h4></div>
                <div class="card-body">
                    <form @submit.prevent="saveTag">
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
import {useRouter} from "vue-router";
import { useTagsApi} from "@/composables";
import {ref} from 'vue';
export default {
    name:"TagCreate",
    setup() {

        const {StoreTag} = useTagsApi();

        const tag = ref({
                name:""
                });

        const router = useRouter();

        const checkForm = () => {
            
          if (tag.value.name) {
            return true;
          }
          return false;
        }

        const saveTag = async () => {
            if(checkForm()){
                StoreTag(tag.value).then(data => {
                    if(data){
                      router.push({name:"tags.index"})
                    }
                });
            }
        }

        return {
          saveTag,
          tag,
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