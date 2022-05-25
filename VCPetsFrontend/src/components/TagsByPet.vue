<template>
  <div v-bind:class="selected == true ? 'btn btn-info' : 'btn btn-light'" @click="setValue()">{{tagName.name}}</div>
</template>

<script>
import {ref} from 'vue';
import {useStore} from "vuex";

export default {
  name: "TagsByPet",
  props: { 
    tagName: Object,
    tags: {
      type: Array,
      default: () => []
    }
  },
  setup(props, context) {

    const store = useStore();

    const tagName = ref(props.tagName);
    const tags = ref(props.tags);
    const selected = ref(false);
    const setValue = () => {
      selected.value = !selected.value;
      context.emit("seletedTag", tagName, selected.value );

      if(selected.value ){
        store.dispatch("succesRequest",`You Checked ${tagName.value.name}`);
      }else{
        store.dispatch("errorRequest",`You Unchecked ${tagName.value.name}`);
      }
      
    }

    const initialValue = () => {
        selected.value = tags.value.some(tag => tag.id == tagName.value.id);
    }

    return {
      setValue,
      selected,
      initialValue
    }
  },
  mounted(){
    this.initialValue();
  }
}
</script>