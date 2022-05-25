<template>
    <div class="album py-5 bg-light">
        <div class="container">
          <div style="width: 100%;margin-bottom: 1%;">
            <div style="text-align: right;">

              <input type="checkbox" class="btn-check" name="options" id="option0" autocomplete="off" disabled>
              <label class="btn btn-secondary text-info-pet" for="option3">{{amount}} Pets </label>

              <input type="checkbox" class="btn-check" name="options" id="option4" autocomplete="off" checked>
              <label class="btn btn-secondary text-info-pet" for="option3"><router-link  style="text-decoration: none;color: white;" :to='{name:"pet.create"}'>Create Pet</router-link> </label>


              <input type="checkbox" class="btn-check" name="options" id="option1" autocomplete="off" checked>
              <label class="btn btn-secondary text-info-pet" for="option1" @click="findByStatus('available')">AVAILABLE</label>

              <input type="checkbox" class="btn-check" name="options" id="option2" autocomplete="off">
              <label class="btn btn-secondary text-info-pet" for="option2"  @click="findByStatus('pending')">PENDING</label>

              <input type="checkbox" class="btn-check" name="options" id="option3" autocomplete="off">
              <label class="btn btn-secondary text-info-pet" for="option3" @click="findByStatus('sold')">SOLD</label>

              <input type="checkbox" class="btn-check" name="options" id="option5" autocomplete="off" checked>
              <label class="btn btn-secondary text-info-pet" for="option1" @click="findByStatus()">ALL</label>

            </div>
          </div>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col" v-for="pet in pets.value"  :key="pet.id">
              <div class="card shadow-sm">

                <img v-if="pet.photoUrls" class="bd-placeholder-img card-img-top" width="100%" height="225" :src="pet.photoUrls">

                <div class="card-body">
                  <p class="card-text">{{pet.name}} - ({{pet.category.name}})</p>
                  <p class="card-text"> {{pet.status.toUpperCase()}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button v-for="tag in pet.tags" :key="tag.id" type="button" class="btn btn-sm btn-outline-secondary">{{tag.name}}</button>
                    </div>
                    <small class="text-muted">
                      <router-link :to='{name:"pet.edit",params:{id:pet.id}}' class="btn btn-info">Edit</router-link>
                      <button  type="button" class="btn btn-danger" @click="deletePet(pet.id)"  >Delete</button>
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import {ref, reactive} from 'vue';
import {usePetsApi } from "@/composables";

export default {
    name:"CategoryIndex",
    setup() {

    const pets = reactive([]);
    const petOriginal = reactive([]);
    const amount = ref(0);
    const {GetPets,GetPetsByStatus, DeletePet} = usePetsApi();

    const showPets = () => {
      GetPets().then(data => {
        if(data){
          pets.value = data;
          petOriginal.value = data;
          amount.value = pets.value.length;
        }
      });
    }

    const findByStatus = async(status=null) => {
      if(status!=null){
        GetPetsByStatus(status).then(data => {
          if(data){
            pets.value = data;
            amount.value = pets.value.length;
          }
        });
      }else{
        pets.value = petOriginal.value;
        amount.value = pets.value.length;
      }
    }

    const deletePet = (id) => {
      if(confirm("¿Confirm That Tou Wish Delete This Registry?")){
        DeletePet(id).then(data => {
          if(data){
            const index = pets.value.findIndex(object => {
              return object.id === id;
            });

            pets.value.splice(index,1);

            amount.value = pets.value.length;
          }
        });
      }
    }

    return {
      amount,
      pets,
      showPets,
      findByStatus,
      deletePet
    }
  },
    mounted(){
        this.showPets()
    },
}
</script>

<style>


@media only screen and (max-width: 480px) {
  .text-info-pet{font-size: 0.8em;}
}

</style>